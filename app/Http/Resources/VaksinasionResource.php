<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VaksinasionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'dose' => $this->dose,
            "vaccination_date" => $this->date,
            "spot" => new SpotsVaksinasionResource($this->spots),
            "vaccine" => $this->vaksin,
            "vaccinator" => new VacinatorResource($this->vaksinator),
        ];
    }
}
