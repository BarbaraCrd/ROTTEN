<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 
        'movie_id',
    ];  

    public function getFav($id) {

        $favorite = DB::table('favorites')
                 ->join('users', 'favorites.user_id', '=', 'users.id')
                 ->join('movies', 'favorites.movie_id', '=', 'movies.id')
                 ->select('favorites.id', 'favorites.movie_id', 'favorites.user_id'
                 , 'movies.title', 'movies.synopsis', 'movies.runtime', 'movies.picture', 'movies.genre', 'movies.date', 'movies.director')
                 ->where('favorites.user_id', '=', $id)
                 ->get();
 
         return $favorite;
      }
}
