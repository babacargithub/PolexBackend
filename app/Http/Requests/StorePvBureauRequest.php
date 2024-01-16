<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePvBureauRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            //
            'bureau_id' => 'required|integer|exists:bureaux,id|unique:pv_bureaux,bureau_id',
            'votants' => 'required|integer',
            'suffrages_exprimes' => 'required|integer',
            'bulletins_null' => 'required|integer',
            'inscrits' => 'required|integer',
            'resultats' => [
                'required',
                'array',
                //TODO un comment
//                'size:21', // Ensure the array has exactly 21 items
                // Add any other rules specific to the "resultats" array items if needed
            ],
            'resultats.*.candidat_id' => 'required|integer|exists:candidats,id',
            'resultats.*.nombre_voix' => 'required|integer',
        ];
    }
    public function messages()
    {
        return [
            'bureau_id.unique' => 'Les résultats de ce bureau ont déjà été enregistrés',
        ];

    }
}
