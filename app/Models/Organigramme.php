<?php

namespace App\Models;

use Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organigramme extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $fillable = ["type_membre_id","subordinates","position",'type_organigramme'];

    public function typeMembre(): BelongsTo
    {
        return $this->belongsTo(TypeMembre::class);

    }
}
