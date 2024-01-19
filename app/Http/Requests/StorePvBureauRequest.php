<?php

namespace App\Http\Requests;

use App\Models\Bureau;
use App\Models\Centre;
use App\Models\Commune;
use App\Models\Departement;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
    protected function prepareForValidation()
    {
        // Transform the input here

        if ( $this->input('type_pv') == 'departement') {
            $departement = Departement::whereNom($this->input('departement'))->firstOrFail();
            $this->merge([
                'typeable_id' =>$departement->id,
                'region_id' => $departement->region_id,
                'departement_id' => $departement->id
                // More transformations...
            ]);
        }else if ( $this->input('type_pv') == 'commune') {
            $commune = Commune::whereNom($this->input('commune'))->firstOrFail();
            $commune->load('departement');
            $this->merge([
                'typeable_id' =>$commune->id,
                'region_id' => $commune->departement->region_id,
                'departement_id' => $commune->departement->id
            ]);
        }else if ( $this->input('type_pv') == 'centre') {
            $centre = Centre::whereNom($this->input('centre'))->firstOrFail();
            $centre->load('commune.departement');
            $this->merge([
                'typeable_id' =>  $centre->id,
                'region_id' => $centre->commune->departement->region_id,
                'departement_id' => $centre->commune->departement->id
            ]);
        }
        else if ( $this->input('type_pv') == 'bureau') {
            $bureau = Bureau::whereId($this->input('bureau_id'))->firstOrFail();
            $bureau->load('centre.commune.departement');
            $this->merge([
                'typeable_id' =>  $bureau->id,
                'region_id' => $bureau->centre->commune->departement->region_id,
                'departement_id' => $bureau->centre->commune->departement->id
            ]);
        }

    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [
            //
            'votants' => 'required|integer',
            'suffrages_exprimes' => 'required|integer',
            'bulletins_nuls' => 'required|integer',
            'type_pv' => 'required|string|in:bureau,centre,commune,departement',
            'inscrits' => 'required|integer',
            'region_id' => 'integer|exists:regions,id',
            'departement_id' => 'integer|exists:departements,id',
            'resultats' => [
                'required',
                'array',
                'size:20', // Ensure the array has exactly 21 items
                // Add any other rules specific to the "resultats" array items if needed
            ],
            'resultats.*.candidat_id' => 'required|integer|exists:candidats,id',
            'resultats.*.nombre_voix' => 'required|integer',

        ];
        if ( $this->input('type_pv') == 'bureau') {
            $rules['typeable_id'] = ['required', 'integer',
                Rule::unique('pv_bureaux')->where(function ($query) {
                    return $query->where('typeable_id', $this->input('bureau_id'))
                        ->where('typeable_type', Bureau::class);
                })
            ];
        } else if ( $this->input('type_pv') == 'centre') {
            $rules['typeable_id'] = ['required', 'integer',
                Rule::unique('pv_bureaux')->where(function ($query) {
                    return $query->where('typeable_id', $this->input('typeable_id'))
                        ->where('typeable_type', Centre::class);
                })
            ];

        } else if ( $this->input('type_pv') == 'departement') {
            $rules['typeable_id'] = ['required', 'integer',
                Rule::unique('pv_bureaux')->where(function ($query) {
                    return $query->where('typeable_id', Departement::whereNom($this->input('departement'))->firstOrFail()->id)
                        ->where('typeable_type', Departement::class);
                })
            ];

        }
        else if ( $this->input('type_pv') == 'commune') {
            $rules['typeable_id'] = ['required', 'string',
                Rule::unique('pv_bureaux')->where(function ($query) {
                    return $query->where('typeable_id', Commune::whereNom($this->input('commune'))->firstOrFail()->id)
                        ->where('typeable_type', Commune::class);
                })
            ];

        }




        return $rules;
    }
    public function messages(): array
    {
        return [
            'typeable_id.unique' => 'Les résultats de ce pv ont déjà été enregistrés',
        ];

    }
}
