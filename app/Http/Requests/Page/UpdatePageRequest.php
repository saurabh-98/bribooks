<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseApiRequest;

class UpdatePageRequest extends BaseApiRequest
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
                'max:255',
            ],

            'content' => [
                'required',
                'string',
            ],

            'page_no' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}