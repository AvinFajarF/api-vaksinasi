<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "spots" => new SpotsDetailResource($this->spots),
            "vaksinasi_tersedia" => new VaksinResource($this->vaccine)
        ];
    }
}
