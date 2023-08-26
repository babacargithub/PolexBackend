<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parti extends Model
{
    use CrudTrait;
    protected $fillable = ["nom","code","formule_id"];
    use HasFactory;
}
