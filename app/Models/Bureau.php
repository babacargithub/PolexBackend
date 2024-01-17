<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bureau extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $table = 'bureaux';
    protected $fillable = [
        "nom",
        "centre_id",
    ];
    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }
    public function representant(): HasOne
    {
        return $this->hasOne(RepresBureau::class);
    }
    public function getNomAttribute(): string
    {
        return 'Bureau Nº '. abs($this->attributes['nom']);

    }

}