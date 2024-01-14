<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarteMembre extends Model
{
    use HasFactory;
    protected $fillable = [
        "numero",
        "membre_id",
    ];
}
