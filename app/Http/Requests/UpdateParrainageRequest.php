<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateParrainageRequest extends FormRequest
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
            "prenom"=>"min:2|max:50",
            "nom"=>"min:2|max:20",
            "nin"=>"string",
            "num_electeur"=>"digits:9",
            "date_expir"=>"string",
            "region"=>"string",
        ];
    }
}
