<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowingRequest extends FormRequest
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
        return [
            'book_id'       => ['required', 'exists:books,id'],
            'member_id'     => ['required', 'exists:members,id'],
            'borrowed_date' => ['required', 'date', 'before_or_equal:today'],
            'due_date'      => ['required', 'date', 'after:borrowed_date'],
            'returned_date' => ['nullable', 'date', 'after_or_equal:borrowed_date'],
            'status'        => ['required', 'in:borrowed,returned,overdue'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'book_id.required'       => 'A book is required.',
            'book_id.exists'         => 'The selected book does not exist.',
            'member_id.required'     => 'A member is required.',
            'member_id.exists'       => 'The selected member does not exist.',
            'borrowed_date.required' => 'The borrowed date is required.',
            'borrowed_date.date'     => 'The borrowed date must be a valid date.',
            'borrowed_date.before_or_equal' => 'The borrowed date cannot be in the future.',
            'due_date.required'      => 'The due date is required.',
            'due_date.date'          => 'The due date must be a valid date.',
            'due_date.after'         => 'The due date must be after the borrowed date.',
            'returned_date.date'     => 'The returned date must be a valid date.',
            'returned_date.after_or_equal' => 'The returned date cannot be before the borrowed date.',
            'status.required'        => 'The borrowing status is required.',
            'status.in'              => 'The status must be either borrowed, returned, or overdue.',
        ];
    }
}
