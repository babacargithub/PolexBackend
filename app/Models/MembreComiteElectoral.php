<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembreComiteElectoral extends Model
{
    use HasFactory;
    protected $fillable = ["comite_electoral_id","prenom","nom","telephone","sexe","nin","commune","is_electeur","type_membre_id","objectif","comite_role_id"];
protected $appends = ['nom_complet'];
    public function comiteElectoral(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ComiteElectoral::class);
    }

    public function typeMembre(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(TypeMembre::class);
    }
    public function getNomCompletAttribute(): string
    {
        return ucwords($this->prenom) . ' ' . strtoupper($this->nom);
    }
    public function comiteRole() :BelongsTo
    {
        return $this->belongsTo(ComiteRole::class);

    }
    protected $casts = [
        'is_electeur' => 'boolean',
        "objectif" => "integer"
    ];
}
