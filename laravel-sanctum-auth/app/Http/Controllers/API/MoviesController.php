<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;
use App\Models\Movie;
   
class MoviesController extends BaseController
{

    public function index()
    {
        $movies = Movie::all();
        return $movies;
    }

    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'genre' => 'required',
            'synopsis' => 'required',
            'date' => 'required',
            'runtime' => 'required',
            'director' => 'required',
            'picture' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $path = "./images/";
        $image_parts = explode(";base64", $request->picture);
        $image_type_aux = explode("./images/", $image_parts[0]);
        $image_type = $image_type_aux;
        $image_en_base64 = base64_decode($image_parts[1]);
        $file = $path . uniqid() . '.png';

        file_put_contents($file, $image_en_base64);

        $movie = new Movie;
        $movie->title = request('title');
        $movie->genre = request('genre');
        $movie->synopsis = request('synopsis');
        $movie->date = request('date');
        $movie->runtime = request('runtime');
        $movie->director = request('director');
        $movie->picture = $file;

        $movie->save();

        return $this->sendResponse($movie, 'Movie created.');
    }

   
    public function show($id)
    {
        $movie = Movie::find($id);
        if (is_null($movie)) {
            return $this->sendError('Movie does not exist.');
        }
        return $this->sendResponse($movie, 'Movie fetched.');
    }
    

    public function update(Request $request, Movie $movie, $id)
    {
        $movie = Movie::find($id);
        $input = $request->all();

        $validator = Validator::make($input, [
            'title',
            'genre',
            'synopsis',
            'date',
            'runtime',
            'director',
            'picture',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $path = "./images/";
        $image_parts = explode(";base64", $request->picture);
        $image_type_aux = explode("./images/", $image_parts[0]);
        $image_type = $image_type_aux;
        $image_en_base64 = base64_decode($image_parts[1]);
        $file = $path . uniqid() . '.png';

        file_put_contents($file, $image_en_base64);

        $movie->title = request('title');
        $movie->genre = request('genre');
        $movie->synopsis = request('synopsis');
        $movie->date = request('date');
        $movie->runtime = request('runtime');
        $movie->director = request('director');
        $movie->picture = $file;
        $movie->save();
        
        return $this->sendResponse($movie, 'Movie updated.');
    }
   
    public function destroy($id)
    {
        $movie = Movie::findOrFail($id);
        $movie->delete();
    }
}