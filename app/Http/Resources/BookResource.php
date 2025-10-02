<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'title'           => $this->title,
            'isbn'            => $this->isbn,
            'description'     => $this->description,
            'author_id'       => $this->author_id,
            'genre'           => $this->genre,
            'publish_at'      => $this->publish_at,
            'total_copies'    => $this->total_copies,
            'available_copies'=> $this->available_copies,
            'price'           => $this->price,
            'cover_image'     => $this->cover_image,
            'status'          => $this->status,
            'isAvailable' => $this->isAvailable(),
            'author' => new AuthorResource($this->whenLoaded('author')),

        ];
    }
}
