<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccines extends Model
{
    use HasFactory;


    /**
     * Get the user that owns the Vaccines
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vaccine()
    {
        return $this->belongsTo(Spot_Vaccines::class);
    }
}
