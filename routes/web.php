<?php
use App\Http\Controllers\{
	DashboardController,
	LaundryController,
	RegisterController,
	LoginController,
	PembayaranController,
	ProfileController,
	CartController,
    NotifikasiController
};
use Illuminate\Support\Facades\Route;



//login
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');

//Logout
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::group(['middleware', 'auth'], function () {
	Route::get('/dashboard/{auth}', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');
	Route::get('/pembayaranlaundry/{auth}', [PembayaranController::class, 'index'])->name('pembayaran');
	Route::get('/dashboard/{auth}/category-laundry', [LaundryController::class, 'index'])->name('pages.categorylaundry');
	Route::get('dashboard/{auth}/category', [LaundryController::class, 'index'])->name('pages.category');
	Route::get('/dashboard/{auth}/cart-laundry', [CartController::class, 'index'])->name('pages.cartlaundry');
    Route::get('/dashboard/{auth}/make-order', [CartController::class, 'add'])->name('pages.makeOrder');
	Route::get('/dashboard/{auth}/input-detail/{category}', [LaundryController::class, 'inputDetail'])->name('pages.inputdetail');
	Route::get('/dashboard/{auth}/edit-input-detail/{id}', [LaundryController::class, 'editInputDetail'])->name('pages.editInputdetail');
	Route::get('/dashboard/{auth}/delete-input-detail/{id}', [LaundryController::class, 'deleteInputDetail'])->name('pages.deleteInputdetail');
    Route::post('/dashboard/{auth}/add-laundry', [LaundryController::class, 'tambah'])->name('pages.addlaundry');
    Route::post('/dashboard/{auth}/edit-laundry', [LaundryController::class, 'edit'])->name('pages.editlaundry');
	Route::get('/dashboard/{auth}/history-laundry', [LaundryController::class, 'historyLaundry'])->name('pages.historylaundry');
    Route::post('/updateLaundry', [LaundryController::class, 'update'])->name('pages.updateStatus');
    Route::post('/upload-bukti/', [LaundryController::class, 'upload'])->name('upload.bukti');


	Route::get('/notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi');
    Route::post('/notifikasi/{id}/mark-as-read', [NotifikasiController::class, 'markAsRead'])->name('notifikasi.markAsRead');

	// Profile
	Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
	Route::put('/update-profile/{id}', [ProfileController::class, 'update'])->name('profile.update');

	// Dashboard
	Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('home');

	// Notifikasi
	Route::get('/dashboard/{auth}/notification', [CartController::class, 'showNotifications'])->name('notifications.index')->middleware('auth');
	Route::get('/notifications/mark-as-read/{id}', [CartController::class, 'markAsRead'])->name('notifications.markAsRead');
});
