<?php

namespace App\Http\Controllers;

use App\Class\Utils;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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
}
