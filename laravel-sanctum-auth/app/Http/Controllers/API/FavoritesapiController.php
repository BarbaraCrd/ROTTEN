<?php

namespace App\Http\Controllers\API;

use Validator;
use App\Models\Favoriteapi;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;

class FavoritesapiController extends BaseController
{

    public function index($id)
    {
        $favapi = Favoriteapi::all()->where('user_id', '=', $id);
        return $favapi;
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required',
            'movie_id' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $favapi = new Favoriteapi;
        $favapi->user_id = request('user_id');
        $favapi->movie_id = request('movie_id');
        $favapi->save();

        return $this->sendResponse($favapi, 'Favorite created.');
    }

    public function destroy($id)
    {
        $favapi = Favoriteapi::findOrFail($id);
        $favapi->delete();
    }
}
