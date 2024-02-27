<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuestionSondage extends Model
{
    use HasFactory;
    public $fillable = ["libelle","multiple","sondage_id"];
    protected $casts = [
        "multiple" => "boolean"
    ];
    public function sondage(): BelongsTo
    {
        return $this->belongsTo(Sondage::class);
    }
    public function reponsesAutorisees(): HasMany
    {
        return $this->hasMany(Reponse::class);
    }
    public function reponsesSondages(): HasMany
    {
        return $this->hasMany(ReponseSondage::class);
    }
}
