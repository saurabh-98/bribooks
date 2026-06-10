<?php

namespace App\Http\Requests\Upload;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class StoreUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('api')->check();
    }

    public function rules(): array
    {
        return [
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => 'Please upload a file.',
            'file.file'     => 'Invalid file uploaded.',
            'file.mimes'    => 'Only PDF, DOC and DOCX files are allowed.',
            'file.max'      => 'File size must not exceed 10 MB.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {

            $book = $this->route('book');

            if (!$book instanceof Book) {
                return;
            }

            if ($book->author_id !== auth('api')->id()) {

                $validator->errors()->add(
                    'book',
                    'You do not own this book.'
                );
            }
        });
    }
}