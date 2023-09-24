<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'document_id' => 'required|string|exists:documents,id',
            'file' => 'required|image|mimes:jpg,jpeg,png,svg,tiff,pdf',
            'driver' => 'nullable|in:local,s3'
        ];
    }
}
