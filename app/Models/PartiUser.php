<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PartiUser extends Pivot
{
    protected $casts = ["disabled"=>"boolean"];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function partis() : BelongsToMany
    {
        return $this->belongsToMany(Parti::class);
    }
}
