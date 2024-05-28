<?php

namespace App\Http\Controllers;

use App\Class\Utils;
use App\Models\User;
use Firebase\JWT\JWT;
use App\Mail\ResetMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    private function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    /**
     * Authentification de login
     */
    public function login(Request $request)
    {

        $vs = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required'],
        ]);


        if($vs->fails()) return response()->json($vs->errors(), 422);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

 
        if (Auth::attempt($credentials)) {
            $user = User::where("email", $credentials["email"])->first();
            $data =  $user->info_auth;
            $token = JWT::encode($data,env('JWT_SECRET'), 'HS256');
            return response()->json([
                "token" => $token
            ]);
        } 
 
        return response()->json([
            'code'      =>  401,
            'message'   =>  "Verifier votre email ou mot de passe"
        ], 401);
    }

    /**
     * Authentification de registration 
     */
    public function register(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'nom' => "required",
            "email" => 'required|unique:users',
            "password" => 'required|confirmed'
        ]);

        if($vs->fails()) return response()->json($vs->errors(), 422);
        $image= null;

        if($request->hasFile('image')) {
            $image = Utils::storePhoto($request->file('image'), 'user');
        }
        
        $user = User::create([
            "name" => $request->nom,
            "prenom" => $request->prenom,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "telephone" => $request->telephone,
            "sexe" => $request->sexe,
            'image' => $image,
        ]);

        $data =  $user->info_auth;
        $token = JWT::encode($data,env('JWT_SECRET'), 'HS256');
        return response()->json([
            "token" => $token
        ]);
    }

    public function resetpassword(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($vs->fails()) return response()->json($vs->errors(), 422);

        $user = User::where('email', $request->email)->first();

        if(is_null($user)) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }
        $password = $this->generateRandomString(8);

        $user->update([
            'password' => Hash::make($password)
        ]);

        Mail::to($user->email)->send(new ResetMail($password));

        return response()->json([
            'message' => 'Password updated'
        ]);
    }
}
