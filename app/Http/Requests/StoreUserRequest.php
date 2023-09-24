<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name'          => 'required|string',
            'department_id' => 'required|exists:departments,id',
            'identity'      => 'required|regex:/^[0-9]{11}([0-9]{3})?$/',
            'phone'         => 'required|regex:/^[0-9]{2}(9?)[0-9]{8}$/',
            'email'         => 'required|email|unique:users,email',
            'username'      => 'required|string|min:2|max:30|regex:/^[A-Za-z0-9_.-]+$/|unique:users,username',
            'password'      => 'required|string|min:6|confirmed',
            'groups'        => 'required|array',
            'groups.*'      => 'required|integer|exists:groups,id'
        ];
    }
}
