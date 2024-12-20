<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCuveRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à effectuer cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation pour la requête.
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'volume_max' => 'required|numeric|min:0',
        ];
    }

    /**
     * Messages personnalisés pour les erreurs de validation (facultatif).
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la cuve est obligatoire.',
            'volume_max.required' => 'Le volume maximum est obligatoire.',
            'volume_max.numeric' => 'Le volume maximum doit être un nombre.',
        ];
    }
}