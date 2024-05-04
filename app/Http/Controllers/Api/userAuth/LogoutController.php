<?php

namespace App\Http\Controllers\Api\userAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();

            $success['success'] = true;
            $success['message'] = 'success logout';

            return response()->json($success, 200);
        }catch (\Exception $e) {
            // Log the exception or handle it appropriately
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
