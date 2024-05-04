<?php

namespace App\Http\Controllers\Api\userAuth;

use GuzzleHttp\Client;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use App\Notifications\ResetPasswordNotification;
//use Vonage\Client;
//use Vonage\SMS\Message\SMS;
//use Vonage\Client\Credentials\Basic;

class ForgotPasswordController extends Controller
{
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric|exists:users,phone_number',
        ]);
    
        $user = User::where('phone_number', $request->input('phone_number'))->first();
    
        // Generate a 6-digit verification code
        $verificationCode = mt_rand(100000, 999999);
    
        // Save the verification code in the user record
        $user->update(['verification_code' => $verificationCode]);
    
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
         

            $responseContent = $response->getBody()->getContents();
            $responseData = json_decode($responseContent, true);

            if ($response->getStatusCode() !== 200 ) {
                \Log::error('Failed to send verification code: ' . $responseContent);
                return response()->json(['error' => 'Failed to send verification code'], 500);
            }

            $success['success'] = true;
            $success['name'] = $user->name;
            $success['message'] = 'Verification code sent successfully';
          return response()->json($success, 200);
    }

    public function resetPassword(Request $request)
    {
        // Validate the request
        $request->validate(['new_password' => 'required|min:6|confirmed']);
       
        $user = $request->user();
        // Reset the user's password
        $user->update(['password' => bcrypt($request->input('new_password'))]);

        $success['success'] = true;
        $success['name'] = $user->name;
        $success['token'] = $user->createToken('user', ['app:all'])->plainTextToken;
        $success['message'] = 'Password reset successfully';

        return response()->json($success, 200);
    }

   

}
