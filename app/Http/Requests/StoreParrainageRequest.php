<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreParrainageRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "prenom"=>"required|min:3|max:40",
            "nom"=>"required|min:2|max:10",
            "nin"=>"required|integer|digits_between: 13,14",
            "num_electeur"=>"required|integer",
            "bureau"=>"required|integer",
            "region"=>"required|string",
        ];
    }
}
