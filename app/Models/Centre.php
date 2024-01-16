<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Centre extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $fillable = [
        "nom",
        "commune_id",
    ];
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
    public function bureaux(): HasMany
    {
        return $this->hasMany(Bureau::class);
    }
    public function resultats(): HasMany
    {
        return $this->hasMany(ResultatCentre::class);
    }
    public function resultatsBureaux(): HasManyThrough
    {
        return $this->hasManyThrough(ResultatBureau::class, Bureau::class);

    }
}
