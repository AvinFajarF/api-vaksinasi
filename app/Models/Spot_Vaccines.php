<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot_Vaccines extends Model
{
    use HasFactory;

    protected $table ='spot_vaccines';

    protected $fillable = [
        "spot_id",
        "vaccine_id"
    ];

    public function spots()
{
    return $this->belongsTo(Spots::class, 'spot_id');
}

public function vaccine()
{
    return $this->belongsTo(Vaccines::class, 'vaccine_id');
}



}
