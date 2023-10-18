<?php

namespace App\Models;

use App\Http\Controllers\ParrainageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @Property  string $nom
 * @Property  string $prenom
 * @Property  string $nin
 * @Property  integer $num_electeur
 * @Property  string $region
 */
class Electeur extends Model
{
    use HasFactory;
    protected $fillable = ["prenom","nom","nin","num_electeur","taille","date_naiss","lieu_vote","region"];
    public function getRegionAttribute($value){
        return  ParrainageController::isDiasporaRegion($value)
            ?
            "DIASPORA": $value;

    }
}
