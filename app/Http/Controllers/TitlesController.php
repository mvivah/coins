<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Title;
use Session;
use Auth;
class TitlesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return abort(404);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Title::create(request()->validate(
            [
                'name'=>'required|string|max:50',
                'description'=>'required|string|max:200',
                'created_by'=>Auth::user()->id
            ]));
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Title $title)
    {
        return response()->json($title);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Title $title)
    {
        return response()->json($title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Title $title)
    {
        $data = $request->validate([
            'name'=>'required',
            'description'=>'required',
        ]);
        
        $title->update([
            'name' => $data['name'],
            'description'=>$data['description'],
            'updated_by'=>Auth::user()->id]);
        return ['title updated successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Title $title)
    {
        $title->delete();
    }
}
