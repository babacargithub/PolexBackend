<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultatDepartement extends Model
{
    use HasFactory;
    protected $fillable = [
        "inscrits",
        "votants",
        "suffrages_exprimes",
        "photo_pv",
        "bulletins_nuls",
        "departement_id",
        "candidat_1",
        "candidat_2",
        "candidat_3",
        "candidat_4",
        "candidat_5",
        "candidat_6",
        "candidat_7",
        "candidat_8",
        "candidat_9",
        "candidat_10",
        "candidat_11",
        "candidat_12",
        "candidat_13",
        "candidat_14",
        "candidat_15",
        "candidat_16",
        "candidat_17",
        "candidat_18",
        "candidat_19",
        "candidat_20",
        "candidat_21"
    ];
}
