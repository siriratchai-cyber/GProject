<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index'); // หน้า cpclub.blade.php
Route::get('/clubs/create', [ClubController::class, 'create'])->name('clubs.create'); // หน้า create_club.blade.php
Route::post('/clubs', [ClubController::class, 'store'])->name('clubs.store'); // บันทึกข้อมูลชมรม

Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'checklogin']);

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/homepage',[userController::class, 'homepage' ]);
Route::post('/homepage',[userController::class, 'checkinfo' ]);
