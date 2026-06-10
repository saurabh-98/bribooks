<?php

namespace App\Http\Requests\Review;

use App\Http\Requests\BaseApiRequest;

class ApproveReviewRequest extends BaseApiRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->isReviewer();
    }

    public function rules(): array
    {
        return [
            'remarks' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }
}