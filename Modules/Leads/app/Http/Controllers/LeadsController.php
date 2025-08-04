<?php

namespace Modules\Leads\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Leads\Models\Leads;
use Exception;
use Modules\Leads\Models\TagsLeads;

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
                'tags' => 'required|array',
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
    public function edit($id)
    {
        return view('leads::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

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
}
