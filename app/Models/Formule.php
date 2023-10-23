<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Formule
 *
 * @property boolean $has_pro_validation
 * @property integer $prix
 * @property string $nom
 * @Property ("id")
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $constant_name
 * @method static \Illuminate\Database\Eloquent\Builder|Formule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Formule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Formule query()
 * @method static \Illuminate\Database\Eloquent\Builder|Formule whereConstantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formule whereHasProValidation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formule whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formule wherePrix($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Formule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Formule extends Model
{
    const
        FORMULE_PRO = "pro",
        FORMULE_BASIC = "basic";
    use CrudTrait;
    use HasFactory;
    protected $fillable =["nom","constant_name","prix","has_pro_validation"];
    protected $casts = ["has_pro_validation"=>'boolean'];
}
