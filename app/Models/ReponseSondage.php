<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReponseSondage extends Model
{
    use HasFactory;
    public $fillable = ["reponse_id","question_sondage_id"];
    public function questionSondage(): BelongsTo
    {
        return $this->belongsTo(QuestionSondage::class);
    }
    public function reponse(): BelongsTo
    {
        return $this->belongsTo(Reponse::class);
    }

}
