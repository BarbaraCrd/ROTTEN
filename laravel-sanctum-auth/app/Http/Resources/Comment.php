<?php
  
namespace App\Http\Resources;
use App\Models\Comment as CommentModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource

{

    public function toArray($request)
    {
        return [
            
            'com_content' => $this->com_content,
            'user_id'=> $this->user_id,
            'firstName' => $this->firstName,
            'movie_id' => $this->movie_id
        ];
    }
    
}