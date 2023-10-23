<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Config
 *
 * @property int $id
 * @property int $minimum_demande
 * @property int $maximum_demande
 * @property mixed|null $fields
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereMaximumDemande($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereMinimumDemande($value)
 * @mixin \Eloquent
 */
class Config extends Model
{
    use HasFactory;
}
