<?php

namespace App\Http\Controllers;

use App\Models\{
    Pembayaran,
    PembayaranWifi,
    User,
};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    private function format_rupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
    public function index() {
        if (Auth::check()) {
            if (Auth::user()->auth == 'admin') {
                return redirect(route('dashboard', ['auth' => 'admin']));
            } else {
                return redirect(route('dashboard', ['auth' => 'customer']));
            }
        } else {
            return redirect("/login");
        }
    }

    public function dashboard() {
        if (Auth::check()) {
            if (Auth::user()->auth == 'admin') {
                // Modify the calculation to sum the 'total' column instead of 'jumlah'
                $totalLaundry = Pembayaran::where('status_bukti', 1)->get()->sum(function ($payment) {
                    return intval(str_replace('.', '', $payment->total)); // Sum the 'total' column
                });
    
                $totalUsers = User::where('auth', 'customer')->count();
                
                // Format the total amount
                $totalPembayaran = $this->format_rupiah($totalLaundry);
    
                return view('pages.dashboard-admin', compact('totalUsers', 'totalPembayaran'));
            } else {
                $userId = Auth::id();
                $recentOrders = Pembayaran::with('users') // Eager load 'users' relationship
                ->where('id_customer', $userId) // Only fetch orders for the logged-in user
                ->orderBy('tanggal_mulai', 'desc') // Sort by 'tanggal_mulai' to get the latest orders
                ->take(5) // Limit to the 5 most recent orders
                ->get();

                // Pass the recent orders and the authenticated user to the view
                return view('pages.dashboard-customer',compact('recentOrders'));
            }
        }
    }
    public function admin() {
        $totalLaundry = Pembayaran::where('status', 'lunas')->get()->sum(function ($payment) {
            return intval(str_replace('.', '', $payment->jumlah));
        });

        $totalUsers = User::count();

        $totalPembayaran = $this->format_rupiah($totalLaundry);


        return view('pages.dashboard-admin', compact('totalUsers', 'totalPembayaran'));

    }

    public function customer() {
        return redirect(route('pembayaran', ['auth' => 'customer']));
    }

}

