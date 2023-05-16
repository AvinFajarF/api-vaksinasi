<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConsultasiResource;
use App\Models\Consultacions;
use App\Models\Societies;
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
                "message" => "Unauthorized user"
            ],401);
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
                "message" => "Unauthorized user"
            ],401);
        }
    }
}
