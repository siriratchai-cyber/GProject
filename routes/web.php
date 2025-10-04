<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;

Route::get('/', function () { return view('welcome'); });

/** Auth */
Route::get('/register', [UserController::class, 'showRegisterForm']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/login', [UserController::class, 'login']);
Route::post('/login', [UserController::class, 'checklogin']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

/** Homepage */
Route::get('/homepage', [UserController::class, 'homepage'])->name('homepage.index');

/** Clubs */
Route::resource('clubs', ClubController::class);   // ✅ อันนี้จะ generate index, show, create, store, edit, update, destroy ครบ

/** Join / Cancel / Leave */
Route::post('/clubs/{club}/join', [ClubController::class, 'join'])->name('clubs.join');
Route::post('/clubs/{club}/cancel', [ClubController::class, 'cancelJoin'])->name('clubs.cancel');
Route::post('/clubs/{club}/leave', [ClubController::class, 'leaveClub'])->name('clubs.leave');
Route::post('/clubs/{club}/request-leader', [ClubController::class, 'requestLeader'])->name('clubs.requestLeader');

/** Admin */
/** Admin */
Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests');

// อนุมัติ / ปฏิเสธ ชมรม
Route::post('/admin/clubs/{club}/approve', [AdminController::class, 'approveClub'])->name('admin.clubs.approve');
Route::post('/admin/clubs/{club}/reject',  [AdminController::class, 'rejectClub'])->name('admin.clubs.reject');

// อนุมัติ / ปฏิเสธ หัวหน้า
Route::post('/admin/leader/{member}/approve', [AdminController::class, 'approveLeader'])->name('admin.leader.approve');
Route::post('/admin/leader/{member}/reject',  [AdminController::class, 'rejectLeader'])->name('admin.leader.reject');

// อนุมัติการลาออก
Route::post('/admin/resign/{member}/approve', [AdminController::class, 'approveResign'])->name('admin.resign.approve');

// Admin - Clubs
Route::get('/admin/clubs/{club}/edit', [App\Http\Controllers\AdminController::class, 'editClub'])
    ->name('admin.clubs.edit');

Route::post('/admin/clubs/{club}/update', [App\Http\Controllers\AdminController::class, 'updateClub'])
    ->name('admin.clubs.update');

    // ✅ แก้ไขข้อมูลสมาชิก (แอดมิน)
Route::get('/admin/members/{member}/edit', [App\Http\Controllers\AdminController::class, 'editMember'])
    ->name('admin.members.edit');

Route::post('/admin/members/{member}/update', [App\Http\Controllers\AdminController::class, 'updateMember'])
    ->name('admin.members.update');

Route::get('/clubs/{club}/detail', [ClubController::class, 'detail'])->name('clubs.detail');
