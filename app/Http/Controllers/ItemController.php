<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Item::where('name', 'LIKE',    '%'.$request->search.'%')->orderBy('name','ASC')->simplePaginate(5);
        return view('items.index',compact('items'));
    }

    public function shopp()
    {
        $items = Item::all();
        return view('shopping.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk gambar
        ]);
    
        // Proses penyimpanan gambar
        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('assets/images'), $imageName);
        }
    
        // Simpan data item ke database
        Item::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'image' => $imageName, // Simpan nama gambar
        ]);
    
        return redirect()->route('item.home')->with('success', 'Berhasil Menambahkan Barang');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
            'stok' => 'required|numeric',
            'deskripsi' => 'required',
        ]);
    
        $item = Item::findOrFail($id);
        $item->update($request->all());
    
        return redirect()->route('item.home')->with('success', 'Berhasil Mengedit Barang');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Item::where('id',$id)->delete();

        return redirect()->back()->with('deleted','Berhasil Menghapus Barang');
    }
}
