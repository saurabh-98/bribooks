<?php

namespace App\Http\Requests\Version;

use Illuminate\Foundation\Http\FormRequest;

class CreateVersionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'exists:books,id'
            ]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
}