<?php

namespace App\Models;

use App\Http\Controllers\MembreComiteElectoralController;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComiteRole extends Model
{
    use HasFactory;

    protected $fillable = ["nom","position"];

    public static function createRoles(): array|Collection|\LaravelIdea\Helper\App\Models\_IH_ComiteRole_C
    {
            $items = [];
         foreach (MembreComiteElectoralController::ROLES as $index=>$role) {
            $items[] =["nom" => $role, "position" => $index+1];
        }
            ComiteRole::insertOrIgnore($items);
            return ComiteRole::all();
    }
}
