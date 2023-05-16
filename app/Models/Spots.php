<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spots extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Spots
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function spots()
    {
        return $this->belongsTo(Spot_Vaccines::class);
    }

    public function regional()
    {
        return $this->belongsTo(Regionals::class);
    }





}
