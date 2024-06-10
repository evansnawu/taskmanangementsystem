<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'duedate' => ['required', 'date', 'after_or_equal:today'],
            'description' => ['required', 'string'],
            'status' => ['required']
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter task title',
            'title.string' => 'Task title must be a string',
            'duedate.required' => 'Please select task due date',
            'duedate.date' => 'Due date must be a validate date',
        ];
    }
    
}
