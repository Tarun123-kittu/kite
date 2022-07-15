<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ReachController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AdminController::class, 'show'])->name('show.login');
Route::post('/login', [AdminController::class, 'login'])->name('login');

Route::get('/forgot-password', [AdminController::class, 'showForgotPassword'])->name('show.forgot-password');
Route::post('/forgot-password', [AdminController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/reset-password/{email}/{hash?}', [AdminController::class, 'request'])->name('show.reset-password');
Route::post('/reset-password/{email}/{hash?}', [AdminController::class, 'resetPassword'])->name('reset-password');

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('/profile', [AdminController::class, 'profile'])->name('show.profile');
    Route::post('/profile', [AdminController::class, 'update'])->name('profile');
    Route::get('/change-password',  [AdminController::class, 'changePassword'])->name('admin.changepassword');
    Route::post('/change-password',  [AdminController::class, 'updatePassword'])->name('admin.changepassword');

    //Users routes
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/list', [UserController::class, 'getusers'])->name('users.list');

    Route::get('users/add', [UserController::class, 'addUser'])->name('users.add');
    Route::post('users/store', [UserController::class, 'storeUser'])->name('users.store');
    Route::get('/user/{id}', [UserController::class, 'edit'])->name('user.edit')->where('id', '[0-9]+');
    Route::post('/user/{id}', [UserController::class, 'update'])->name('user.update')->where('id', '[0-9]+');
    Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy')->where('id', '[0-9]+');

    //Report routes
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');

    Route::get('/me/reach',[ReachController::class, 'index'])->name('reach.report');
});
Route::get('/test-api', function(){
    return Hash::make(123456789);
});
