<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Club;
use App\Models\Member;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /** ✅ แสดงฟอร์มสมัครสมาชิก */
    public function showRegisterForm()
    {
        return view('register');
    }

    /** ✅ สมัครสมาชิกใหม่ */
    public function register(Request $request)
    {
        $request->validate([
            'std_name' => 'required|string|max:255',
            'std_id'   => 'required|string|max:255|unique:accounts,std_id',
            'email'    => 'required|email|max:255|unique:accounts,email',
            'password' => 'required|string|min:6',
            'major'    => 'required|string|max:255',
            'year'     => 'required|integer',
        ]);

        $user = new Account();
        $user->std_name = $request->std_name;
        $user->std_id   = $request->std_id;
        $user->email    = $request->email;
        $user->password = $request->password; // ❗เก็บเป็น string
        $user->major    = $request->major;
        $user->year     = $request->year;
        $user->role     = 'นักศึกษา'; // ค่าเริ่มต้น
        $user->save();

        return redirect('login')->with('success', '✅ สมัครสมาชิกสำเร็จ');
    }

    /** ✅ แสดงหน้า Login */
    public function login()
    {
        return view('login');
    }

    /** ✅ ตรวจสอบการเข้าสู่ระบบ */
    public function checklogin(Request $request)
    {
        $user = Account::where('std_id', $request->std_id)
            ->where('password', $request->password)
            ->first();

        if (!$user) {
            return redirect('/login')->with('error', '❌ รหัสนักศึกษาหรือรหัสผ่านไม่ถูกต้อง');
        }

        // ✅ บันทึก session ผู้ใช้
        session(['user' => $user]);
        return redirect('/homepage');
    }

    /** ✅ หน้าหลัก (ระบบตรวจ role อัตโนมัติ) */
  public function homepage()
{
    $user = session('user');
    if (!$user) return redirect('/login');

    $account = Account::where('std_id', $user->std_id)->first();

    // 🧩 1. ถ้าเป็นแอดมิน
    if ($account->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    

    // 🧩 2. ถ้าเป็นหัวหน้าชมรม
    $leaderclub = Member::where('student_id', $account->std_id)
        ->where('role', 'หัวหน้าชมรม')
        ->with('club')
        ->first();

    if ($leaderclub) {
        $club = $leaderclub->club;
        $pendingCount = Member::where('club_id', $club->id)
            ->where('status', 'pending')
            ->count();

        $activities = Activity::where('club_id', $club->id)
            ->where('date', '>=', now())
            ->orderBy('date', 'asc')
            ->get();

        // 👉 หน้าเฉพาะของหัวหน้าชมรม
        return view('leaderHome', [
            'leaderclub' => $club,
            'pendingCount' => $pendingCount,
            'activities' => $activities,
            'account' => $account
        ]);
    }

    // 🧩 3. นักศึกษาทั่วไป
    $myClubs = Member::with('club')
        ->where('student_id', $account->std_id)
        ->where('status', 'approved')
        ->get()
        ->pluck('club');

    $upcomingActivities = Activity::whereIn('club_id', $myClubs->pluck('id'))
        ->where('date', '>=', now())
        ->orderBy('date', 'asc')
        ->get();

    return view('homepage', compact('account', 'myClubs', 'upcomingActivities'));
}



    /** ✅ ออกจากระบบ */
    public function logout()
    {
        Session::flush();
        return redirect('login')->with('success', 'ออกจากระบบแล้ว');
    }
}
