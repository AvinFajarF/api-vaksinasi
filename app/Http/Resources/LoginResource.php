<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->username,
            "born_date" => $this->born_date,
            "gender" => $this->gender,
            "address" => $this->address,
            "token" => $this->login_token,
            "regional" =>  new RegionalResource($this->whenLoaded('regional'))
        ];
    }
}
