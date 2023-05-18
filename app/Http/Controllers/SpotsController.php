<?php

namespace App\Http\Controllers;

use App\Http\Resources\SpotsResource;
use App\Http\Resources\VaksinDetailResource;
use App\Models\Societies;
use App\Models\Spot_Vaccines;
use App\Models\Spots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class SpotsController extends Controller
{
    public function spots(Request $request)
    {
        $validasi = $request->validate([
            "token" => "required"
        ]);


        try {
            $user = Societies::where("login_token", $validasi["token"])->first();
            if ($user) {
                $spot = Spot_Vaccines::with('spots')->get();
                foreach ($spot as $spotItem) {
                   if ($spotItem->spots->capacity == 0){
                    return response()->json([
                        "spot" =>  SpotsResource::collection($spot)
                    ]);
                   }
                }
                return response()->json([
                    "spot" =>  SpotsResource::collection($spot)
                ]);
            } else {
                return response()->json([
                    "message" => "Unauthorized user",

                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Unauthorized user",
                "error" => $th->getMessage()
            ], 401);
        }
    }


    public function getSpots(Request $request, $id)
    {

        $validasi = $request->validate([
            "token" => "required"
        ]);

        try {

            $user = Societies::where("login_token", $validasi["token"])->first();
            if ($user) {
                $spot = Spots::findOrFail($id);
                return response()->json([
                    "date" => Date::now()->format('Y-m-d'),
                    "spot" => new VaksinDetailResource($spot),
                    "vaccinations_count" => $spot->capacity
                ]);
            } else {
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
}
