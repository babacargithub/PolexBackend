<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStructureRequest extends FormRequest
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
            "nom"=>"string",
            "commune"=>"string:exists:communes,nom",
            "membre_id"=>"integer",
            "type"=>["required", Rule::in(['cellule', 'section','coordination',"structure Alliée","fédération","mouvement interne","Autre"]),]
            //
        ];
    }
}
