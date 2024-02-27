<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cotiz extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ["montant","date_debut","date_fin","libelle"];
    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
    ];
    protected $appends = ['total_verse','nombre_cotisations'];
    public function getTotalVerseAttribute() : float
    {
        return $this->cotisations()->sum('montant');
    }
    public function getNombreCotisationsAttribute(): int
    {
        return $this->cotisations()->count();
    }
    public function cotisations(): HasMany
    {
        return $this->hasMany(CotizVersement::class);
    }
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d/m/Y H:i:s');
    }
}
