<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultatCentre extends Model
{
    use HasFactory;
    protected $fillable = [
        "candidat_id",
        "nombre_voix",
    ];
   public function candidat(): BelongsTo
   {
       return $this->belongsTo(Candidat::class);

   }
    public function pvCentre(): BelongsTo
    {
        return $this->belongsTo(PvCentre::class);

    }
}
