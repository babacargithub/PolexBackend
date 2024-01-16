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
    }
    public function membres(): HasMany
    {
        return $this->hasMany(Membre::class);
    }
}
