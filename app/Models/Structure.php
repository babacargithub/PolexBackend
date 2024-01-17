<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Structure extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $fillable = [
        "nom",
        "commune",
        "membre_id",
        "type"
    ];
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Membre::class);
    } public function membre(): BelongsTo
    {
        return $this->belongsTo(Membre::class);
    }
    public function commune(): BelongsTo
    {
        return $this->belongsTo(Commune::class);
    }
    public function membres(): HasMany
    {
        return $this->hasMany(Membre::class);
    }
    protected $appends = [
        "nombre_membres",
        "responsable"
    ];
    public function getNombreMembresAttribute(): int
    {
        return $this->membres()->count();
    }
    public function getResponsableAttribute(): ?string
    {
        return $this->membre()->first() !== null ? $this->membre()->first()->nom_complet : null;
    }
}
