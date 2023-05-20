<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsultasiResource;
use App\Models\Consultacions;
use App\Models\Medical;
use App\Models\Societies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultasiController extends Controller
{
    public function consultasi(Request $request)
    {

        $validasi = $request->validate([
            "disease_history" => "string",
            "current_symptoms" => "string",
            "doctor_notes" => "string",
            "token" => "required"
        ]);


        try {
            $user = Societies::where("login_token", $validasi["token"])->first();

            $validasi["society_id"] = $user->id;

            Consultacions::create($validasi);

            return response()->json([
                "message" => "Request consultation sent successful"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
                "err" => $th->getMessage()
            ], 401);
        }
    }

    public function consultasionAll(Request $request)
    {

        $validasi = $request->validate([
            "token" => "required"
        ]);

        try {

            $sociecity = Societies::where("login_token", $validasi["token"])->first();
            $user = User::where("id", $sociecity->id_card_number)->first();
            $medicalFind = Medical::where("user_id", $user->id)->first();
            if ($medicalFind) {
                $consultasi = Consultacions::all();
               return response()->json([
                "konsultasi" => ConsultasiResource::collection($consultasi)
               ]);
            }else{
                return response()->json([
                    "message" => "Unauthorized user",
                ], 401);
            }



        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
            ], 401);
        }


    }


    public function getConsultasi(Request $request)
    {
        $validasi = $request->validate([
            "token" => "required"
        ]);


        try {
            $user = Societies::where("login_token", $validasi["token"])->first();
            $consultasi = Consultacions::where("society_id", $user->id)->get();

            return response()->json([
                "konsultasi" => ConsultasiResource::collection($consultasi)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
                "error" => $th->getMessage()
            ], 401);
        }
    }


    public function updateStatus(Request $request, $id)
    {

        $validasi = $request->validate([
            "status" => "string|required"
        ]);



        try {
            $consultasi = Consultacions::findOrFail($id);
            $consultasi->status = $validasi["status"];
            $consultasi->save();


            return response()->json([
                "status" => "updated status successfully"
            ]);



        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
            ], 401);
        }



    }


}
