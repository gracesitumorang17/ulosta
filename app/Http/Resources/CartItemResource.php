<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'price' => (int) $this->price,
            'quantity' => (int) $this->quantity,
            'subtotal' => (int) ($this->price * $this->quantity),
            'image' => $this->image,
            'image_url' => $this->image ? asset('image/' . $this->image) : null,
        ];
    }
}
