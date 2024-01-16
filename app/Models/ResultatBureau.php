<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultatBureau extends Model
{
    use HasFactory;
    protected $fillable = [
        "pv_bureau_id","candidat_id","nombre_voix" ];
    public function candidat(): BelongsTo
    {
        return $this->belongsTo(Candidat::class);
    }
    public function pvBureau(): BelongsTo
    {
        return $this->belongsTo(PvBureau::class);
    }
}
