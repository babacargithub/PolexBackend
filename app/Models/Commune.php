<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Commune extends Model
{
    use HasFactory;
    use CrudTrait;

    public function centres(): HasMany
    {
        return $this->hasMany(Centre::class);

    }
    public function pvBureau(): MorphOne
    {
        return $this->morphOne(PvBureau::class, 'typeable');
    }
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function membres() : HasManyThrough
    {
        return $this->hasManyThrough(Membre::class, Structure::class);
    }public function structures() : HasMany
    {
        return  $this->hasMany(Structure::class);
    }
}
