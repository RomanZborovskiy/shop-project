<?php

namespace App\Http\Client\Api\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
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
            'quantity' => $this->quantity,
            'price'    => $this->price,
            'subtotal' => $this->quantity * $this->price,
            'product'  => $this->product,
        ];
    }
}
