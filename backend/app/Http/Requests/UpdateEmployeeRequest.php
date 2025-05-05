<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:employees,email,' . $this->employee->id,
            'department_id' => 'sometimes|required|exists:departments,id',
            'designation' => 'sometimes|required|string|max:255',
            'salary' => 'sometimes|required|numeric',
            'address' => 'sometimes|required|string',
            'joined_date' => 'sometimes|required|date',
        ];
    }
}
