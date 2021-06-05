<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'project_name' => "required|string|max:50",
            'description' => "nullable|string|max:500",
            'manager_id' => "required|numeric|exists:users,id",
            'assigned_id' => "required|numeric|exists:users,id|different:manager_id",
            'enabled' => "required|boolean",
        ];
    }
}
