<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsBatch extends Model
{
    use HasFactory;
    protected $fillable =["reference", "message", "total", "status", "sent_all"];
    public function items(): HasMany
    {
        return $this->hasMany(SmsBatchItem::class);
    }
}
