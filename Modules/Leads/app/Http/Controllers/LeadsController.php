<?php

namespace Modules\Leads\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Leads\Models\Leads;
use Exception;
use Modules\Leads\Models\TagsLeads;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Leads\Exports\LeadsExport;
use Modules\Leads\Imports\LeadsImport;

class LeadsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tags = TagsLeads::all();
        $query = $request->get('search');
        if ($query) {
            $leads = Leads::search($query)->paginate(10);
        } else {
            $leads = Leads::orderBy('name', 'asc')->paginate(10);
        }
        $leads->appends(request()->query());
        return view('leads::index', compact('leads', 'query', 'tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('leads::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) 
    {
        // Barış selam, burada syntaxları düzelttim ve kodu daha okunaklı hale getirdim :)
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'lead_score' => 'required|integer',
                'phone' => 'required|string|max:20',
                'location' => 'required|string|max:255',
                'tags' => 'array',
                'created_date' => 'required|date',
            ]);

            $tags = $request->input('tags');
            $lead = Leads::create($validated);
            $lead->tags()->attach($tags);

            return redirect()->route('leads.index')->with('success', 'Kayıt oluşturuldu');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Kayıt oluşturulamadı')
                ->with('error_message', $e->getMessage());
        }
    }

    

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('leads::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $lead = Leads::with('tags')->findOrFail($id);
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json($lead);
        }
        return view('leads::edit', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) 
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'lead_score' => 'required|integer',
                'phone' => 'required|string|max:20',
                'location' => 'required|string|max:255',
                'tags' => 'array',
                'created_date' => 'required|date',
            ]);
            
            $lead = Leads::findOrFail($id);
            $lead->update($validated);
            
            
            if ($request->has('tags')) {
                $lead->tags()->sync($request->input('tags'));
            }
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Lead updated successfully'
                ]);
            }
            
            return redirect()->route('leads.index')->with('success', 'Kayıt güncellendi');
        } catch (Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kayıt güncellenemedi: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Kayıt güncellenemedi')->with('error_message', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try
        {
            $lead = Leads::find($id);
            $lead->delete();
            // return redirect()->route('leads.index')->with('success', __('leads.lead_deleted'));
        if(request() -> expectsJson())
        {
            return response()->json(['success' => true, 'message' => __('leads.lead_deleted')]);
        }
        return redirect()->route('leads.index')->with('success', __('leads.lead_deleted'));
        }
        catch(Exception $e)
        {
            if(request() -> expectsJson())
            {
                return response()->json(['success' => false, 'message' => 'Kayıt silinemedi: ' . $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Kayıt silinemedi')->with('error_message', $e->getMessage());
        }

    }

    public function details($id)
    {
        $lead = Leads::with('tags')->find($id);
        
        if (!$lead) {
            if (request()->expectsJson()) {
                return response()->json(['error' => 'Lead bulunamadı'], 404);
            }
            return redirect()->route('leads.index')->with('error', 'Lead bulunamadı');
        }
        
        if (request()->expectsJson()) {
            return response()->json($lead);
        }
        
        return view('leads::partials.lead-details', compact('lead'));
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            Excel::import(new LeadsImport, $request->file('file'));
            return redirect()->route('leads.index')->with('success', 'Leadler başarıyla içe aktarıldı.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'İçe aktarma başarısız')->with('error_message', $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new LeadsExport, 'leads.xlsx');
    }


}
