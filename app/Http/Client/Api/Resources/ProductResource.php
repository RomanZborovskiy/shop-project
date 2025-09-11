<?php

namespace App\Http\Client\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description'=>$this->description,
            'price' => $this->price,
            'old_price' => $this->old_price,
            'quantity' => $this->quantity,
            'status'=>$this->status,
            'sku' => $this->sku,
            'slug' => $this->slug,
            'brand' => $this->brand?->name,
            'category'=> $this->category?->name,
        ];
    }
}
