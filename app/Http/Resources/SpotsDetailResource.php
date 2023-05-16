<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotsDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "nama" => $this->name,
            "alamat" => $this->address,
            "melayani" => $this->serve,
            "kapasitas" => $this->capacity
        ];
    }
}
