<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ActivityController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
// หน้า forgot password
Route::get('/forgot-password', function () {return view('Forgot_password');})->name('forgotpassword.form');
Route::post('/forgot-password', [UserController::class, 'resetPassword'])->name('forgotpassword.reset');

// หน้า Login & Register
Route::get('/login', [UserController::class, 'login'])->name('login'); 
Route::post('/login', [UserController::class, 'checklogin']);
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// หน้า Homepage (แยกตาม role)
Route::get('/homepage', [UserController::class, 'homepage'])->name('homepage.index');

// ===================== STUDENT =====================
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/clubs/create', [ClubController::class, 'create'])->name('clubs.create');
Route::post('/clubs/store', [ClubController::class, 'store'])->name('clubs.store');
Route::get('/club/{id}/{std_id}/ClubActivity', [ClubController::class, 'showactivity'])->name('clubsShowactivity');

// สมัคร/ยกเลิกชมรม
Route::post('/clubs/{club}/join', [ClubController::class, 'join'])->name('clubs.join');
Route::post('/clubs/{club}/cancel', [ClubController::class, 'cancelJoin'])->name('clubs.cancel');

// ===================== LEADER =====================

// หน้าโฮมของหัวหน้าชมรม
Route::get('/club/{id_club}/home', [ClubController::class, 'clubHomepage'])->name('clubHomepage');

// ปุ่มกลับไปโฮมเพจ
Route::get('/club/{id_club}/backtoHome', [ClubController::class, 'backtoHomepage'])->name('backtoHome');

// หน้าแก้ไขโปรไฟล์ชมรม
Route::get('/club/{id_club}/edit-profile', [ClubController::class, 'editProfile'])->name('editProfile');
Route::post('/club/{id_club}/update-profile', [ClubController::class, 'updateProfile'])->name('updateProfile');

//หน้า request สมาชิก (คำร้องเข้าชมรม)
Route::get('/{from}/{id_club}/requests', [ClubController::class, 'requestToLeader'])->name('requestToleader');
Route::post('/{from}/{id_club}/approve/{id_member}', [ClubController::class, 'approved'])->name('approved');
Route::post('/{from}/{id_club}/reject/{id_member}', [ClubController::class, 'rejected'])->name('rejected');

//หน้า activity (เพิ่ม/แก้ไข/ลบกิจกรรม)
Route::get('/club/{id_club}/activities', [ActivityController::class, 'showActivity'])->name('showActivity');
Route::post('/club/{id_club}/activities/add', [ActivityController::class, 'addActivity'])->name('addActivity');
Route::post('/club/{id_club}/activities/{id_activity}/delete', [ActivityController::class, 'deleteActivity'])->name('deleteActivity');
Route::get('/club/{id_club}/activities/{id_activity}/edit', [ActivityController::class, 'editActivity'])->name('editActivity');
Route::post('/club/{id_club}/activities/{id_activity}/update', [ActivityController::class, 'updateActivity'])->name('updateActivity');


// ===================== ADMIN =====================

//Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

//หน้า request รออนุมัติชมรม
Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests');

//อนุมัติ/ปฏิเสธชมรม
Route::post('/admin/club/{id}/approve', [AdminController::class, 'approveClub'])->name('admin.clubs.approve');
Route::post('/admin/club/{id}/reject', [AdminController::class, 'rejectClub'])->name('admin.clubs.reject');

//แก้ไขข้อมูลชมรม
Route::get('/admin/club/{id}/edit', [AdminController::class, 'editClub'])->name('admin.clubs.edit');
Route::post('/admin/club/{id}/update', [AdminController::class, 'updateClub'])->name('admin.clubs.update');

//ลบชมรม
Route::delete('/admin/club/{id}', [AdminController::class, 'destroyClub'])->name('admin.clubs.destroy');

//อัปเดตรหัสผ่านของบัญชี
Route::post('/admin/password/{std_id}', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

// รายชื่อสมาชิกทั้งหมด
Route::get('/admin/club/{id}/members', [AdminController::class, 'editMembers'])->name('admin.members.edit');

// แก้ไขสมาชิกเดี่ยว
Route::get('/admin/club/{club_id}/member/{member_id}/edit', [AdminController::class, 'editSingleMember'])
    ->name('admin.member.edit');

// อัปเดตข้อมูลสมาชิก
Route::put('/admin/club/{club_id}/member/{member_id}/update', [AdminController::class, 'updateMember'])
    ->name('admin.members.update');


    Route::post('/admin/club/{club_id}/add-member', [AdminController::class, 'addMember'])
    ->name('admin.members.add');

