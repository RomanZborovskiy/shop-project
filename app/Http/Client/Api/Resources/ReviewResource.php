<?php

namespace App\Http\Client\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'rating'=>$this->rating,
            'status' => $this->status,
            'user_id'=> $this->user_id,
            'product_id' => $this->product_id,
            'parent_id' => $this->parent_id,
        ];
    }
}
