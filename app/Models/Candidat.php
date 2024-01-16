<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;
    use CrudTrait;
    protected $fillable = [
        "nom","position","photo","parti"
    ];
    public function setPhotoAttribute($file): void
    {

        if (env("APP_ENV") != "testing") {
            $attribute_name = "photo";
            $disk = "public";
            $destination_path = "images";
            $new_file_name = md5($file->getClientOriginalName().random_int(1, 9999).time()).'.'.$file->getClientOriginalExtension();

            $file_path = $file->storeAs($destination_path, $new_file_name, $disk);
            $this->attributes[$attribute_name] = $file_path;

        } else {
            $this->attributes["photo"] = $file;
        }

    }
}
