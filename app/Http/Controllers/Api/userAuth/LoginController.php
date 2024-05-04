<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Auth\LoginRequest;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'phone_number' => $request->phone_number,
            'password' => $request->password,
        ];
        $fcm_token = $request->fcm_token;
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Check if the user status is 'unactive' and prevent login
        if ($user->status === 'unactive') {
            return response()->json(['error' => 'انت ممنوع من الدخول راجع الدعم الفني'], 401);
        }

        if ($user->fcm_token == $fcm_token || $user->two_devices == 1) {
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $user->tokens()->delete();
                $success['success'] = true;
                $success['token'] = $user->createToken(request()->userAgent())->plainTextToken;
                $success['id'] = $user->id;
                $success['name'] = $user->name;
                $success['message'] = 'success login';

                return response()->json($success, 200);
            } else {
                return response()->json(['error' => 'Unauthorised'], 401);
            }
        } else {
            $success['success'] = false;
            $success['message'] = $user->name . ', لا يجوز الدخول من جهاز ثاني';
            return response()->json($success, 404);
        }
    }

    
   
}
