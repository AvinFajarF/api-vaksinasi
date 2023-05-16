<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultasiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "status" => $this->status,
            "disease_history" => $this->disease_history,
            "current_symptoms" => $this->current_symptoms,
            "doctor_notes" => $this->doctor_notes,
            "doctor" => $this->medical,
        ];
    }
}
