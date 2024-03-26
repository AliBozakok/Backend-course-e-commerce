<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user', ['except' => ['login','register','forgetPassword','resetPassword']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('user')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('user')->user());
    }


    public function logout()
    {
        auth('user')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }


    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('user')->factory()->getTTL() * 60
        ]);
    }

    public function register(Request $request)
    {
        $input= $request->validate([
            'name'=>['required','string'],
            'email'=>['required','email'],
            'password'=>['required','string'],
            'imgUrl'=>['required']
        ]);
        $user= User::where('email',$input['email'])->first();
        if(!$user)
        {
            User::create($input);
            return response()->json(["message"=>" user is registered successfully"]);
        }
        return response()->json(["message"=>" user is found "]);
    }

    public function forgetPassword(Request $request)
    {
        $input = $request->validate(['email'=>['required','email']]);
        $otp= rand(1000,9999);
        $user= User::where('email',$input)->first();
        if(!$user)
        {
            return response()->json(["message"=>"user not found"]);
        }
        $user->otp= $otp;
        $user->save();
        return response()->json(["stasut"=>"success","otp"=>$otp]);
    }

    public function resetPassword(Request $request)
    {
        $input= $request->validate([
            'email'=>['required','email'],
            'otp'=>['required','numeric'],
            'newPassword'=>['required']
        ]);
        $user= User::where('email',$input['email'])->where('otp',$input['otp'])->first();
        if(!$user)
        {
            return response()->json(["message"=>"user not found"]);
        }
        $user->password=Hash::make( $input['newPassword']);
        $user->save();

        $user->otp= null;
        $user->save();
        return response()->json(["message"=>"new password is correct"]);
    }
}
