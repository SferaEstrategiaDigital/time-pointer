<?php

namespace App\Http\Controllers;

use App\Http\Resources\SearchResultResource;
use App\Models\Imovel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImoveisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(Imovel $imovei)
    {
        // dd(new SearchResultResource($imovei));
        return Inertia::render('Imoveis/Index', [
            'imovel' => new SearchResultResource($imovei)
        ]);
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
