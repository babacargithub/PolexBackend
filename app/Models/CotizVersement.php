<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CotizVersement extends Model
{
    use HasFactory;
    protected $fillable = ["cotiz_id",
    "membre_id",
    "reference",
    "paye_par",
        "montant",
        "date_versement"];

    public function cotiz(): BelongsTo
    {
        return $this->belongsTo(Cotiz::class);
    }
    public function membre(): BelongsTo
    {
        return $this->belongsTo(Membre::class);
    }
}
