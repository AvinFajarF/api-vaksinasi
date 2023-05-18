<?php

namespace App\Http\Controllers;

use App\Models\Consultacions;
use App\Models\Medical;
use App\Models\Societies;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $validasi = $request->validate([
            "token" => "required"
        ]);

        try {

            // cheack user medical
            $user = Societies::where("login_token", $validasi["token"])->first();
            $userCheck = User::findOrFail($user->id_card_number);
            $DoctorChek = Medical::where("user_id", $userCheck->id)->first();


            // get all Consultasion
            $consultasion = Consultacions::all();

            if ($user) {
                if ($DoctorChek) {
                    return response()->json([
                        "data" => $consultasion
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }
    }


    public function update($id, Request $request)
    {


        $validasi = $request->validate([
            "status" => "required|string",
            "token" => "required",
            "doctor_notes" => "required|string",
        ]);

        try {

            // cheack user medical
            $user = Societies::where("login_token", $validasi["token"])->first();
            $userCheck = User::findOrFail($user->id_card_number);
            $DoctorChek = Medical::where("user_id", $userCheck->id)->first();


            // get all Consultasion

            if ($user) {
                if ($DoctorChek) {

                    $getConsultasion = Consultacions::findOrFail($id);
                    $getConsultasion->status = $validasi["status"];
                    $getConsultasion->doctor_notes = $validasi["doctor_notes"];
                    $getConsultasion->doctor_id = $DoctorChek->id;
                    $getConsultasion->save();
                    // $getConsultasion->update(["status" => $validasi["status"], "doctor_id" => $DoctorChek->id]);

                    return response()->json([
                        "data" => "status update successful"
                    ]);
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user"
            ], 401);
        }
    }
}
