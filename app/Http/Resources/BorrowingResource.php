<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "book_id" => $this->book_id,
            "member_id" => $this->member_id,
            "borrowed_date" => $this->borrowed_date,
            "due_date" => $this->due_date,
            "returened_date" => $this->returened_date,
            "status" => $this->status,
            "isOverdue" => $this->isOverdue(),
            "book" => new BookResource($this->whenLoaded('book')),
            "member" => new MemberResource($this->whenLoaded('member')),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
