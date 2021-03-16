<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BeaconCharacter extends Model
{
    protected $table = 'beacon_characters';

    public function rBeacon() {
        return $this->belongsTo(Beacon::class, 'beacon_id');
    }

    public function rCharacter() {
        return $this->belongsTo(Character::class, 'character_id');
    }
}
