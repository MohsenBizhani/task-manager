<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
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
        return [
            'title' => 'sometimes|required:255',
            'is_done' => 'sometimes|boolean',
            'schedule' => 'sometimes|nullable|date',
            'due_date' => 'sometimes|nullable|date',
            'project_id' => [
                'nullable',
                Rule::in(Auth::user()->memberships->pluck('id')),
            ],
        ];
    }
}
