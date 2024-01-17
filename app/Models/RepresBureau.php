<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepresBureau extends Model
{
    use HasFactory;
    protected $table = 'repres_bureaux';
    protected $fillable = [
        "prenom","nom","telephone","num_electeur","bureau_id","parti"
    ];
    public function bureau(): BelongsTo
    {
        return $this->belongsTo(Bureau::class);
    }
}
