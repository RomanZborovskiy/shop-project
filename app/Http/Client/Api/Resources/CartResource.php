<?php

namespace App\Http\Client\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'total'    => $this->total_price,
            'status'   => $this->status,
            'products' => PurchaseResource::collection($this->purchases()->with('product:id,name,price,slug')->get()),
        ];
    }
}
