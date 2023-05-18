<?php

namespace App\Http\Controllers;

use App\Http\Resources\LoginResource;
use App\Models\Medical;
use App\Models\Societies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{


    public function register(Request $request)
    {
        $validasi = $request->validate([
            "name" => "string|required",
            "password" => "string|required",
            "born_date" => "date|required",
            "gender" => "required",
            "address" => "string|required",
            "id_card_number" => 'integer|required',
            "regional_id" => 'required',
        ]);

        try {

            $validasi["password"] = Hash::make($validasi["password"]);

            User::create(["username" => $validasi["id_card_number"], "password" => $validasi["password"]]);


            $validasi["login_token"] = md5($validasi["id_card_number"]);

            Societies::create($validasi);

            return response()->json([
                "status" => "success",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "massage" => "err",
                "error" => $th->getMessage()
            ]);
        }
    }


    public function login(Request $request)
    {

        $request->validate([
            "id_card_number" => "integer|required",
            "password" => "required",
        ]);

        try {


            $auth = Auth::attempt(["username" => $request->id_card_number, "password" => $request->password]);

            if ($auth) {

                dd(Auth::login(["username" => $request->id_card_number, "password" => $request->password]));

                // chek midical doctor nya
                $medical = Medical::where("user_id",$request->user()->id)->first();
                if ($medical) {
                    return response()->json([
                            "name" => $medical->name,
                            "role" => $medical->role,
                    ]);
                }

                $token = md5($request->id_card_number);

                $authentcation = Societies::with('regional')->where("id_card_number", $request->id_card_number)->first();
                $authentcation->login_token = md5($token);
                $authentcation->save();

                if ($authentcation) {
                    return response()->json([
                        "boddy" => new LoginResource($authentcation)
                    ]);
                };
            } else {
                return response()->json([
                    "message" => "ID Card Number or Password incorrect"
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "ID Card Number or Password incorrect",
                "error" => $th->getMessage()
            ], 401);
        }
    }


    public function logout(Request $request)
    {

        $validasi = $request->validate([
            "token" => "required"
        ]);

        try {


            $authentcation = Societies::where("login_token", $validasi["token"])->first();
            if ($authentcation) {
                $authentcation->update(["login_token" => ""]);

                Auth::logout();

                return response()->json([
                    "message" => "Logout berhasil"
                ]);
            } else {

                return response()->json([
                    "message" => "Logout success"
                ]);
            }
        } catch (\Throwable $th) {

            return response()->json([
                "message" => "ID Card Number or Password incorrect"
            ], 401);
        }
    }
}
