<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display the landing page with featured items.
     */
    public function index()
    {
        // Ambil 3 item dari tabel `Item`
        $featuredItems = Item::orderBy('created_at', 'desc')->take(3)->get();
        
        // Kirim data `featuredItems` ke view `home`
        return view('home', compact('featuredItems'));
    }
    


    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
