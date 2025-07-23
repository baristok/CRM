<?php

namespace Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contacts\Models\Contacts;
use Illuminate\Support\Facades\Auth;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contacts::all();
        return view('contacts::index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'lead_score' => 'required|numeric',
        ]);
        
        $contact = new Contacts();
        $contact->name = $request->name;
        $contact->company = $request->company;
        $contact->designation = $request->designation;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->lead_score = $request->lead_score;
        
        // Eğer etiketler varsa
        if ($request->has('taginput-choices')) {
            $contact->tags = json_encode($request->input('taginput-choices'));
        }
        
        $contact->save();
        
        return redirect()->route('contacts.index')->with('success', __('contacts.contact_added'));
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('contacts::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contact = Contacts::find($id);
        
        // AJAX isteği ise JSON döndür
        if (request()->ajax()) {
            return response()->json($contact);
        }
        
        // Normal istek ise view döndür
        $user = Auth::user();
        return view('contacts::edit', compact('contact', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'lead_score' => 'required|numeric',
        ]);
        
        $contact = Contacts::find($id);
        
        if (!$contact) {
            return redirect()->route('contacts.index')->with('error', __('contacts.contact_not_found'));
        }
        
        $contact->name = $request->name;
        $contact->company = $request->company;
        $contact->designation = $request->designation;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->lead_score = $request->lead_score;
        
        // Eğer etiketler varsa
        if ($request->has('taginput-choices')) {
            $contact->tags = json_encode($request->input('taginput-choices'));
        }
        
        $contact->save();
        
        return redirect()->route('contacts.index')->with('success', __('contacts.contact_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
