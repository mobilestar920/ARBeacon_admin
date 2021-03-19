<?php

namespace App\Http\Controllers;

use App\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ManageCharacterController extends Controller
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
        return $this->getCharacters();
    }

    public function getCharacters() {
        $cond = Character::where('id', '>', '0')->orderBy('id');
        $characters = $cond->get();

        $characterList = [];
        foreach ($characters as $character) {
            $data = [];
            $data['id'] = $character->id;
            $data['name'] = $character->name;
            $data['size'] = $character->size;
            $data['radius'] = $character->radius;
            $data['altitude'] = $character->altitude;
            $data['created_at'] = $character->created_at;
            $data['updated_at'] = $character->updated_at;
            array_push($characterList, $data);
        }

        return view('managecharacter', array('characters' => $characterList));
    }

    public function createCharacter(Request $reqeust) {
        $name = $reqeust->add_name;
        $size = $reqeust->add_size;
        $radius = $reqeust->add_radius;
        $altitude = $reqeust->add_altitude;

        $character = Character::where('name', $name)->first();

        if ($character != null) {
            return response()->json(["success"=>false, "message"=>"캐랙이 이미 존재합니다."]);
        }

        $filename = $name.'.unitypackage';
        $file = $reqeust->file('file');

        // Save File To Public Storage
        $tempLocation = storage_path().'/'.'app/public/characters'.'/'.$filename;
        
        if (File::exists($tempLocation)) {
            File::delete($tempLocation);
        }
        
        $file->storeAs('public/characters', $filename);

        $character = new Character();
        $character->name = $name;
        $character->size = $size;
        $character->radius = $radius;
        $character->altitude = $altitude;
        $character->path = 'characters'.'/'.$filename;
        $character->save();

        return redirect()->back();
    }

    public function editCharacter(Request $reqeust) {
        $character_id = $reqeust->character_id;
        $name = $reqeust->name;
        $size = $reqeust->size;
        $radius = $reqeust->radius;
        $altitude = $reqeust->altitude;

        $character = Character::where('id', $character_id)->first();

        if ($character == null) {
            return response()->json(["success"=>false, "message"=>"캐랙이 존재하지 않습니다."]);
        }

        $character->name = $name;
        $character->size = $size;
        $character->radius = $radius;
        $character->altitude = $altitude;
        $character->save();

        return redirect()->back();
    }

    public function deleteCharacter($id) {
        $character = Character::where('id', $id)->first();
        $character->delete();

        return redirect()->back();
    }
}
