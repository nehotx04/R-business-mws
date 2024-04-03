<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubsidiariesController;

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
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('auth.refresh');
    Route::get('/profile', [AuthController::class, 'profile'])->name('auth.profile');    
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'subsidiaries'
], function ($router) {
    Route::post('/new', [SubsidiariesController::class, 'store'])->name('subsidiaries.store');
    Route::get('/{subsidiary}', [SubsidiariesController::class, 'show'])->name('subsidiaries.show');
    Route::get('/', [SubsidiariesController::class, 'index'])->name('subsidiaries.index');
    Route::put('/{subsidiary}', [SubsidiariesController::class, 'update'])->name('subsidiaries.update');
    Route::delete('/{subsidiary}', [SubsidiariesController::class, 'destroy'])->name('subsidiaries.destroy');
});