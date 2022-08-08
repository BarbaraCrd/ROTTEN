<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'com_content', 
    ];

    public function getCom() {

        $comment =  DB::table('comments')
                 ->join('users', 'comments.user_id', '=', 'users.id')
                 ->select('comments.com_content', 'comments.user_id'
                 , 'users.firstName', 'comments.movie_id')
                 ->get();
 
         return $comment;
      }

}