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
            "prenom"=>"min:3|max:50",
            "nom"=>"min:2|max:20",
            "nin"=>"digits_between: 13,14",
            "num_electeur"=>"digits_between: 9,10",
            "date_expir"=>"string",
            "region"=>"string",
        ];
    }
}
