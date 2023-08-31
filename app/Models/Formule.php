<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @Property("id")
 */
class Formule extends Model
{
    const
        FORMULE_PRO = "pro",
        FORMULE_BASIC = "basic";
    use CrudTrait;
    use HasFactory;
    protected $fillable =["nom","constant_name","prix"];
    protected $casts = ["has_pro_validation"=>'boolean'];
}
