<?php

namespace App\Http\Requests;

use App\Http\Controllers\ParrainageController;
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
            "prenom"=>"required|min:2|max:50",
            "nom"=>"required|min:2|max:20",
            "nin"=>"required||min:13|max:14",
            "num_electeur"=>"required|digits:9",
            "date_expir"=>"required|string",
            "region"=>"required|string",
        ];
    }
    public function transform(): void
    {
        $data = $this->all();

        // Transform the 'field_name' input, for example, to uppercase
        $data['region'] = ParrainageController::isDiasporaRegion($data["region"]) ? "DIASPORA": $data["region"];

        $this->replace($data);
    }
}
