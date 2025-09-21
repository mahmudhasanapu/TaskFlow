<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'status'=> 'required|in:new,in_progress,completed,canceled',
            // 'due_date' => 'nullable|date|after_or_equal:today',
            // 'priority' => 'nullable|in:law,medium,high',
            // 'assigned_to' => 'nullable|exists:users,id',
        ];
    }
}
