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

    public function login(Request $request)
    {
        $validasi =  $request->validate([
            "username" => "string|required",
            "password" => "string|required"
        ]);
        try {

                if (Auth::attempt($validasi)) {

                    $user = Auth::user();
                    Auth::login($user);

                    $findUser = Masyarakat::findOrFail(Auth::user()->id);
                    $findUser->update(["login_token" => $validasi["login_token"] = md5(Str::random(60))]);


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
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "massage" => $th->getMessage(),
            ], 401);
        }
    }


    public function logout($token)
    {
        try {

            $user = Masyarakat::where("login_token", $token)->first();
            if ($user) {

                    Auth::logout($user);

$user->update(["login_token" => '']);

                    return response()->json([
                        "status" => "ok",
                        "massage" => "anda berhasil logout",
                    ], 200);

                }else {
                    return response()->json([
                        "status" => "error",
                        "massage" => "username atau password anda tidak cocok",
                    ], 401);
                }

        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "massage" => "username atau password anda tidak cocok",
            ], 401);
        }
    }


}
