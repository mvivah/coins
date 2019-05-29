<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Session;
use Auth;
class ContactsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index',compact('contacts'));
    }
    public function getcontacts(){
        return Contact::all();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listContacts(Request $request)
    {
        $contacts = Contact::where("account_name","LIKE","%".$request->account_name."%")->limit(10)->get();
        
        if($contacts){
            return $contacts;
        }
    }
        
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'account_name'=>'required|string',
            'contact_country'=>'required|string',
            'full_address'=>'required|string',
            'alternate_address'=>'nullable|string',
            'contact_person'=>'nullable|string',
            'contact_email'=>'nullable|email',
            'contact_phone'=>'nullable|string',
            'alternative_person'=>'nullable|string',
            'alternative_person_email'=>'nullable|email',
            'alternative_person_phone'=>'nullable|string',
        ]);

        $contact = Contact::create([
            "account_name"=>$data['account_name'],
            'country'=> $data['contact_country'],
            'full_address'=> $data['full_address'],
            'alternate_address'=> $data['alternate_address'],
            'contact_person'=> $data['contact_person'],
            'contact_email'=>$data['contact_email'],
            'contact_phone'=>$data['contact_phone'],
            'alternative_person'=>$data['alternative_person'],
            'alternative_person_email'=>$data['alternative_person_email'],
            'alternative_person_phone'=>$data['alternative_person_phone'],
            'created_by'=>Auth::user()->id
        ]);
        if(!$contact){
            throw('Failed to save contact');
        }
        else{
            return ['Contact saved successfully'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getcontact($id)
    {
        $contact = contact::findOrFail($id);
        return $contact;
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show',compact('contact'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Contact::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Contact $contact)
    {
        //return $request;
        //validate the received data
        $data = $request->validate([
            'account_name'=>'nullable|string',
            'contact_country'=>'required|string',
            'full_address'=>'nullable|string',
            'alternate_address'=>'nullable|string',
            'contact_person'=>'nullable|string',
            'contact_email'=>'nullable|email',
            'contact_phone'=>'nullable|string',
            'alternative_person'=>'nullable|string',
            'alternative_person_email'=>'nullable|email',
            'alternative_person_phone'=>'nullable|string',
        ]);

        $run = $contact->update([
            'account_name' => $data['account_name'],
            'country'=> $data['contact_country'],
            'full_address' => $data['full_address'],
            'alternate_address' => $data['alternate_address'],
            'contact_person' => $data['contact_person'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'],
            'alternative_person' => $data['alternative_person'],
            'alternative_person_email' => $data['alternative_person_email'],
            'alternative_person_phone' => $data['alternative_person_phone'],
            'updated_by'=>Auth::user()->id
        ]);
        if(!$run){
            return ['error'=>'Contact not updated'];
        }else{
            return ['Contact updated successfully'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(contact $contact)
    {
        $contact->delete();
    }
}
