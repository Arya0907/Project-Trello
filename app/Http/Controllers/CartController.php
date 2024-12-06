<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Order;
use Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', auth()->user()->id)->get(); 
        return view('cart.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function checkout(request $request)
    {
        $user = Auth::user();
        $carts = $user->cartItems; // Ambil semua item di cart pengguna
    
        if ($carts->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }
    
        // Simulasikan proses checkout
        try {
            $totalPrice = 0; // Total harga untuk checkout
            
            // Proses checkout untuk setiap item
            foreach ($carts as $cart) {
                $totalPrice += $cart->item->price * $cart->quantity;
    
                // Buat order baru untuk setiap item yang dibeli
                Order::create([
                    'user_id' => $user->id,
                    'total_price' => $cart->item->price * $cart->quantity,
                    'items' => json_encode([ // Simpan item sebagai JSON
                        'name' => $cart->item->name,
                        'quantity' => $cart->quantity,
                        'price' => $cart->item->price,
                    ]),
                ]);
    
                // Hapus item dari cart setelah dibeli
                $cart->delete();
            }
    
            return response()->json(['success' => true, 'message' => 'Checkout successful!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred during checkout.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {
        $item = Item::findOrFail($id);

        // Cari item di cart untuk user yang sama
        $cartItem = Cart::where('user_id', auth()->user()->id)->where('item_id', $id)->first();
    
        if ($cartItem) {
            // Jika item sudah ada di cart, tambahkan kuantitas
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Jika item belum ada di cart, buat entri baru
            Cart::create([
                'user_id' => auth()->user()->id,
                'item_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cartItem = Cart::findOrFail($id);
    
        if ($cartItem->quantity > 1) {
            // Kurangi quantity sebanyak 1
            $cartItem->quantity -= 1;
            $cartItem->save();
        } else {
            // Jika quantity hanya 1, hapus item dari keranjang
            $cartItem->delete();
        }
    
        return redirect()->route('cart.index')->with('success', 'Item updated in cart');
}

}
