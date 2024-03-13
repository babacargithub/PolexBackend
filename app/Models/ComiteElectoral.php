<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ComiteElectoral extends Model
{
    use HasFactory;
    protected $fillable = ["nom","departement_id","membre_id"];

    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
    public function membre(): BelongsTo
    {
        return $this->belongsTo(Membre::class);
    }
    public function membresBureau()
    {

    }
    public function membres(): HasMany
    {
        return $this->hasMany(MembreComiteElectoral::class);
    }
}
