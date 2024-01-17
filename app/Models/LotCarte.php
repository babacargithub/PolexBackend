<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LotCarte extends Model
{
    use HasFactory;
    protected $fillable = [
        "nombre_carte","type_carte_membre_id","centre_id"
    ];
    public function type_carte_membre(): HasMany
    {
        return $this->hasMany(TypeCarteMembre::class);
    }
    public function membre() : BelongsTo
    {
        return $this->belongsTo(Membre::class);
    }
    public function cartes(): HasMany
    {
        return $this->hasMany(CarteMembre::class);
    }
}
