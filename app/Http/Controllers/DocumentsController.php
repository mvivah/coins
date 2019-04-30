<?php

namespace App\Http\Controllers;
use Auth;
use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DocumentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
       $documents = Document::all();
       return view('documents.index',compact('documents'));
    }
    
    public function create()
    {
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the received data
        $data = $request->validate([
            "associate_id"  => "nullable",
            "opportunity_id"  => "nullable",
            "project_id"  => "nullable",
            "document"    => "required|file|max:10000|mimes:doc,docx,pdf",
            "document_type"  => "required|string|min:2",
            "file_description"  => "required|string|min:5",
        ]);

        //Get file
        $file = $request->file('document');
        //Get file Extension
        $extension = $request->document->extension();
        //Rename the file and retain the extension
        $filename = $request->input('fileName').'.'.$extension;
        //Upload file and get its destination path
        $destination = $request->input('document_type');
        $url = $request->document->storeAs($destination, $filename);

        //Specify the ID that has been recieved
        if($request->associate_id){
            $done = Document::create([
                'associate_id' => $data['associate_id'],
                'document_url' => $url,
                'description' => $data['file_description'],
                'created_by'=>Auth::user()->id
            ]);
        }elseif($request->opportunity_id){
            $done = Document::create([
                'opportunity_id' => $data['opportunity_id'],
                'document_url' => $url,
                'description' => $data['file_description'],
                'created_by'=>Auth::user()->id
            ]);
        }else{
            $done = Document::create([
                'project_id' => $data['project_id'],
                'document_url' => $url,
                'description' => $data['file_description'],
                'created_by'=>Auth::user()->id
            ]);
        }
        //save data in the documents table
        return redirect()->back()->with('success', 'Document added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
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
