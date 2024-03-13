<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Centre extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $fillable = [
        "nom",
        "commune_id",
    ];
    protected $appends = ['nombre_electeurs'];
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
    public function representant(): MorphOne
    {
        return $this->morphOne(RepresBureau::class, 'lieu_vote');
    }

    public function pvCentre(): MorphOne
    {
        return $this->morphOne(PvBureau::class, 'typeable');
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
    public function getNombreElecteursAttribute(): int
    {
        return $this->bureaux->sum('nombre_electeurs');
    }

}
