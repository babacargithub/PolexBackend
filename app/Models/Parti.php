<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Parti extends Model
{
    use CrudTrait;
    protected $fillable = ["nom","code","formule_id"];

    public function formule(): BelongsTo
    {
        return $this->belongsTo(Formule::class);

    }
    use HasFactory;
}
