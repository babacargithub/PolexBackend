<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parrainage extends Model
{
    use HasFactory;
    protected $fillable = ["num_electeur","prenom", "nom", "nin", "taille", "bureau","date_naiss","annee_naiss","lieu_naiss","centre", "created_at","updated_at", "region","parti_id"];

    public function parti(): BelongsTo
    {
        return $this->belongsTo(Parti::class);
    }
}
