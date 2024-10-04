<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    /**
     * Determina se l'utente è autorizzato a fare questa richiesta.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permettiamo la richiesta
    }

    /**
     * Ottieni le regole di validazione che si applicano alla richiesta.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}
