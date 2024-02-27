<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollecteParticipant extends Model
{
    use HasFactory;
    protected $fillable = ["collecte_id","montant","prenom","nom","telephone","reference","paye_par","commentaire"];
    public function collecte(): BelongsTo
    {
        return $this->belongsTo(Collecte::class);
    }
}
