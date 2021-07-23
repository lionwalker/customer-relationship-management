<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'sometimes|nullable|required_with:email|required_if:bulk,null|string|max:255',
            'last_name' => 'sometimes|nullable|required_with:email|required_if:bulk,null|string|max:255',
            'email' => 'sometimes|nullable|required_with:first_name|required_if:bulk,null|string|email|max:255|unique:customers,email',
            'phone_number' => 'sometimes|nullable|required_with:email|required_if:bulk,null|string|max:15',
            'bulk' => 'sometimes|nullable|required_if:email,null|mimes:csv,txt|max:5000',
        ];
    }
}
