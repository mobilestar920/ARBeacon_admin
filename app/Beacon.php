<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beacon extends Model
{
    protected $table = 'beacons';

    protected $fillable = [
        'uuid'
    ];

    public function rBeaconCharacters() {
        return $this->hasMany(BeaconCharacter::class, 'beacon_id');
    }
}
