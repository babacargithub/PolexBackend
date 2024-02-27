<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsBatchItem extends Model
{
    const STATUS_EN_ATTENTE = "EN ATTENTE";
    const STATUS_REUSSI = "REUSSI";
    const STATUS_ECHEC = "ECHEC";
    use HasFactory;
    protected $casts = [
        "sent_at" => "datetime",
        "sent" => "boolean",
        "failed" => "boolean"
    ];
    protected $fillable =["sms_batch_id", "telephone", "message", "sent", "failed", "sent_at",'status'];
}
