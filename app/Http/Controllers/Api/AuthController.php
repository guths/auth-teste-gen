<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
            'cep' => ['required'],
            'street' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'number' => ['required'],
            'district' => ['required'],
        ]);

        $address = Address::create([
            'zip' => $request->cep,
            'street' => $request->street,
            'city' => $request->city,
            'state' => $request->state,
            'number' => $request->number,
            'district' => $request->district,
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address_id' => $address->id,
        ]);

        return response()->json(['msg' => 'Registered Successfully']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['msg' => 'Logout Successfull']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        $tokenData = DB::table('password_resets')
            ->where('token', $request->input('token'))->first();

        $user = User::query()->where('email', $tokenData?->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'We can\'t find a user with that e-mail address.'
            ], 404);
        }

        DB::table('password_resets')->where('email', $user->email)
            ->delete();

        if (!$tokenData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->input('password'))
        ]);

        if (!Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json(['msg' => 'Password Changed Successfully']);
    }
}
