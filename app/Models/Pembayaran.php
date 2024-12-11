<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Pembayaran extends Model
{
    use HasApiTokens, Notifiable;

    protected $table = 'pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_customer',
        'tanggal_mulai',
        'tanggal_selesai',
        'jumlah',
        'total',
        'bukti',
        'status',
        'status_bukti'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'id_customer', 'id');
    }

    protected static function booted()
    {
        static::deleted(function ($pembayaran) {
            Cart::where('id_pembayaran', $pembayaran->id)->delete();
        });
        static::updated(function ($pembayaran) {
            $cart = Cart::where('id_pembayaran', $pembayaran->id)->first();
            if ($cart) {
                $cart->update([
                    'id_customer' => $pembayaran->id_customer,
                    'total' => $pembayaran->total,
                    'bukti' => $pembayaran->bukti,
                    'status' => $pembayaran->status,
                    'jumlah' => $pembayaran->jumlah,
                    'tanggal_mulai' => $pembayaran->tanggal_mulai,
                    'tanggal_selesai' => $pembayaran->tanggal_selesai
                ]);
            }
        });
    }


    // public function carts()
    // {
    //     return $this->hasMany(Cart::class, 'id_pembayaran', 'id');
    // }
}
