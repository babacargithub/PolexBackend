<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PvBureau extends Model
{
    use HasFactory;
    protected $fillable = [
            "bureau_id",
            "inscrits",
            "votants",
            "suffrages_exprimes",
            "bulletins_nuls",
            "photo",
    ];
    protected $table = 'pv_bureaux';
    public function bureau(): BelongsTo
    {
        return $this->belongsTo(Bureau::class);
    }
    public function resultats(): HasMany
    {
        return $this->hasMany(ResultatBureau::class);
    }

}
