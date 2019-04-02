<?php

namespace App\Http\Controllers;
use App\Comment;
use Auth;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
            "commentable"  => "required|string",
            "commentable_id"  => "required|integer",
        ]);
        $comment = Comment::create([
            'body' => $data['comment_body'],
            'commentable' => $data['commentable'],
            'commentable_id' => $data['commentable_id'],
            'created_by'=>Auth::user()->id
        ]);

        if(!$comment){
            return ['Could not save comment'];
        }else{
            return ['Comment saved successfully'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
