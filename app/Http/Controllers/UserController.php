<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function login(){
        return view('login');
    }

    public function loginAuth(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6',

        ]);

        $user = $request->only(['email','password']);

        if(auth()->attempt($user)){
            return redirect()->route('home');
        }else{
            return redirect()->back();
        }
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function profile(){
        $user = Auth::user();
        $orders = $user->orders()->get(); // Menggunakan get() untuk mengambil data langsung
       // Memeriksa hasilnya
    // dd($orders);
    
        return view('User.profile', compact('orders'));
    }




    public function updateUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|confirmed|min:8', // Password opsional, tapi harus dikonfirmasi dan minimal 8 karakter
        ]);
    
        $user = Auth::user();
    
        // Update nama pengguna
        $user->name = $request->name;
    
        // Jika password diberikan, hash terlebih dahulu sebelum disimpan
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);  // Meng-hash password menggunakan bcrypt
        }
    
        // Simpan pengguna yang telah diperbarui
        $user->save();
    
        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
    
    

    


    public function index(Request $request)
    {
        $users = User::where('name','LIKE','%'.$request->search. '%')->orderBy('name','ASC'
        )->simplePaginate(5);
        return view('User.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('User.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'role'=>'required',
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role,
        ]);

        return redirect()->route('user.homeuser')->with('success','Berhasil Menambahkan data akun');
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
    public function edit($id)
    {
        $user=User::find($id);
        return view('User.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|min:3',
            'email'=>'required|email',
            'password'=>'required|min:6',
            'role'=>'required',
        ]);

        User::where('id',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password),
            'role'=>$request->role,
        ]);

        return redirect()->route('user.homeuser')->with('success','Berhasil Mengedit data akun');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        user::where('id',$id)->delete();
        return redirect()->back()->with('success','Berhasil Menghapus Data User');
    }
}
