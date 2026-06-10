<?php

namespace App\Http\Requests\Chapter;

use App\Http\Requests\BaseApiRequest;

class StoreChapterRequest extends BaseApiRequest
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

            'sort_order' => [
                'nullable',
                'integer',
                'min:1'
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Chapter title is required.',
        ];
    }
}