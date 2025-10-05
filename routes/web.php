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

// 🔹 หน้า Login & Register
Route::get('/login', [UserController::class, 'login'])->name('login'); // ✅ GET - แสดงหน้า login
Route::post('/login', [UserController::class, 'checklogin']); // ✅ POST - ตรวจสอบข้อมูล login
Route::get('/register', [UserController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.submit');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// 🔹 หน้า Homepage (แยกตาม role)
Route::get('/homepage', [UserController::class, 'homepage'])->name('homepage.index');


// ===================== STUDENT =====================
Route::get('/clubs', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/clubs/create', [ClubController::class, 'create'])->name('clubs.create');
Route::post('/clubs/store', [ClubController::class, 'store'])->name('clubs.store');

// สมัคร/ยกเลิกชมรม
Route::post('/clubs/{club}/join', [ClubController::class, 'join'])->name('clubs.join');
Route::post('/clubs/{club}/cancel', [ClubController::class, 'cancelJoin'])->name('clubs.cancel');

// ===================== LEADER =====================
// ===================== LEADER =====================

// ✅ หน้าโฮมของหัวหน้าชมรม
Route::get('/club/{id_club}/home', [ClubController::class, 'clubHomepage'])->name('clubHomepage');

// ✅ ปุ่มกลับไปโฮมเพจ (จากหน้าชมรม)
Route::get('/club/{id_club}/backtoHome', [ClubController::class, 'backtoHomepage'])->name('backtoHome');

// ✅ คำร้องลาออกจากตำแหน่งหัวหน้าชมรม
Route::post('/club/{id_club}/requestResign', [ClubController::class, 'requestResign'])->name('requestResign');

// ✅ หน้าแก้ไขโปรไฟล์ชมรม
Route::get('/club/{id_club}/edit-profile/{from}', [ClubController::class, 'editProfile'])->name('editProfile');
Route::post('/club/{id_club}/update-profile/{from}', [ClubController::class, 'updateProfile'])->name('updateProfile');

// ✅ หน้า request สมาชิก (คำร้องเข้าชมรม)
Route::get('/club/{id_club}/requests/{from}', [ClubController::class, 'requestToLeader'])->name('requestToleader');
Route::post('/club/{id_club}/approve/{id_member}/{from}', [ClubController::class, 'approved'])->name('approved');
Route::post('/club/{id_club}/reject/{id_member}/{from}', [ClubController::class, 'rejected'])->name('rejected');

// ✅ หน้า activity (เพิ่ม/แก้ไข/ลบกิจกรรม)
Route::get('/club/{id_club}/activities', [ActivityController::class, 'showActivity'])->name('showActivity');
Route::post('/club/{id_club}/activities/add', [ActivityController::class, 'addActivity'])->name('addActivity');
Route::post('/club/{id_club}/activities/{id_activity}/delete', [ActivityController::class, 'deleteActivity'])->name('deleteActivity');
Route::get('/club/{id_club}/activities/{id_activity}/edit', [ActivityController::class, 'editActivity'])->name('editActivity');
Route::post('/club/{id_club}/activities/{id_activity}/update', [ActivityController::class, 'updateActivity'])->name('updateActivity');

// ✅ อัปเดตและลบสมาชิกในชมรม
Route::post('/club/{id_club}/member/{id_member}/update', [ClubController::class, 'updateMember'])->name('updateMember');
Route::post('/club/{id_club}/member/{id_member}/delete', [ClubController::class, 'deleteMember'])->name('deleteMember');

// ✅ เพิ่มสมาชิกใหม่
Route::post('/club/{id_club}/add-member', [ClubController::class, 'addMember'])->name('addMember');

// ===================== ADMIN =====================
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests');

Route::post('/admin/club/{id}/approve', [AdminController::class, 'approveClub'])->name('admin.clubs.approve');
Route::post('/admin/club/{id}/reject', [AdminController::class, 'rejectClub'])->name('admin.clubs.reject');

Route::get('/admin/club/{id}/edit', [AdminController::class, 'editClub'])->name('admin.clubs.edit');
Route::post('/admin/club/{id}/update', [AdminController::class, 'updateClub'])->name('admin.clubs.update');

// ✅ Password update (admin)
Route::post('/admin/password/{std_id}', [AdminController::class, 'updatePassword'])->name('admin.updatePassword');

Route::delete('/admin/club/{id}', [AdminController::class, 'destroyClub'])->name('admin.clubs.destroy');

// ✅ หน้าจัดการสมาชิกในชมรม (แอดมิน)
Route::get('/admin/club/{id}/members', [AdminController::class, 'editMembers'])->name('admin.members.edit');

// ✅ หน้าแก้ไขสมาชิกเดี่ยว (Admin)
Route::get('/admin/club/{club_id}/member/{member_id}/edit', [AdminController::class, 'editSingleMember'])
    ->name('admin.member.edit');

// ✅ บันทึกข้อมูลสมาชิก
Route::post('/admin/club/{club_id}/member/{member_id}/update', [AdminController::class, 'updateMember'])
    ->name('admin.members.update');
