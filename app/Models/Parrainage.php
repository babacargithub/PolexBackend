<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Parrainage extends Model
{
    use HasFactory;
    //TODO preciser si saisi ou généré
    protected $fillable = ["num_electeur","prenom", "nom", "nin", "taille", "bureau", "region","parti_id"];

    public function parti(): BelongsTo
    {
        return $this->belongsTo(Parti::class);
    }
}
