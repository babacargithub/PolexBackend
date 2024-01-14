<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStructureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "nom"=>"required|string",
            "commune"=>"required|string",
            "membre_id"=>"integer",
            "type"=>["required", Rule::in(['cellule', 'section','coordination departementale',"mouvement allie","federation","mouvement interne","autre"]),]
        ];
    }
}
