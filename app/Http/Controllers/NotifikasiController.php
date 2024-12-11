<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index(){
        $notifikasis = Notifikasi::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();

        Notifikasi::where('user_id', Auth::id())->update(['is_read' => true]);

        return view('pages.laundry.notifikasi', compact('notifikasis'));
    }

    public function markAsRead($id)
    {
        $notifikasi = Notifikasi::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

        $notifikasi->update(['is_read' => true]);

        return response()->json(['message' => 'Notifikasi telah ditandai sebagai dibaca.']);
    }
}
