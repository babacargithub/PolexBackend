<?php

namespace App\Models;

use App\Http\Controllers\ParrainageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Electeur
 *
 * @Property string $nom
 * @Property string $prenom
 * @Property string $nin
 * @Property integer $num_electeur
 * @Property string $region
 * @property int $id
 * @property string|null $departement
 * @property string|null $commune
 * @property string|null $centre
 * @property string|null $bureau
 * @property string|null $lieu_naiss
 * @property string|null $commission
 * @property string|null $date_naiss
 * @property int|null $carte_edite
 * @property int|null $taille
 * @method static \Database\Factories\ElecteurFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur query()
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereBureau($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereCarteEdite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereCentre($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereCommune($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereDateNaiss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereDepartement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereLieuNaiss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereNin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereNumElecteur($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur wherePrenom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereSexe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Electeur whereTaille($value)
 * @mixin \Eloquent
 */
class Electeur extends Model
{
    use HasFactory;
    protected $fillable = ["prenom","nom","nin","num_electeur","taille","date_naiss","lieu_vote","region"];
   /* public function getRegionAttribute($value){
        return  ParrainageController::isDiasporaRegion($value)
            ?
            "DIASPORA": $value;

    }*/
}
