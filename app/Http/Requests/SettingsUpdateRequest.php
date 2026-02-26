<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url_organization' => [
                'required',
                'string',
                'regex:/^https:\/\/yandex\.(ru|com)\/maps\/org\/.*\/reviews\/$/'
            ],
        ];
    }
}
