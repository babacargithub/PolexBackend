<?php

namespace App\Http\Requests;

use App\Models\Bureau;
use App\Models\Centre;
use App\Rules\Telephone;
use Illuminate\Foundation\Http\FormRequest;

class StoreRepresBureauRequest extends FormRequest
{

   protected function prepareForValidation(): void
   {
       if ( $this->input('type_representant') == 'centre') {
           if ($this->input('commune') == null || $this->input('centre') == null
               ){
               abort(422,'Centre ou commune ne sont pas bien renseignés');
           }
           $centre = Centre::whereNom($this->input('centre'))
               ->whereRelation('commune','nom',$this->input('commune'))
               ->firstOrFail();
           $this->merge([
               'lieu_vote_type' => Centre::class,
               'lieu_vote_id' => $centre->id,
               // More transformations...
           ]);
       }
      else if ( $this->input('type_representant') == 'bureau') {
           $bureau = Bureau::whereId($this->input('lieu_vote_id'))->firstOrFail();
           $this->merge([
               'lieu_vote_type' => Bureau::class,
               'lieu_vote_id' => $bureau->id,
               // More transformations...
           ]);
       }else{
           abort(422, "Le type de representant n'est pas valide");
       }
   }
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
        $rules = [
            "prenom" => "required|string",
            "nom" => "required|string",
            "telephone" => ["required", new Telephone(),"unique:repres_bureaux,telephone"],
            "num_electeur" => "required|integer:digits:9|unique:repres_bureaux,num_electeur",
            'parti'=>'required|string',
            'type_representant'=>'required|string',
            'lieu_vote_id'=>'required|integer',

        ];
        if ($this->input('type_representant') == 'centre'){
            $rules['centre']='required|string';
            $rules['commune']='required|string';
        }
        return  $rules;
    }
}
