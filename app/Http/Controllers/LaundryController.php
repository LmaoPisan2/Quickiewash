<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class LaundryController extends Controller
{
    public function index(Request $request) {
        // Fetch the search query from the request (if any)
        $search = $request->input('search');
    
        // Fetch categories, filtering by the search query if provided
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })->paginate(3) // Paginate 3 items per page
          ->withQueryString(); // Retain the query string in pagination links
    
        // Return the view with categories data
        return view('pages.laundry.category', compact('categories'));
    }
    

    public function tambah(Request $request) {
        $attributes = $request->validate([
            'id_customer' => 'required|exists:users,id',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'sometimes',
            'jumlah' => 'required'
        ]);
        $category = Category::where('nama', $request->category)->first();
        $total = $request->jumlah * $category->harga;
        $attributes['total'] = number_format($total, 0, ',', '.');
        $attributes['bukti'] = '';
        $attributes['status'] = '-1';
        $attributes['status_bukti'] = '0';

        $pembayaran = Pembayaran::create($attributes);

        Cart::create([
            "id_customer" => $request->id_customer,
            "id_pembayaran" => $pembayaran->id,
            "id_category" => $category->id,
            "jumlah" => $request->jumlah
        ]);
        return redirect()->route('pages.cartlaundry', ['auth' => 'admin']);
    }

    public function upload(Request $req) {
        $validated = $req->validate([
            'file_bukti' => 'required|image|mimes:jpeg,jpg,png,gif',
            'id_pembayaran' => 'required|exists:pembayaran,id'
        ]);
        if ($req->file()) {
            $fileName = time().'_'.Auth::user()->nama.'.'.$req->file('file_bukti')->extension();
            $filePath = $req->file('file_bukti')->storeAs('bukti', $fileName, 'public');
            Pembayaran::where('id', $validated['id_pembayaran'])->update([
                "bukti" => "bukti/" . $fileName,
                "status_bukti" => 1,
            ]);
            return redirect()->route('pages.historylaundry', ['auth' => 'customer']);
        }
    }

    public function edit(Request $req)
{
    // Replace 'id' with the actual column that exists in your table (e.g., 'id_pembayaran')
    $cart = Cart::where('id_pembayaran', $req->id_pembayaran)->first();

    if (!$cart) {
        return redirect()->back()->with('error', 'Cart not found.');
    }

    // Calculate the total cost
    $total = $req->jumlah * $cart->category->harga;
    $attributes['total'] = number_format($total, 0, ',', '.');

    // Update the Pembayaran record
    Pembayaran::where('id', $req->id_pembayaran)->update($attributes);

    return redirect()->route('pages.cartlaundry', ['auth' => 'admin']);
}

    public function cart() {
        $carts = Cart::get();
        return view('pages.laundry.cart', compact($carts));
    }

    public function inputDetail($auth, $category) {
        $customers = User::where('auth', 'customer')->get();
        return view('pages.laundry.input-detail', [
            'category' => $category,
            'customers' => $customers
        ]);
    }

    public function editInputDetail($auth, $id) {
        $cart = Cart::where('id_pembayaran', $id)->first();
        $pembayaran = $cart->pembayaran;
        $category = $cart->category->nama;
        $customers = User::where('auth', 'customer')->get();
        return view('pages.laundry.edit-detail', compact('pembayaran', 'customers', 'category'));
    }

    public function deleteInputDetail($auth, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pages.cartlaundry', ['auth' => 'admin'])
                ->with('success', 'Data pembayaran dan cart terkait berhasil dihapus.');
    }

    public function historyLaundry() {
        if (Auth::user()->auth == 'admin') {
            $pembayarans = Pembayaran::all();
        } else {
            $pembayarans = Pembayaran::where('id_customer', Auth::user()->id)->get();
        }
        // var_dump($pembayarans);
        return view('pages.laundry.history-laundry', compact('pembayarans'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'pembayaran_id' => 'required|exists:pembayaran,id',
            'status' => 'required|in:0,1',
            'type' => 'required'
        ]);

        $pembayaran = Pembayaran::find($validated['pembayaran_id']);
        if ($validated['type'] == 'bukti') {
            $pembayaran->update([
                "status_bukti" => $validated['status']
            ]);
        } else {
            if ($validated['status'] == 1) {
                Notifikasi::create([
                    "user_id" => $pembayaran->id_customer,
                    "judul" => "Laundry telah selesai",
                    "pesan" => "Laundry anda telah selesai"
                ]);
            }
            $pembayaran->update([
                "status" => $validated['status']
            ]);
        }
        return response()->json(['success' => true]);
    }
}
