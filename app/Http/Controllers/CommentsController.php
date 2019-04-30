<?php

namespace App\Http\Controllers;
use App\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        abort('404');
    }

    public function create()
    {
        abort('404');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            "comment_body"    => "required|string|min:10",
            "commentable_type"  => "required|string",
            "commentable_id"  => "required|string",
        ]);
        $comment = Comment::create([
            'comment_body' => $data['comment_body'],
            'commentable_type' => $data['commentable_type'],
            'commentable_id' => $data['commentable_id'],
            'user_id'=>Auth::user()->id
        ]);

        if(!$comment){
            return ['Could not save comment'];
        }else{
            return ['Comment saved successfully'];
        }
    }

    public function show($id)
    {
        abort('404');
    }

    public function supervisorComments(Request $request, Evaluation $evaluation){

        TaskUser::update(request()->validate([
            'supervisor_rating'=>'required',
            'supervisor_comment'=>'required',
            'supervisor_id'=>Auth::user()->id
        ]));

        return NULL;
    }
    
    public function directorComments(Request $request, Evaluation $evaluation){

        $status = 'Approved';
        TaskUser::update(request()->validate([
            'director_comment'=>'required',
            'director_id'=>Auth::user()->id,
            'status'=>$status
        ]));

        return NULL;
    }
    
    public function edit(Comment $comment)
    {
       return Comment::findOrFail($comment->id);
    }


    public function update(Request $request, Comment $comment)
    {
        $data = $request->validate([
            "comment_body"    => "required|string|min:10",
            "commentable_type"  => "required|string",
            "commentable_id"  => "required|string",
        ]);
        $comment->update([
            'comment_body' => $data['comment_body'],
            'commentable_type' => $data['commentable_type'],
            'commentable_id' => $data['commentable_id'],
        ]);
    }

    public function destroy($id)
    {
        abort('404');
    }
}
