<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plenipot extends Model
{
    use HasFactory;
    protected $fillable = ["nom","prenom","telephone","nin","num_electeur","departement_id","arrondissement"];

    public function departement(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }
}
