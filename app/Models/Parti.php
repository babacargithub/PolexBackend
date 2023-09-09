<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Parti extends Model
{
    use CrudTrait;
    protected $fillable = ["nom","code","formule_id"];

    public static function partiOfCurrentUser() : Parti
    {
        $parti =  Parti::whereUserId(request()->user()->id)->first();
        if ($parti == null){
            $parti_user = PartiUser::whereUserId(request()->user()->id)->first();
            if ($parti_user != null) {
                $parti = Parti::whereId($parti_user->parti_id)->first();
                if ($parti == null){
                    throw new NotFoundHttpException('Aucun parti associé avec cet utilisateur');
                }
            }
        }
        return $parti;
    }

    public function formule(): BelongsTo
    {
        return $this->belongsTo(Formule::class);

    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->using(PartiUser::class)
            ->withPivot("disabled");

    }

    use HasFactory;
}
