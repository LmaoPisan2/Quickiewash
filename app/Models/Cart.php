<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Cart extends Model
{
    use HasApiTokens, Notifiable ,HasFactory;

    protected $table = 'cart';
    public $timestamps = false;

    protected $fillable = [
        'id_customer',
        'id_pembayaran',
        'id_category',
        'jumlah',
    ];

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'id_pembayaran', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category', 'id');
    }

    protected $primaryKey = 'id';

}
