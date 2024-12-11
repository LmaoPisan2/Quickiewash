<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index(string $auth) {
        if (Auth::check()) {
            if ($auth == "admin") {
                $data = Pembayaran::all();
    
                // Calculate total pembayaran using the 'total' column
                $totalPembayaran = Pembayaran::sum('total');  // Use 'total' here
    
                $result = array();
                foreach($data as $item) {
                    $nama = User::select('username')->where('id', $item->id_customer)->first()->username;
                    $result[] = [
                        'nama_cust' => $nama,
                        'id_pembayaran' => $item->id,
                        'tanggal_tagihan' => $item->tanggal_tagihan,
                        'berat' => $item->berat,
                        'jumlah' => '' . number_format($item->total, 0, ',', '.'), // Use 'total' here
                        'status' => $item->status,
                        'bukti' => $item->bukti,
                    ];
                }
    
                // Pass the totalPembayaran to the view
                return view('pages.pembayaran-admin', ['data' => $result, 'totalPembayaran' => number_format((float) $totalPembayaran, 0, ',', '.')]);
            } else {
                $data = Pembayaran::where('id_customer', Auth::id())->get();
                $result = array();
                foreach($data as $item) {
                    $result[] = [
                        'id' => $item->id,
                        'tanggal_tagihan' => $item->tanggal_tagihan,
                        'berat' => $item->berat,
                        'jumlah' => '' . number_format($item->total, 0, ',', '.'), // Use 'total' here
                        'status' => $item->status,
                        'bukti' => $item->bukti,
                    ];
                }
    
                return view('pages.pembayaran-customer', ['data' => $result]);
            }
        } else {
            return redirect("/login");
        }
    }

    public function ubah(int $id, int $status) {
        $data = Pembayaran::where('id', $id)->update([
            "status" => $status == 0 ? 'belum lunas' : 'lunas'
        ]);
        return redirect('/laundry/admin');
    }
}
