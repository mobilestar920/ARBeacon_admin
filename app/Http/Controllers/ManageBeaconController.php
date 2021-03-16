<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Beacon;
use App\BeaconCharacter;
use App\Character;

class ManageBeaconController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return $this->getBeacons();
    }

    public function getBeacons() {
        
        $cond = Beacon::where('id', '>', '0')->orderBy('id');
        $beacons = $cond->get();

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

        $charactData = [];
        $characters = Character::where('id', '>' , '-1')->get();
        foreach ($characters as $character) {
            $dict = [];
            $dict['id'] = $character->id;
            $dict['name'] = $character->name;
            $dict['radius'] = $character->radius;
            $dict['height'] = $character->altitude;
            $dict['size'] = $character->size;
            array_push($charactData, $dict);
        }

        return view('managebeacon', array('beacons' => $beaconList, 'characters' => $charactData));
    }

    public function getCharacters($uuid) {
        $charactData = [];
        $beacon = Beacon::where('uuid', $uuid)->first();
        $beaconCharacters = $beacon->rBeaconCharacters;
        foreach ($beaconCharacters as $beaconCharacter) {
            $character = $beaconCharacter->rCharacter;
            $dict = [];
            $dict['id'] = $character->id;
            $dict['name'] = $character->name;
            $dict['radius'] = $character->radius;
            $dict['height'] = $character->altitude;
            $dict['size'] = $character->size;
            array_push($charactData, $dict);
        }

        return response()->json(['success'=>true, 'characters'=>$charactData]);
    }

    public function addBeacon(Request $request) {
        $uuid = $request->uuid;
        $local = $request->local;
        $content = $request->content;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $device = Beacon::where('uuid', $uuid)->first();
        if ($device != null) {
            return response()->json(["success"=>false, "message"=>"비콘이 이미 존재합니다."]);
        }

        $device = new Beacon();
        $device->uuid = $uuid;
        $device->local = $local;
        $device->content = $content;
        $device->latitude = $latitude;
        $device->longitude = $longitude;
        $device->save();

        return redirect()->back();
    }

    public function editBeacon(Request $reqeust) {
        $beacon_id = $reqeust->beacon_id;
        $local = $reqeust->local;
        $content = $reqeust->content;
        $latitude = $reqeust->latitude;
        $longitude = $reqeust->longitude;

        $device = Beacon::where('id', $beacon_id)->first();

        if ($device == null) {
            return response()->json(["success"=>false, "message"=>"폰이 존재하지 않습니다."]);
        }

        $device->local = $local;
        $device->content = $content;
        $device->latitude = $latitude;
        $device->longitude = $longitude;
        $device->save();

        return redirect()->back();
    }

    public function deleteBeacon($id) {
        $device = Beacon::where('id', $id)->first();
        $device->delete();

        return redirect()->back();
    }

    public function addCharacterToBeacon(Request $request) {
        $beacon_id = $request->beacon_id;
        $character_id = $request->character_id;

        $relation = BeaconCharacter::where('beacon_id', $beacon_id)->first();
        if ($relation != null) {
            return response()->json(["success"=>false, "message"=>"캐랙이 이미 비콘에 등록되였습니다."]);
        }

        $relation = new BeaconCharacter();
        $relation->beacon_id = $beacon_id;
        $relation->character_id = $character_id;
        $relation->save();

        return redirect()->back();
    }
}
