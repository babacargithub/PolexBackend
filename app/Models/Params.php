<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Params
 *
 * @Property string discriminant_field_name
 * @Property mixed discriminant_field
 * @Property bool check_discriminant
 * @method static first()
 * @property int $id
 * @property string $discriminant_field_name
 * @property mixed $discriminant_field
 * @property bool $check_discriminant
 * @property int $min_count
 * @property int $max_count
 * @property int $count_per_region
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Params newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Params newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Params query()
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereCheckDiscriminant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereCountPerRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereDiscriminantField($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereDiscriminantFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereMaxCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereMinCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Params whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Params extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $casts = ["check_discriminant"=>"boolean"];
    protected $fillable = ["discriminant_field_name","discriminant_field","min_count","max_count","count_per_region","check_discriminant"];
    public static function getParams(): Params
    {
        return self::first();
    }
}
