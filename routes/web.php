<?php

use App\Models\UserLogs;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\rolesController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\devicesController;
use App\Http\Controllers\giveNumController;
use App\Http\Controllers\profileController;
use App\Http\Controllers\reportsController;
use App\Http\Controllers\servicesController;
use App\Http\Controllers\activityLogsController;

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

Auth::routes(); /* Bỏ ['register' => false] để đăng ký */

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::name('devices.')->middleware('auth')->group(function(){
    Route::get('thiet-bi', [devicesController::class, 'index'])->name('index');
    Route::get('thiet-bi/them-thiet-bi', [devicesController::class, 'create'])->name('create');
    Route::post('thiet-bi/them-thiet-bi/luu', [devicesController::class, 'store'])->name('store');
    Route::get('thiet-bi/chi-tiet/{id}', [devicesController::class, 'show'])->name('show');
    Route::get('thiet-bi/cap-nhat-thiet-bi/{id}',[devicesController::class, 'edit'])->name('edit');
    Route::put('thiet-bi/cap-nhat-thiet-bi/luu/{id}', [devicesController::class, 'update'])->name('update');
});

Route::name('services.')->middleware('auth')->group(function(){
    Route::get('dich-vu', [servicesController::class, 'index'])->name('index');
    Route::get('dich-vu/them-dich-vu', [servicesController::class, 'create'])->name('create');
    Route::post('dich-vu/them-dich-vu/luu', [servicesController::class, 'store'])->name('store');
    Route::get('dich-vu/chi-tiet/{id}', [servicesController::class, 'show'])->name('show');
    Route::get('dich-vu/cap-nhat-dich-vu/{id}', [servicesController::class, 'edit'])->name('edit');
    Route::put('dich-vu/cap-nhat-dich-vu/luu/{id}', [servicesController::class, 'update'])->name('update');
});

Route::name('give_num.')->middleware('auth')->group(function(){
    Route::get('cap-so', [giveNumController::class, 'index'])->name('index');
    Route::get('cap-so/cap-so-moi', [giveNumController::class, 'create'])->name('create');
    Route::post('cap-so/cap-so-moi/luu', [giveNumController::class, 'store'])->name('store');
    Route::get('cap-so/chi-tiet/{id}', [giveNumController::class, 'show'])->name('show');
});

Route::name('reports.')->middleware('auth')->group(function(){
    Route::get('bao-cao', [reportsController::class, 'index'])->name('index');
});

Route::name('system.')->middleware('auth')->group(function(){
    Route::get('cai-dat/vai-tro', [rolesController::class, 'index'])->name('roles.index');
    Route::get('cai-dat/vai-tro/them-vai-tro', [rolesController::class, 'create'])->name('roles.create');
    Route::post('cai-dat/vai-tro/them-vai-tro/luu', [rolesController::class, 'store'])->name('roles.store');
    Route::get('cai-dat/vai-tro/cap-nhat-vai-tro/{id}', [rolesController::class, 'edit'])->name('roles.edit');
    Route::put('cai-dat/vai-tro/cap-nhat-vai-tro/luu/{id}', [rolesController::class, 'update'])->name('roles.update');

    Route::get('cai-dat/tai-khoan', [usersController::class, 'index'])->name('users.index');
    Route::get('cai-dat/tai-khoan/them-tai-khoan', [usersController:: class, 'create'])->name('users.create');
    Route::post('cai-dat/tai-khoan/them-tai-khoan/luu', [usersController::class, 'store'])->name('users.store');
    Route::get('cai-dat/tai-khoan/cap-nhat-tai-khoan/{id}', [usersController::class, 'edit'])->name('users.edit');
    Route::put('cai-dat/tai-khoan/cap-nhat-tai-khoan/luu/{id}', [usersController::class, 'update'])->name('users.update');

    Route::get('cai-dat/nhat-ky-hoat-dong', [activityLogsController::class, 'index'])->name('user_logs.index');
});

Route::get('profile/{id}', [profileController::class, 'index'])->name('profile.index');
Route::post('profile/{id}/dropzone', [profileController::class, 'dropzone'])->name('dropzone');


Route::get('storage/{filename}', function ($filename)
{
    $path = storage_path('public/' . $filename);

    if (!File::exists($path)) abort(404);
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});
