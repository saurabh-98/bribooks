<?php

namespace App\Http\Requests\Book;

use App\Http\Requests\BaseApiRequest;

class StoreBookRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255'
            ],

            'description' => [
                'nullable',
                'string'
            ]
        ];
    }
}