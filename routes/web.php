<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
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

Route::get('/register', [UserController::class, 'showRegisterForm']);
Route::post('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'checklogin']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/homepage',[userController::class, 'homepage' ]);
Route::post('/homepage',[userController::class, 'checkinfo' ]);

Route::get('{from}/request/{id_club}',[ClubController::class, 'requestMembers'])->name('requestToleader');
Route::post('{from}/request/approved/{id_club}/{id_member}',[ClubController::class, 'approvedMembers'])->name('approved');
Route::post('{from}/request/rejected/{id_club}/{id_member}',[ClubController::class, 'rejectedMember'])->name('rejected');
Route::get('{from}/editProfile/{id_club}',[ClubController::class, 'editedProfileForleader'])->name('editProfile');
Route::post('{from}/editProfile/{id_club}',[ClubController::class, 'updateProfileForleader'])->name('updateProfile');
Route::get('/homepage/leader/{id_club}',[ClubController::class, 'backtoHomepage'])->name('backtoHome');
Route::get('/club/homepage/{id_club}',[ClubController::class, 'clubHomepage'])->name('clubHomepage');
Route::get('/club/Activity/{id_club}',[ActivityController::class, 'showActivity'])->name('showActivity');
Route::post('/club/addActivity/{id_club}',[ActivityController::class, 'addActivity'])->name('addActivity');
Route::post('/club/deleteActivity/{id_club}/{id_activity}',[ActivityController::class, 'deleteActivity'])->name('deleteActivity');
Route::get('/club/editActivity/{id_club}/{id_activity}',[ActivityController::class, 'editActivity'])->name('editActivity');
Route::post('/club/updateActivity/{id_club}/{id_activity}',[ActivityController::class, 'updateActivity'])->name('updateActivity');
Route::post('/club/{id_club}/requestResign',[ClubController::class, 'requestResign'])->name('requestResign');