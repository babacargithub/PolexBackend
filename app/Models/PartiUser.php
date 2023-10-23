<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\PartiUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $parti_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool|null $disabled
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parti> $partis
 * @property-read int|null $partis_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser whereDisabled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser wherePartiId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PartiUser whereUserId($value)
 * @mixin \Eloquent
 */
class PartiUser extends Pivot
{
    protected $casts = ["disabled"=>"boolean"];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function partis() : BelongsToMany
    {
        return $this->belongsToMany(Parti::class);
    }
}
