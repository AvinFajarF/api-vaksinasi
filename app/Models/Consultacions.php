<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultacions extends Model
{
    use HasFactory;

    protected $table = "consultacions";

    protected $fillable = [
        'society_id',
        'medical_id',
        "status",
        "disease_history",
        "current_symptoms",
        "doctor_notes",
    ];

    protected $attributes = [
        "status" => "pending"
    ];

    /**
     * Get the society that owns the Consultacions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function society()
    {
        return $this->belongsTo(Societies::class, 'id');
    }


    public function medical()
    {
        return $this->belongsTo(Medical::class,"id");
    }
}
