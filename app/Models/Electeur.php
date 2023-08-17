<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electeur extends Model
{
    use HasFactory;
    protected $fillable = ["prenom","nom","nin","num_electeur","taille","date_naiss","lieu_vote"];
}
