<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchResultResource;
use App\Http\Resources\SearchResultsResource;
use App\Models\Imovel;
use Illuminate\Http\Request;

class ImovelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $imoveis = Imovel::search($query)->paginate(15);
        // return view('search-results', ['imoveis' => $imoveis]);
        // return response()->json(['imoveis' => $imoveis]);
        return response()->json(new SearchResultsResource($imoveis));
        // return response()->json($imoveis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Imovel $imovel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Imovel $imovel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Imovel $imovel)
    {
        //
    }
}
