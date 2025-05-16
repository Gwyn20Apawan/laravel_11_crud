<?php 
 
use Illuminate\Support\Facades\Route; 
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FileAuthController;
 
// Redirect root to login if not authenticated
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [RegisterController::class, 'register'])->name('register');
    
    // File Authentication Routes
    Route::get('/file-auth', [FileAuthController::class, 'showFileAuthForm'])->name('file.auth.form');
    Route::post('/file-auth', [FileAuthController::class, 'authenticate'])->name('file.auth.authenticate');
    Route::post('/file-auth/generate', [FileAuthController::class, 'generateAuthFile'])->name('file.auth.generate');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('products', ProductController::class);
    Route::get('products/{product}/download', [ProductController::class, 'downloadFile'])->name('products.download');
});