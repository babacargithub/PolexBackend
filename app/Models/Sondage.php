<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Sondage extends Model
{
    use HasFactory;
    protected $fillable =['titre', 'description'];

    public function questions(): HasMany
    {
        return $this->hasMany(QuestionSondage::class);

    }

    /**
     * @return HasManyThrough
     */
    public function reponses(): HasManyThrough
    {
        return $this->hasManyThrough(ReponseSondage::class, QuestionSondage::class);
    }
}
