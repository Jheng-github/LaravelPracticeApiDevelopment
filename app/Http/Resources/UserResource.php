<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
    //陣列左邊是json出現的值 右邊則是資料庫的值
    
        return [
            'id' => $this->id,
            'role' => $this->role,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
