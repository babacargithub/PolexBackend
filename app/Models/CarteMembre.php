<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarteMembre extends Model
{
    use HasFactory;
    protected $fillable = [
        "numero",
        "membre_id",
    ];
    public function membre(): BelongsTo
    {
        return $this->belongsTo(Membre::class);
    }
}
