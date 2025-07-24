<?php

namespace Modules\Contacts\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contacts\Models\Contacts;
use Illuminate\Support\Facades\Auth;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Contacts\Exports\ContactsExport;
use Modules\Contacts\Imports\ContactsImport;

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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'company_name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'lead_score' => 'required|integer',
                'tags' => 'nullable|string',
            ]);


            Contacts::create($validated);

            return redirect()->route('contacts.index')->with('success', 'Contact created successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kayıt oluşturulamadı')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contact = Contacts::findOrFail($id);
        return response()->json($contact);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'company_name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'lead_score' => 'required|integer',
                'tags' => 'nullable|string',
            ]);

            $contact = Contacts::findOrFail($id);
            $contact->update($validated);

            return redirect()->route('contacts.index')->with('success', 'Contact updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kayıt güncellenemedi')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
    
    /**
     * Export contacts to Excel
     */
    public function export() 
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
    
    /**
     * Import contacts from Excel
     */
    public function import(Request $request) 
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);
            
            Excel::import(new ContactsImport, $request->file('file'));
            
            return redirect()->route('contacts.index')->with('success', 'Kişiler başarıyla içe aktarıldı.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'İçe aktarma başarısız')->with('error_message', $e->getMessage());
        }
    }
}
