<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepresBureau extends Model
{
    use HasFactory;
    protected $table = 'repres_bureaux';
    protected $fillable = [
        "prenom","nom","tel","nin","bureau_id"
    ];
}
