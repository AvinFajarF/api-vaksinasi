<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validasi = $request->validate([
            "username" => "string|required",
            "password" => "string|required",
            "alamat" => "string|required",
            "kota" => "string|required",
        ]);

        try {

            $validasi["login_token"] = md5(Str::random(60));
            $validasi["password"] = Hash::make($validasi["password"]);

            Masyarakat::create($validasi);

            return response()->json([
                "status" => "ok",
                "data" => $validasi
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
            ], 400);
        }
    }

    public function login(Request $request, $token)
    {
        $validasi =  $request->validate([
            "username" => "string|required",
            "password" => "string|required"
        ]);
        try {

            $user = Masyarakat::where("login_token", $token)->first();
            if ($user) {
                if (Auth::attempt($validasi)) {

                    Auth::login($user);

                    return response()->json([
                        "status" => "ok",
                        "massage" => "anda berhasil login",
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "error",
                        "massage" => "username atau password anda tidak cocok",
                    ], 401);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "massage" => "username atau password anda tidak cocok",
            ], 401);
        }
    }
}
