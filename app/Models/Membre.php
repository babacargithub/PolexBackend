<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    public function structure(): BelongsTo
    {
        return $this->belongsTo(Structure::class);
    }
    public function typeMembre(): BelongsTo
    {
        return $this->belongsTo(TypeMembre::class);
    }
    protected $appends = ['nom_complet', 'nom_structure', 'nom_type_membre'];
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
    protected $hidden = ['structure', 'typeMembre'];

}
