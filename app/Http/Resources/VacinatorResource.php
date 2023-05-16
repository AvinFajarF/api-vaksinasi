<?php

namespace App\Http\Resources;

use App\Models\Medical;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VacinatorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $medical = Medical::findOrFail($this->id);
        return [
            "id" => $this->id,
            "role" => $medical->role,
            "name" => $medical->user->username,
        ];
    }
}
