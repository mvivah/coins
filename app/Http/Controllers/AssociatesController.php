<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Associate;
use Session;
use Auth;
class AssociatesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //List of all associates and their contacts
        $associates = Associate::all();
        return view('associates.index',compact('associates'));

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

        //validate the received data
        $data = $request->validate([
            'associate_name'=>'required',
            'associate_gender'=>'required',
            'associate_email'=>'required',
            'associate_country'=>'required',
            'associate_phone'=>'required',
            'associate_phone1'=>'required',
            'date_enrolled'=>'required',
            'associate_expertise'=>'required',
            'associate_specialization'=>'required',
            'associate_experience'=>'required'
        ]);

        //save the validated data
        Associate::create([
            'associate_name' => $data['associate_name'],
            'associate_gender' => $data['associate_gender'],
            'associate_email' => $data['associate_email'],
            'associate_country' => $data['associate_country'],
            'associate_phone' => $data['associate_phone'],
            'associate_phone1' => $data['associate_phone1'],
            'date_enrolled' => $data['date_enrolled'],
            'expertise_id' => $data['associate_expertise'],
            'specialization_id' => $data['associate_specialization'],
            'associate_experience' => $data['associate_experience'],
            'created_by'=>Auth::user()->id
        ]);
        return redirect('associates')->with('success', 'Associate added sucessively');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        $associate = Associate::findOrFail($id);
        return view('associates.show',['associate'=>$associate]);
    }

    //Upload documents**/
    public function getassociates()
    {
        return Associate::all();
    }

    /*****Download associates cv**/
    public function downloadCV($id)
    {
        $associate = Associate::findOrFail($id);
        return Storage::download($associate->cv_url, $associate->name);
    }
     /*****Download associates transcript**/

  public function downloadTranscript($id)
  {
        $associate = Associate::findOrFail($id);
        return Storage::download($associate->transcript_url, $associate->name);
  }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Associate $associate)
    {
        return view('associates.edit',compact('associate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Associate $associate)
    {
        $associate->update(request()->validate(
            ['associate_name'=>'required',
            'associate_gender'=>'required',
            'associate_email'=>'required',
            'associate_country'=>'required',
            'associate_phone'=>'required',
            'associate_phone1'=>'required',
            'date_enrolled'=>'required',
            'associate_expertise'=>'required',
            'associate_experience'=>'required',
            ])+['updated_by'=>Auth::user()->id]);
        return NULL;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Associate $associate)
    {
        $associate->delete();
    }
}
