<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use DataTables;

class ContactController extends Controller
{
    public function index(Request $request)
    { 
        $Contacts = Contact::orderBy("id","desc")->get();
        return view('admin.contacts.index', compact('Contacts'));
    }
     
    public function destroy(Contact $Contact)
    {
        $Contact->delete();
    
        return redirect()->route('admin.contact.index')->with('success','Contact deleted successfully');
    }
}
