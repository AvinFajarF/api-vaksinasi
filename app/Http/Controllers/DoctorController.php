<?php

namespace App\Http\Controllers;

use App\Models\Consultacions;
use App\Models\Medical;
use App\Models\Societies;
use App\Models\User;
use App\Models\Vaccinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

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


    public function DoctorAll()
    {
        try {

            $doctor = Medical::all();
            return response()->json(
                [
                    "data" => $doctor
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function getSpotsDate(Request $request, $id, $date)
    {
        $validasi = $request->validate([
            "token" => "required"
        ]);

        try {
            $user = Societies::where("login_token", $validasi["token"])->first();
            if ($user) {
                return response()->json([
                    "date" => Date::now()->format('Y-m-d'),
                    "data" => Vaccinations::with('spots')->where([
                        ['spot_id', $id],
                        ['date', $date]
                    ])->first()
                ]);
            } else {
                return response()->json([
                    "message" => "Unauthorized user",
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
                "error" => $th->getMessage()
            ], 401);
        }
    }


    public function getVaksinasiCount(Request $request, $id, $date)
    {
        $validasi = $request->validate([
            "token" => "required"
        ]);

        try {
            $user = Societies::where("login_token", $validasi["token"])->first();
            if ($user) {
                return response()->json([
                    "data" => Vaccinations::with('spots')->where([
                        ['spot_id', $id],
                        ['date', $date]
                    ])->count()
                ]);
            } else {
                return response()->json([
                    "message" => "Unauthorized user",
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
                "error" => $th->getMessage()
            ], 401);
        }
    }



}
