<?php

namespace App\Http\Controllers\Api;

use App\Beacon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiLocationController extends Controller {

    public function registerBeacon(Request $request) {
        $uuid = $request->uuid;
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $local = "com.test.test";

        $beacon = Beacon::where('uuid', $uuid)->first();
        if ($beacon != null) {
            return response()->json(['success'=>false, 'message'=>'비콘이 이미 등록되였습니다.']);
        }

        $beacon = new Beacon();
        $beacon->uuid = $uuid;
        $beacon->local = $local;
        $beacon->latitude = $latitude;
        $beacon->longitude = $longitude;
        $beacon->save();

        return response()->json(['success'=>true, 'message'=>'비콘이 성과적으로 등록되였습니다.']);
    }

    public function checkBeacon(Request $request) {
        $uuid = $request->uuid;
        $beacon = Beacon::where('uuid', $uuid)->first();
        if ($beacon != null) {
            return response()->json(['status'=>1, 'message'=>'비콘이 이미 등록되였습니다.']);
        } else {
            return response()->json(['status'=>0, 'message'=>'비콘이 등록되지 않았습니다.']);
        }
    }

    public function getBeaconList() {
        $beacons = Beacon::where('id', '>', '-1')->get();

        $beaconList = [];
        foreach ($beacons as $beacon) {
            $data = [];
            $data['id'] = $beacon->id;
            $data['uuid'] = $beacon->uuid;
            $data['latitude'] = $beacon->latitude;
            $data['longitude'] = $beacon->longitude;
            $data['local'] = $beacon->local;
            $data['content'] = $beacon->content;
            $data['created_at'] = $beacon->created_at;
            $data['updated_at'] = $beacon->updated_at;

            array_push($beaconList, $data);
        }

        return response()->json(['success' => true, 'beacons' => $beaconList]);
    }

    public function getBeaconData($uuid) {
        $beacon = Beacon::where('uuid', $uuid)->first();
        if ($beacon == null) {
            return response()->json(['success' => false, 'message' => 'Beacon not found']);
        }
        $data = [];
        $data['id'] = $beacon->id;
        $data['uuid'] = $beacon->uuid;
        $data['latitude'] = $beacon->latitude;
        $data['longitude'] = $beacon->longitude;
        $data['local'] = $beacon->local;
        $data['content'] = $beacon->content;
        $data['created_at'] = $beacon->created_at;
        $data['updated_at'] = $beacon->updated_at;

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function getCharacterData($uuid) {
        $beacon = Beacon::where('uuid', $uuid)->first();
        if ($beacon == null) {
            return response()->json(['success' => false, 'message' => 'Beacon not found']);
        }

        if ($beacon->rBeaconCharacters->count() > 0) {
            $character = $beacon->rBeaconCharacters[0]->rCharacter;
            $data = [];
            $data['id'] = $character->id;
            $data['name'] = $character->name;
            $data['size'] = $character->size;
            $data['radius'] = $character->radius;
            $data['altitude'] = $character->altitude;

            return response()->json(['success' => true, 'data' => $data]);
        } else {
            return response()->json(['success' => false, 'message' => 'Character not found']);
        }
    }
}