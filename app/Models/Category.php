<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Category extends Model
{
    use HasFactory;
    protected $table = 'category';
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'harga',
        'icon'
    ];
}
