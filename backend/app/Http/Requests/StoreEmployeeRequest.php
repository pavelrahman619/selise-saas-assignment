<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'designation' => 'required|string|max:255',
            'salary' => 'required|numeric',
            'address' => 'required|string',
            'joined_date' => 'required|date',
        ];
    }
}
