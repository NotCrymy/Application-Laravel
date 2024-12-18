<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => 'required|string|max:255',
            'origine' => 'required|string|max:255',
            'volume' => 'required|numeric|min:0',
            'proprietaire_id' => 'required|exists:proprietaires,id',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Le type de moût est obligatoire.',
            'origine.required' => 'L\'origine du moût est obligatoire.',
            'volume.required' => 'Le volume est obligatoire.',
            'volume.numeric' => 'Le volume doit être un nombre.',
            'proprietaire_id.required' => 'Un propriétaire doit être sélectionné.',
            'proprietaire_id.exists' => 'Le propriétaire sélectionné est invalide.',
        ];
    }
}
