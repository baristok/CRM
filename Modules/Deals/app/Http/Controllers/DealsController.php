<?php

namespace Modules\Deals\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Deals\Models\Deal;
use Modules\Deals\Models\DealsTitle;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Contracts\ContactServiceInterface;
use App\Contracts\CompanyServiceInterface;

class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContactServiceInterface $contactService, CompanyServiceInterface $companyService)
    {
        $contacts = $contactService->getAllContacts();
        // dd($contacts);
        $companies = $companyService->getAllCompanies();
        $deals = Deal::orderBy('deals_title_id', 'asc')->orderBy('position', 'asc')->get();
        $dealsTitle = DealsTitle::all();
        // dd($dealsTitle);
        $defaultTitles = DealsTitle::where('default_title', true)->get();
        $userTitles = DealsTitle::where('default_title', false)->get();
        return view('deals::index', compact('deals', 'dealsTitle', 'defaultTitles', 'userTitles', 'contacts', 'companies'));
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
        // dd($request->all());
        $owner_type = explode(':', $request->owner_id)[0];
        $owner_id = (int) explode(':', $request->owner_id)[1];
        // dd($owner_type,$owner_id);
        try {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|numeric',
            'currency' => 'required|string|in:TRY,USD',
            'due_date' => 'nullable|date',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'description' => 'nullable|string',
            'owner_id' => 'required|string', // company:1 veya contact:2 formatı
            'deals_title_id' => 'required|exists:deals_titles,id'
        ]);
        $maxPosition = Deal::where('deals_title_id', $validated['deals_title_id'])->max('position') ?? 0;

        $deal = Deal::create([
            'title' => $validated['title'],
            'value' => $validated['value'],
            'currency' => $validated['currency'],
            'due_date' => $validated['due_date'],
            'description' => $validated['description'],
            'owner_id' => $owner_id,
            'owner_type' => $owner_type,
            'deals_title_id' => $validated['deals_title_id'],
            'position' => $maxPosition + 1,
        ]);

            return redirect()->route('deals.index')->with('success', 'Deal başarıyla oluşturuldu');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Deal oluşturulamadı')->with('error_message', $e->getMessage());
        }
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
