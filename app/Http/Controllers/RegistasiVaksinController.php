<?php

namespace App\Http\Controllers;

use App\Http\Resources\VaksinasionResource;
use App\Models\Consultacions;
use App\Models\Societies;
use App\Models\Vaccinations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class RegistasiVaksinController extends Controller
{


    public function index(Request $request)
    {

        $validasi = $request->validate([
            "token" => "required"
        ]);
        try {

            $user = Societies::where("login_token", $validasi["token"])->first();

            $vaksin = Vaccinations::with(['societies','vaksinator:id,user_id'])->where("society_id", $user->id)->get();

            if(count($vaksin) == 1){
                return response()->json([
                    'vaccinations' => [
                        'first' => new VaksinasionResource($vaksin[0]),
                        'second' => null,
                    ]
                ], 200);
            }elseif (count($vaksin) == 2){
                return response()->json([
                    'vaccinations' => [
                        'first' => new VaksinasionResource($vaksin[0]),
                        'second' => new VaksinasionResource($vaksin[1]),
                    ]
                ], 200);
            }




        } catch (\Throwable $th) {
            return response()->json([
                "pesan" => "pengguna tidak sah",
                "error" => $th->getMessage()
            ], 401);
        }
    }

    public function register(Request $request)
    {

        $validasi = $request->validate(
            [
                "spot_id" => "required",
                "date" => "required|date",
                "token" => "required"
            ],
            [
                "spot_id.required" => "Kolom spot_id wajib di isi",
                "date.date" => "Tanggal tidak cocok dengan format Ymd.",
            ]
        );


        try {
            $user = Societies::where("login_token", $validasi["token"])->first();

            $consultasi = Consultacions::where("society_id", $user->id)->first();
            // dd($user);
            if ($user) {
                if ($consultasi->status === "accepted") {

                    $validasi["society_id"] = $user->id;

                    $dosis = Vaccinations::where("society_id", $user->id)->first();


                    // pengecekan dosisi
                    // if ($dosis && $dosis->dose >= 2) {
                    //     return response()->json([
                    //         "message" => "Masyarakat sudah 2x divaksinasi"
                    //     ]);
                    // }




                    $vaksins = Vaccinations::create($validasi);


                    if ($dosis && $dosis->date) {
                        $tanggalVaksin = Carbon::parse($dosis->date);
                        $tanggalSekarang = Carbon::now();
                        $hariVaksin = $tanggalVaksin->diffInDays($tanggalSekarang);

                        if ($hariVaksin < 30) {
                            return response()->json([
                                "message" => "Wait at least +30 days from 1st Vaccination"
                            ]);
                        }
                    }


                    if ($dosis && $dosis->dose === 1) {
                        $dosis->dose += 1;
                        $dosis->save();
                    } elseif ($dosis && $dosis->dose === 2) {
                        return response()->json([
                            "message" => "Society has been 2x vaccinated"
                        ]);
                    } else {
                        $vaksins["dose"] = 1;
                    }


                    $vaksins->save();

                    return response()->json([
                        "message" => "First|Second vaccination registered successful"
                    ]);
                } else {
                    return response()->json([
                        "message" => "Your consultation must be accepted by doctor before"
                    ]);
                }
            } else {
                return response()->json([
                                    "message" => "Unauthorized user"
                ], 401);
            }
        } catch (\Throwable $th) {
            return response()->json([
                                "message" => "Unauthorized user",
            ], 401);
        }
    }
}
