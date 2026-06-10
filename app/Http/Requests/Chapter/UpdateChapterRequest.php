<?php

namespace App\Http\Requests\Chapter;

use App\Http\Requests\BaseApiRequest;

class UpdateChapterRequest extends BaseApiRequest
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
                'required',
                'integer',
                'min:1'
            ]
        ];
    }
}