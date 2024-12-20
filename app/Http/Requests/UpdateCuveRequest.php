<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCuveRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation qui s'appliquent à la requête.
     */
    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255', // Le nom est obligatoire, doit être une chaîne de caractères et ne pas dépasser 255 caractères
        ];
    }

    /**
     * Messages personnalisés pour les erreurs de validation (facultatif).
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom de la cuve est obligatoire.',
            'nom.string' => 'Le nom de la cuve doit être une chaîne de caractères.',
            'nom.max' => 'Le nom de la cuve ne peut pas dépasser 255 caractères.',
            'volume_max.required' => 'Le volume maximum est obligatoire.',
            'volume_max.numeric' => 'Le volume maximum doit être un nombre.',
            'volume_max.min' => 'Le volume maximum doit être au moins égal à 0.',
        ];
    }
}
