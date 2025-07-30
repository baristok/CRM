<?php

namespace Modules\Companies\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Companies\Models\Companies;
use Exception;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Companies::all();
        return view('companies::index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('companies::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'industry_type' => 'required|string|max:255',
                'rating' => 'required|integer',
                'location' => 'required|string|max:255',
                'website' => 'required|string|max:255',
                'employee_count' => 'required|string|max:255',
                'contact_email' => 'required|email|max:255',
                'since' => 'required|string|max:4', //4 haneli yıl
            ]);
            $company = Companies::create($validated);
            return redirect()->route('companies.index')->with('success', 'Company created successfully');



        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kayıt oluşturulamadı')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('companies::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('companies::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'owner_name' => 'required|string|max:255',
                'industry_type' => 'required|string|max:255',
                'rating' => 'required|integer',
                'location' => 'required|string|max:255',
                'website' => 'required|string|max:255',
                'employee_count' => 'required|integer',
                'contact_email' => 'required|email|max:255',
                'since' => 'required|integer|max:4', //4 haneli yıl
            ]);
            $company = Companies::findOrFail($id);
            $company->update($validated);
            return redirect()->route('companies.index')->with('success', 'Company updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Kayıt güncellenemedi')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
