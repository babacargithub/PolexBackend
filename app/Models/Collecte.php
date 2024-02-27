<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collecte extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["libelle","closed"];
    protected $casts = [
        "closed" => "boolean"
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(CollecteParticipant::class);
    }
    protected $appends = ["total_collecte"];
    public function getTotalCollecteAttribute(): int
    {
        return $this->participants->sum("montant");
    }



}
