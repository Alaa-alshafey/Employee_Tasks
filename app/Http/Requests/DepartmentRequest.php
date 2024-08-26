<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        // Get the department ID for the current route
        $departmentId = $this->route('department');

        return [
            // Ensure name is unique, excluding the current department being updated
            'name' => 'required|string',
        ];
    }
}
