<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societies extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'password',
        "born_date",
        "gender",
        "address",
        "id_card_number",
        "regional_id",
        "login_token",
    ];



    /**
     * Get the user that owns the Societies
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function regional()
    {
        return $this->belongsTo(Regionals::class, 'id');
    }

    /**
     * Get the user that owns the Societies
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Vaccinations()
    {
        return $this->belongsTo(Vaccinations::class);
    }


}
