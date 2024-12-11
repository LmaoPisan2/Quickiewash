<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Notifications\NewOrderNotification;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store()
    {
        $attributes = request()->validate([
            'nama' => 'required|max:255|min:2',
            'email' => 'required|email|max:255|unique:users,email',
            'no_hp' => 'required|max:13|min:11',
            'password' => 'required|min:8|max:255',
            'terms' => 'required'
        ]);
        $attributes['auth'] = 'customer';
        $user = User::create($attributes);

        $title = 'Customer Baru';
        $message = 'Ada customer bernama ' . $attributes['nama'];
        $url = '/dashboard/admin/kelolaDataCustomer';

        $admins = User::where('auth', 'admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new NewOrderNotification($title, $message, $url));
        }

        return redirect('/login');
    }
}
