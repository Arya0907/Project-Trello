<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExports;
use Auth;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('created_at', 'LIKE' ,'%'.request()->search.'%')->simplePaginate(10);
        // dd($orders[0]['items']);
        return view('shopping.index', compact('orders'));
    }

    public function indexAdmin()
    {
        $orders = Order::where('created_at', 'LIKE' ,'%'.request()->search.'%')->simplePaginate(10);
        return view('shopping.rekap-excel', compact('orders'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        // dd($items);
        return view('shopping.create-order', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        // Validasi input quantity
        $request->validate([
          'name_customer' => 'required',
          'items' => 'required',
        ]);

       $hitungjumlah = array_count_values($request->items);
       $arrayFormat = [];
       foreach ($hitungjumlah as $key => $value) {
           $detailItem = Item::find($key);

           if($detailItem['stok'] < $value){
            $msg = 'Tidak dapat membeli Obat ' . $detailItem['name'] . ' 
            sisa stok : '.  $detailItem['stok'];
            return redirect()->back()->withInput()->with('failed', $msg);
        }
           $formatItem = [
            "id" => $key,
            "name_item" => $detailItem['name'],
            "price" => $detailItem['price'],
            "quantity" => $value,
            "sub_price" => ($detailItem['price'] * $value),
            "pajak" =>  ($detailItem['price'] * $value) * 0.1,
           ]; 

           array_push($arrayFormat, $formatItem);
       }


       $totalHarga = 0 ;
       foreach ($arrayFormat as $key => $value) {
           $totalHarga += $value['sub_price'];
       }
    

        // Buat order baru
        $tambahOrder = Order::create([
            'user_id' => auth()->user()->id,
            'name_customer' => $request->name_customer,
            'total_price' => $totalHarga,
            'items' => ($arrayFormat),
        ]);

        if ($tambahOrder) {
          foreach ($arrayFormat as $key => $value) {
              $itemSebelumnya = Item::find($value['id']);
              Item::where('id', $value['id'])->update([
                  'stok' => $itemSebelumnya['stok'] - $value['quantity']
              ]);

          }
          return redirect()->route('order.struck',['id' => $tambahOrder->id])->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        }

       
        // Redirect setelah order berhasil
       
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $carts = $user->carts; 
        // Misalnya, simpan pesanan ke database
        $order = new Order();
        $order->user_id = $user->id;
        $order->items = json_encode($carts);
        $order->name_customer = Auth::user()->name;
        $order->total_price = $carts->sum(function($cart) { return $cart->item->price * $cart->quantity; });
    
        // Menyimpan data item dalam format JSON
        $order->items = $carts->map(function($cart) {
            return [
                'product_id' => $cart->item->id,
                'name_item' => $cart->item->name,
                'quantity' => $cart->quantity,
                'price' => $cart->item->price,
            ];
        });
    
        $order->save();
    
        // Hapus cart setelah checkout
        $carts->each->delete();
    
        return redirect()->route('cart.index')->with('success', 'Checkout berhasil.');
    }
    


    public function storeId($id)
{
    // Ambil item berdasarkan ID
    $item = Item::findOrFail($id);

    // Cek stok apakah mencukupi
    if ($item->stok < 1) {
        return redirect()->back()->with('failed', 'Stok ' . $item->name . ' tidak mencukupi.');
    }

    // Buat order baru
    $order = Order::create([
        'user_id' => auth()->id(),
        'name_customer' => auth()->user()->name, // Contoh: Menggunakan nama pengguna terautentikasi
        'total_price' => $item->price,
        'items' => ([
            [
                'id' => $item->id,
                'name_item' => $item->name,
                'price' => $item->price,
                'quantity' => 1,
                'sub_price' => $item->price,
                'pajak' => $item->price * 0.1,
            ]       
            ])
    ]);

    if ($order) {
        // Kurangi stok item
        $item->decrement('stok', 1);

        // Redirect dengan pesan sukses
        return redirect()->route('home')->with('success', 'Pesanan berhasil dibuat!');
    }

    return redirect()->back()->with('failed', 'Terjadi kesalahan saat memproses pesanan.');
}


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order=Order::find($id);
        return view('shopping.struck', compact('order'));
    }

    public function downloadPdf($id){
        $order=Order::find($id);
        $data = array('order' => $order);
        view('shopping.download-pdf', $order );
        $pdf = PDF::Loadview('shopping.download-pdf',$data);
        return $pdf->download('struck.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadExcel(){

        return Excel::download(new OrdersExports(), 'orders.xlsx');
    }
}
