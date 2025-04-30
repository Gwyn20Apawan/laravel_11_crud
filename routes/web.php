<?php 
 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
 
Route::get('/', function () { 
    return view('welcome'); 
}); 
Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware('auth');
Route::resource('/products', ProductController::class);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');