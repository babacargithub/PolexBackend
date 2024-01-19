<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Departement extends Model
{
    use HasFactory;
    protected $fillable = [
        "nom",
        "region_id",
    ];
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
    public function centres(): HasManyThrough
    {
        return $this->hasManyThrough(Centre::class, Commune::class);
    }
    public function structures(): HasManyThrough
    {
        return $this->hasManyThrough(Structure::class, Commune::class);
    }
    public function pvBureau(): MorphOne
    {
        return $this->morphOne(PvBureau::class, 'typeable');
    }
}
