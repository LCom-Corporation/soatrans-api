<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getReservations(Request $request)
    {
        $reservations = $request->user->reservations;
        return response()->json($reservations);
    }

    public function getUsers(Request $request)
    {
        $users = User::where('role', 'user')->get();
        return response()->json($users);
    }

    public function getCashiers(Request $request)
    {
        $cashiers = User::where('role', 'cashier')->get();
        return response()->json($cashiers);
    }

    public function getGuichets(Request $request)
    {
        $guichets = User::where('role', 'guichet')->get();
        return response()->json($guichets);
    }

    public function store(Request $request)
    {
        $vs = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($vs->fails()) {
            return response()->json($vs->errors());
        }
        $user = new User();
        $user->name = $request->name;
        $user->prenom = $request->prenom;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->sexe = $request->sexe;
        $user->telephone = $request->telephone;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json($user);
    }
}
