<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocationRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', 'unique:locations'],
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ];

        if($this->method() === 'PUT') {
            $rules['slug'] = [
              'required',
              'max:255',
              'string',
              Rule::unique('locations')->ignore($this->route('location')), // ignore the current slug
            ];
        }

        return $rules;
    }
}
