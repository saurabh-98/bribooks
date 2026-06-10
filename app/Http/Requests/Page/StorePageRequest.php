<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\BaseApiRequest;

class StorePageRequest extends BaseApiRequest
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

    public function messages(): array
    {
        return [
            'title.required'   => 'Page title is required.',
            'content.required' => 'Page content is required.',
            'page_no.required' => 'Page number is required.',
        ];
    }
}