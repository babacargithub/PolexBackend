<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PvBureau extends Model
{
    use HasFactory;
    protected $fillable = [
            "typeable_id",
            "typeable_type",
            "inscrits",
            "votants",
            "suffrages_exprimes",
            "bulletins_nuls",
            "photo_pv",
            "certifie",
            "region_id",
            'departement_id'

    ];
    protected $table = 'pv_bureaux';
    protected $casts = [
        'certifie' => 'boolean',
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];
    public function typeable(): MorphTo
    {
        return $this->morphTo();
    }
    public function bureau(): MorphTo
    {
        return $this->morphTo('bureau', 'typeable_type', 'typeable_id');
    }
    public function centre(): MorphTo
    {
        return $this->morphTo('centre', 'typeable_type', 'typeable_id');
    }
    public function commune(): MorphTo
    {
        return $this->morphTo('commune', 'typeable_type', 'typeable_id');
    }
    public function departement(): MorphTo
    {
        return $this->morphTo('departement', 'typeable_type', 'typeable_id');
    }
    public function resultats(): HasMany
    {
        return $this->hasMany(ResultatBureau::class);
    }
    public function setPhotoAttribute($file): void
    {

        if (env("APP_ENV") != "testing") {
            $attribute_name = "photo_pv";
            $disk = "public";
            $destination_path = "pv_bureaux";
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif','heic'])){
                abort(422, 'Le type de photo n\'est pas reconnu');
            }
            $new_file_name = 'pv'.$this->id.'.'.$file->getClientOriginalExtension();

            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
            $this->attributes[$attribute_name] = $file_path;

        } else {
            $this->attributes["photo_pv"] = $file;
        }

    }
    public function getPhotoAttribute(): string
    {

        return asset('storage/'.$this->attributes['photo_pv']);

    }

}
