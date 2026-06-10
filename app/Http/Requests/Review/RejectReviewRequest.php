<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\BaseApiRequest;

class RejectReviewRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isReviewer();
    }

    public function rules(): array
    {
        return [
            'remarks' => [
                'required',
                'string',
                'max:1000',
            ],
        ];
    }
}