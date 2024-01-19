<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Membre extends Model
{
    use HasFactory;
    protected $fillable = [
        "nom",
        "prenom",
        "telephone",
        "sexe",
        "nin",
        "commune",
        "structure_id",
        "type_membre_id",
    ];
    public function carte(): HasOne
    {
        return $this->hasOne(CarteMembre::class);
    }
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Structure::class);
    }
    public function typeMembre(): BelongsTo
    {
        return $this->belongsTo(TypeMembre::class);
    }
    protected $appends = ['nom_complet', 'nom_structure', 'nom_type_membre', 'commune','has_card'];
    public function getNomCompletAttribute(): string
    {
        return ucwords($this->prenom) . ' ' . strtoupper($this->nom);
    }
    public function getNomStructureAttribute(): string
    {
        return $this->structure->nom;
    }
    public function getNomTypeMembreAttribute(): string
    {
        return $this->typeMembre->nom;
    }
    public function getCommuneAttribute(): string
    {
        return $this->structure->commune->nom ?? "Inconnu";
    }
    public function getHasCardAttribute(): bool
    {
        return $this->carte()->first() !== null;
    }
    protected $hidden = ['structure', 'typeMembre'];
    protected $casts = [
        'created_at' => 'datetime:d/m/Y H:m:s',
        'updated_at' => 'datetime:d/m/Y H:m:s',
        'is_electeur' => 'boolean',
    ];

}
