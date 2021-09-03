<?php

namespace App\Http\Controllers\API;

use Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Exception;
use Validator;


class UserController extends Controller
{
    /**
     * Register
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
	        'name' => ['required'],
	        'email' => ['required', 'unique:users,email'],
	        'password' => ['required'],
	    ]);

	    if($validator->fails()) {
	        return response()->json(['success' => false,'message' => $validator->messages()]);
	    }

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            $success = true;
            $message = 'User register successfully';
        } catch (Exception $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        return response()->json(['success' => $success,'message' => $message]);
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
	        'email' => ['required', 'exists:users,email'],
	        'password' => ['required'],
	    ]);

	    if($validator->fails()) {
	        return response()->json(['success' => false,'message' => $validator->messages()]);
	    }

        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, true)) {
            $success = true;
            $message = 'User login successfully';
            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
        } else {
            $success = false;
            $message = 'Unauthorised';
        }

       

        return response()->json(['success' => $success,'message' => $message, 'access_token' => $token,
        'token_type' => 'Bearer']);
    }

    /**
     * Logout
     */
    public function logout()
    {
        try {
            Session::flush();
            Auth::guard('web')->logout();
            $success = true;
            $message = 'Successfully logged out';
        } catch (Exception $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        return response()->json(['success' => $success,'message' => $message]);
    }
}
