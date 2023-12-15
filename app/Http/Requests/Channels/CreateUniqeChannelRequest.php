<?php

namespace App\Http\Requests\Channels;

use Illuminate\Foundation\Http\FormRequest;

class CreateUniqeChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|unique:channels,name',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'نام کانال الزامی است.',
            'name.unique' => 'نام کانال تکراری است.',
        ];

    }
}
