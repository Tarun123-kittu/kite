<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\api\AdminController as ApiAdminController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ReportsController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test-api', [AdminController::class, 'test']);

Route::group(['prefix' => 'v1'], function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::post('/forgot-password', [ApiAdminController::class, 'forgotPassword']);

});

Route::group(['prefix' => 'v1' , 'middleware' => 'auth:api',], function () {

    Route::get('/test', [AuthController::class, 'test']);

    //user routes
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::get('/all-deals', [UserController::class, 'allDeals']);
    Route::post('/store-user', [UserController::class, 'storeUser']);
    Route::get('/user/{id}', [UserController::class, 'userById']);
    Route::post('/update-user/{id}', [UserController::class, 'update']);
    Route::get('/user/delete/{id}', [UserController::class, 'destroy']);

    //Admin profile routes
    Route::post('/update-profile', [ApiAdminController::class, 'update']);
    Route::post('/update-password', [ApiAdminController::class, 'updatePassword']);
    Route::get('/dashboard', [ApiAdminController::class, 'dashboard']);

    //Admin routes
    Route::get('/reports', [ReportsController::class, 'index']);
    
});
