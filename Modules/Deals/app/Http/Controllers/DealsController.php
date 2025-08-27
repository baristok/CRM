<?php

namespace Modules\Deals\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Deals\Models\Deal;
use Modules\Deals\Models\DealsTitle;
class DealsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deals = Deal::all();
        $dealsTitle = DealsTitle::all();
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
    public function store(Request $request) {}

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
}
