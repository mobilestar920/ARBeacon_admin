<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    protected $table = 'characters';

    public function rBeaconCharacters() {
        return $this->hasMany(BeaconCharacter::class, "character_id");
    }
}
