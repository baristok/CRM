<?php

namespace Modules\Deals\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Deals\Models\Deal;
use Modules\Deals\Models\DealsTitle;
use Illuminate\Support\Facades\Auth;
use Exception;

class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::orderBy('deals_title_id', 'asc')->orderBy('position', 'asc')->get();
        $dealsTitle = DealsTitle::all();
        // dd($dealsTitle);
        $defaultTitles = DealsTitle::where('default_title', true)->get();
        $userTitles = DealsTitle::where('default_title', false)->get();
        return view('deals::index', compact('deals', 'dealsTitle', 'defaultTitles', 'userTitles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deals::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|integer',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
            'contact_id' => 'required|exists:contacts,id',
            'deals_title_id' => 'required|exists:deals_titles,id'
        ]);

        // En yüksek position'ı bul ve +1 ekle
        $maxPosition = Deal::where('deals_title_id', $validated['deals_title_id'])->max('position') ?? 0;

        $deal = Deal::create([
            'title' => $validated['title'],
            'value' => $validated['value'],
            'due_date' => $validated['due_date'],
            'description' => $validated['description'],
            'contact_id' => $validated['contact_id'],
            'deals_title_id' => $validated['deals_title_id'],
            'position' => $maxPosition + 1,
        ]);

        return redirect()->route('deals.index')->with('success', 'Deal başarıyla oluşturuldu');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('deals::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('deals::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}

    /**
     * Update deal position and deals_title_id
     */
    public function updatePosition(Request $request)
    {
        try {
            $validated = $request->validate([
                'deal_id' => 'required|exists:deals,id',
                'deals_title_id' => 'required|exists:deals_titles,id',
                'position' => 'required|integer',
            ]);

            $deal = Deal::findOrFail($validated['deal_id']);

            // Eski deals_title_id'yi sakla
            $oldDealsTitleId = $deal->deals_title_id;

            
            if ($oldDealsTitleId !== $validated['deals_title_id']) {
                // Yeni titledeki en yüksek pozisyonu bul    
                $maxPosition = Deal::where('deals_title_id', $validated['deals_title_id'])->max('position') ?? 0;
                $newPosition = $maxPosition + 1;
            } else {
                // Aynı deals_title içinde taşınıyorsa, gelen pozisyonu kullan
                $newPosition = $validated['position'] ?? ($deal->position ?? 0);
            }

            // Deal güncelleme
            $deal->update([
                'deals_title_id' => $validated['deals_title_id'],
                'position' => $newPosition,
            ]);

            // Eski deals_title'daki pozisyonları düzenle
            if ($oldDealsTitleId != $validated['deals_title_id']) {
                Deal::where('deals_title_id', $oldDealsTitleId)
                    ->where('position', '>', $deal->position)
                    ->decrement('position');
            }

            return response()->json(['success' => true, 'message' => 'Deal başarıyla güncellendi']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Deal güncellenemedi: ' . $e->getMessage()], 500);
        }
    }
}
