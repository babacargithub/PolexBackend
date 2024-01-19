<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Bureau extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $table = 'bureaux';
    protected $fillable = [
        "nom",
        "centre_id",

    ];
    public function centre(): BelongsTo
    {
        return $this->belongsTo(Centre::class);
    }
    public function representant(): MorphOne
    {
        return $this->morphOne(RepresBureau::class, 'lieu_vote');
    }
    public function pvBureau(): MorphOne
    {
        return $this->morphOne(PvBureau::class, 'typeable');
    }
    public function typeable(): MorphTo
    {
        return $this->morphTo();

    }
    public function getNomAttribute(): string
    {
        return 'Bureau Nº '. abs($this->attributes['nom']);

    }

}
