<?php

namespace App\Http\Controllers\Api\userAuth;

//require "guzzle/vendor/autoload.php";
use GuzzleHttp\Client;

use Carbon\Carbon;
//use Vonage\Client;
use App\Models\User;
use Illuminate\Support\Str;
use Vonage\SMS\Message\SMS;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
//use Vonage\Client\Credentials\Basic;
use GuzzleHttp\Exception\ClientException;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\RegisterCompleteRequest;
use App\Traits\UploadMultipleImagesTrait;
use Intervention\Image\Facades\Image;
use App\Http\Resources\User\UserResources;



class RegisterController extends Controller
{
    use UploadMultipleImagesTrait;
    public function register(RegisterRequest $request)
    {
 
            $newUser = $request->validated();
            $newUser['password'] = Hash::make($newUser['password']);
            $user = User::create($newUser);
//dd($user);
            // Update FCM token if provided
            if ($request->filled('fcm_token')) {
                $user->update(['fcm_token' => $request->fcm_token]);
            }

            // Generate and send verification code via BulkSMSIraq SMS
            $verificationCode = mt_rand(100000, 999999);
            $client = new Client([
                'base_uri' =>'https://gateway.standingtech.com/api/v4/sms/send',
            ]);

            $body = json_encode([
                'recipient' => $user->phone_number,
                'sender_id' => 'wezary',
                'type' => 'whatsapp',
                'message' => "Your verification code is: $verificationCode",
            ]);

            $response = $client->request('POST', 'send', [
                'headers' => [
                    'Authorization' => 'Bearer 141|YnJeXIJZGAFJn4PUdvGpOGFnlZ7FjZbLlKgIwGbs66b7866e', // Replace with your BulkSMSIraq API key
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'body' => $body,
            ]);
         // dd($response);

            $responseContent = $response->getBody()->getContents();
            $responseData = json_decode($responseContent, true);

            if ($response->getStatusCode() !== 200 ) {
                \Log::error('Failed to send verification code: ' . $responseContent);
                return response()->json(['error' => 'Failed to send verification code'], 500);
            }

            // Save the verification code in the user's record for later verification
            $user->verification_code = $verificationCode;
            $user->save();

            // Generate token and prepare response
            $token = $user->createToken('user', ['app:all'])->plainTextToken;
            $response = [
                'success' => true,
                'token' => $token,
                'name' => $user->name,
                'message' => 'You have received a verification code.',
            ];

            return response()->json($response, 200);
       
    }


    public function verificationCode(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => 'required|numeric|exists:users,phone_number',
                'code' => 'required',
            ]);
    
            // Check if the provided verification code matches the one stored in the user's record
            $user = User::where('phone_number', $request->input('phone_number'))->first();

            // Check if the verification code matches
            if ($user->verification_code != $request->input('code')) {
                return response()->json(['error' => 'Invalid verification code'], 422);
            }
    
            $user->update([
                'is_verified' => true, 
                'verification_code'  => null        
            ]);
    
            $success['success'] = true;
            $success['token'] = $user->createToken('user', ['app:all'])->plainTextToken;
            $success['name'] = $user->name;
            $success['message'] = 'verification code success';
            return response()->json($success, 200);
    
        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function completeRegistration(RegisterCompleteRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $request->user();

            // Check if the user is verified
            if (!$user->is_verified) {
                return response()->json(['error' => 'User not verified'], 422);
            }

            // Generate a unique special code for the user
            $specialCode = Str::random(8); // Adjust the length as needed

            // Process and store the front and back identity images
            $pic_identityF = $request->file('pic_identityF');
            $pic_identityB = $request->file('pic_identityB');
            $uploadedImages = $this->processMultipleImages([$pic_identityF, $pic_identityB], 'User/pic_identity/', true);

            // Update user details
            $user->pic_identityF = $uploadedImages[0] ?? null;
            $user->pic_identityB = $uploadedImages[1] ?? null;
            $user->gender = $data['gender'];
            $user->birth_date = $data['birth_date'];
            $user->academic_level_id = $data['academic_level_id'];
            $user->stage_level_id = $data['stage_level_id'];
            $user->join_date = Carbon::now();
            $user->special_code = $specialCode;
            $user->save();

            // Generate token and prepare success response
            $token = $user->createToken('user', ['app:all'])->plainTextToken;
            $response = [
                'success' => true,
                'token' => $token,
                'user' => new UserResources($user),
                'message' => 'Your registration is completed'
            ];

            return response()->json($response, 200);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }




}    
        



    
    
    

    

