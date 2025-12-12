<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
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
            'product_price' => (int) $this->product_price,
            'product_image' => $this->product_image,
            'product_image_url' => $this->product_image ? asset('image/' . $this->product_image) : null,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
