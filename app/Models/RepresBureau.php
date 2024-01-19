<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RepresBureau extends Model
{
    use HasFactory;
    protected $table = 'repres_bureaux';
    protected $fillable = [
        "prenom","nom","telephone","num_electeur","lieu_vote_type","lieu_vote_id","parti"
    ];
    protected $appends = ['type_representant','lieu_vote'];

    public function lieuVote(): MorphTo
    {
        return $this->morphTo();
    }

//    public function bureau(): MorphTo
//    {
//        return $this->morphTo('lieu_vote', Bureau::class, 'lieu_vote_id');
//    }
//    public function centre(): MorphTo
//    {
//        return $this->morphTo('lieu_vote', Centre::class, 'lieu_vote_id');
//    }
    public function getTypeRepresentantAttribute(): ?string
    {
        return $this->lieu_vote_type == Centre::class ? 'centre' : ($this->lieu_vote_type == Bureau::class ? 'bureau' : null);
    }
    public function getLieuVoteAttribute(): ?string
    {
        if ($this->lieu_vote_type == Centre::class && $this->lieu_vote_type != null)
        {
            if ($this->centre != null)
                return 'Centre : ' . $this->centre->nom;
        }
        else if ($this->lieu_vote_type == Bureau::class && $this->lieu_vote_type != null) {
            if ($this->bureau != null)
                return 'Bureau : ' . $this->bureau->nom;
        }

        return "Inconnu";

    }

}
