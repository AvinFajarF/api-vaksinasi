<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regionals extends Model
{
    use HasFactory;

    protected $fillabel = [
        "province",
        "district"
    ];
}
