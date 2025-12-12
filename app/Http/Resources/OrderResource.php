<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'subtotal' => (int) $this->subtotal,
            'shipping_cost' => (int) $this->shipping_cost,
            'total_amount' => (int) $this->total_amount,
            'shipping_info' => [
                'name' => $this->shipping_first_name,
                'phone' => $this->shipping_phone,
                'address' => $this->shipping_address_1,
                'city' => $this->shipping_city,
                'postal_code' => $this->shipping_postal_code,
            ],
            'items' => $this->whenLoaded('items'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
