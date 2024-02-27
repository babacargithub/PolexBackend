<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TypeMembre extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $fillable = [
        "nom",
    ];
    public function organigramme() : HasOne
    {
        return $this->hasOne(Organigramme::class);
    }

}
