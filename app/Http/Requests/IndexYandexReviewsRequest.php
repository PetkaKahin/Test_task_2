<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexYandexReviewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'page' => [
                'required',
                'integer',
            ],
            'page_size' => [
                'required',
                'integer',
                'max:50',
                'min:1',
            ],
        ];
    }
}
