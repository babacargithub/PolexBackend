<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PvCentre extends Model
{
    use HasFactory;
    protected $fillable = [
        "inscrits",
        "votants",
        "suffrages_exprimes",
        "photo_pv",
        "bulletins_nuls",
        "centre_id",
    ];

    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);

    }
    public function resultats(): HasMany
    {
        return $this->hasMany(ResultatCentre::class);
    }

}
