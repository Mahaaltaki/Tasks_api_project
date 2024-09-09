<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'title'=>'required|string|min:3',
            'description'=>'required|text|min:20|max:1000',
            'status'=>'required|enum[completed,in-progress,pending,faild]',
            'priority'=>'required|enum[low,medium,high]',
            'assigned_to'=>'required|integer',
        ];
    }
}
