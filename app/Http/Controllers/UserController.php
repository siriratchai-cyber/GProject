<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Club;
use App\Models\Member;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // ✅ ฟอร์มสมัครสมาชิก
    public function showRegisterForm()
    {
        return view('register');
    }

    // ✅ สมัครสมาชิก
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

        $User = new Account;
        $User->std_name = $request->std_name;
        $User->std_id   = $request->std_id;
        $User->email    = $request->email;
        $User->password = Hash::make($request->password);
        $User->major    = $request->major;
        $User->role     = 'นักศึกษา'; // ค่าเริ่มต้นเป็นนักศึกษา
        $User->year     = $request->year;
        $User->save();

        return redirect('login')->with('success', '✅ สมัครสมาชิกสำเร็จ');
    }

    // ✅ ฟอร์ม login
    public function login()
    {
        return view('login');
    }

    // ✅ ตรวจสอบการ login
    public function checklogin(Request $request)
    {
        $user = Account::where('std_id', $request->std_id)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['std_id' => '❌ รหัสนักศึกษา หรือ รหัสผ่านไม่ถูกต้อง']);
        }

        // ตั้งค่า session
        Session::put('std_id', $user->std_id);
        Session::put('role', $user->role);

        // 👉 ถ้าเป็นแอดมิน
        if ($user->role === "แอดมิน") {
            return redirect()->route('admin.dashboard');
        }

        // 👉 ถ้าเป็นหัวหน้าชมรม
        $leaderclub = $user->clubs()->wherePivot('role', 'หัวหน้าชมรม')->first();
        if ($user->role === "หัวหน้าชมรม" && $leaderclub) {
            $pendingCount = Member::where('club_id', $leaderclub->id)->where('status', 'pending')->count();
            $activities = $leaderclub->activities()
                ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
                ->orderBy('date', 'asc')->get();
            return view('leaderHome', compact('user', 'leaderclub', 'pendingCount', 'activities'));
        }

        // 👉 ถ้าเป็นนักศึกษา → ไปหน้า homepage
        return redirect()->route('homepage.index');
    }

    // ✅ Dashboard ของนักศึกษา (ชมรม + กิจกรรม)
    public function homepage()
    {
        $std_id = Session::get('std_id');
        $user = Account::where('std_id', $std_id)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors(['std_id' => 'กรุณาเข้าสู่ระบบใหม่']);
        }

        // ✅ ชมรมที่ user เข้าร่วม
        $myClubs = $user->clubs()->with('activities')->get();

        // ✅ รวมกิจกรรมทั้งหมดจากทุกชมรม
        $activities = [];
        foreach ($myClubs as $c) {
            foreach ($c->activities as $a) {
                $activities[] = $a;
            }
        }

        return view('homepage', compact('user', 'myClubs', 'activities'));
    }

    // ✅ logout
    public function logout()
    {
        Session::flush();
        return redirect('login')->with('success', 'ออกจากระบบแล้ว');
    }
}
