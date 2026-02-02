<?php

namespace App\Http\Requests\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class StartRequest extends FormRequest
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
            'name'              => 'required|string|max:255',
            'serial'            => 'required|string|max:255',
            'started_at'        => 'required|date',
            'ended_at'          => 'required|date',
            'opening_balance'   => 'required|numeric',
            'autoclose'         => 'required|in:0,1',
            'opening_notes'     => 'nullable|string',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'serial.required' => 'The serial field is required.',
            'started_at.required' => 'The started at field is required.',
            'ended_at.required' => 'The ended at field is required.',
            'opening_balance.required' => 'The opening balance field is required.',
            'autoclose.required' => 'The autoclose field is required.',
            'opening_notes.required' => 'The opening notes field is required.',
        ];
    }
}
