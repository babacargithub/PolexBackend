<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @Property  string discriminant_field_name
 * @Property  mixed discriminant_field
 * @Property  bool check_discriminant
 * @method static first()
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
