<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccinations extends Model
{
    use HasFactory;

    protected $table = 'vaccinations';

    protected $fillable = [
        "spot_id",
        "dose",
        "date",
        "society_id",
        "vaccine_id",
        "medical_id",
        "status"
    ];


    protected $attributes = [

        'status' => 'pending',

    ];



    /**
     * Get the socitey that owns the Vaccinations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function societies()
    {
        return $this->belongsTo(Societies::class,'society_id', 'id');
    }

    public function spots()
    {
        return $this->belongsTo(Spots::class,'spot_id', 'id');
    }


    public function vaksin()
    {
        return $this->belongsTo(Vaccines::class,"vaccine_id");
    }


    public function vaksinator()
    {
        return $this->belongsTo(Medical::class,"medical_id");
    }





}
