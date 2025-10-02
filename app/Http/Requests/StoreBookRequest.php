<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $bookId = $this->route('book')?->id;
        return [
            'title'           => 'required|string|max:255',
            'isbn'             => [
                $this->isMethod('post') ? 'required' : 'sometimes',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($bookId),
            ],
            'description'     => 'nullable|string',
            'author_id'       => 'required|exists:authors,id',
            'genre'           => 'nullable|string|max:100',
            'publish_at'      => 'required|date|before_or_equal:today',
            'total_copies'    => 'required|integer|min:1',
            'available_copies'=> 'nullable|integer|min:0|lte:total_copies',
            'price'           => 'nullable|numeric|min:0',
            'cover_image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status'          => 'nullable|in:active,inactive',
        ];
    }

}
