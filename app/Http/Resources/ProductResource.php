<?php

namespace App\Http\Resources;

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
            'description' => $this->description,
            'price' => (int) $this->price,
            'stock' => (int) $this->stock,
            'category' => $this->category,
            'tag' => $this->tag,
            'function' => $this->tag, // Alias untuk kegunaan/fungsi
            'image' => $this->image,
            'image_url' => $this->image ? asset('image/' . $this->image) : null,
            'seller' => [
                'id' => $this->user_id,
                'name' => $this->user->name ?? null,
            ],
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
