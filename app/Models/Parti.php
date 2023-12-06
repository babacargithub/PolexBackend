<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * App\Models\Parti
 *
 * @property Formule $formule
 * @property Carbon $created_at
 * @property string $end_point
 * @property int $id
 * @property string $nom
 * @property string $code
 * @property int|null $formule_id
 * @property Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\PartiFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Parti newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parti newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Parti query()
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereEndPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereFormuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereNom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Parti whereUserId($value)
 * @mixin \Eloquent
 */
class Parti extends Model
{
    use CrudTrait;

    protected $fillable = ["nom","code","formule_id","end_point","has_debt"];

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
    public function hasEndpoint(): bool{

        return isset($this->attributes["end_point"]) && $this->attributes["end_point"] != null;
    }
    protected $casts = ["created_at"=>"datetime",'has_debt'=>'bool'];

    use HasFactory;
}
