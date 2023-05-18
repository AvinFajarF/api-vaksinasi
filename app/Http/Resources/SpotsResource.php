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
        if($this->spots->capacity == 0){
            return [
                "spots" => new SpotsDetailResource($this->spots),
                "available_vaccines" => new VaksinNullResource($this->vaccine)
            ];
        }


        return [
            "spots" => new SpotsDetailResource($this->spots),
            "available_vaccines" => new VaksinResource($this->vaccine)
        ];
    }
}
