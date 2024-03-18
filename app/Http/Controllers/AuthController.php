<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordUser;
use App\Mail\VerifEmailUser;
use App\Models\EmailVerif;
use App\Models\LogUser;
use App\Models\PasswordReset;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username Tidak Boleh Kosong',
            'password.required' => 'Password Tidak Boleh Kosong',
        ]);
        $ip = $request->ip();
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'tipe' => 'multi'], 400);
        }
        $username = $request->username;
        $user = User::where('username', $username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'message' => 'Login Gagal! Periksa kembali Email / Password',
                'tipe' => 'single'
            ], 400);
        }
        $log = LogUser::create([
            'ip' => $ip,
            'username' => $username,
            'status' => "SUKSES",
            'filter' => "LOGIN",
            'information' => "User " . $username . " Berhasil LOGIN"
        ]);
        $message = "Selamat Datang " . (string)$user->username;
        return response()->json([
            'message' => $message,
            'data'    => $user,
            'token'   => $user->createToken('authToken')->accessToken
        ], 201);
    }
    public function logout(Request $request)
    {

        $ip = $request->ip();
        $username = $request->user()->username;
        $log = LogUser::create([
            'ip' => $ip,
            'username' => $username,
            'status' => "SUKSES",
            'filter' => "LOGOUT   ",
            'information' => "User " . $username . " Telah Logout"
        ]);
        $removeToken = $request->user()->tokens()->delete();
        if ($removeToken) {
            return response()->json([
                'message' => 'Logout Success!',
            ], 201);
        }
    }
}
