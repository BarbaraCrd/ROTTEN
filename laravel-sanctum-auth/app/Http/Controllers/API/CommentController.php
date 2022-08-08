<?php
   
namespace App\Http\Controllers\API;
   
use Validator;
use App\Models\Comment;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Controllers\API\BaseController as BaseController;
   
class CommentController extends BaseController
{
    public function index()
    {
        $comments = Comment::getCom();
        return $this->sendResponse(CommentResource::collection($comments), 'Comments fetched.');
    }

    public function comments($id)
    {
        $comment = Comment::where('movie_id', $id)->get();
        return $comment;
    }
    
    public function store(Request $request, $id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'com_content' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $comment = new Comment;
        $comment->com_content = request('com_content');
        $comment->user_id = request('user_id');
        $comment->movie_id = $id;

        $comment->save();

        $success = "Post send with success !";
        return back()->withSuccess($success);
        
    }
   
    public function show($id)
    {
        $comment = Comment::find($id);
        if (is_null($comment)) {
            return $this->sendError('Comment does not exist.');
        }
        return $this->sendResponse(new CommentResource($comment), 'Comment fetched.');
    }
    
    public function update(Request $request, Comment $comment)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'com_content' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $comment->com_content = $input['com_content'];
        $comment->save();
        
        return $this->sendResponse(new CommentResource($comment), 'Comment updated.');
    }
   
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->sendResponse([], 'Comment deleted.');
    }
}