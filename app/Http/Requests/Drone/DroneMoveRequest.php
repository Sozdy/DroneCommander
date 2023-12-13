<?php

namespace App\Http\Requests\Drone;

use Illuminate\Foundation\Http\FormRequest;

class DroneMoveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'commands' => 'required|string',
            'start_position' => 'nullable|string',
            'has_walls' => 'nullable|boolean',
        ];
    }
}
