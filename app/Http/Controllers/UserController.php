<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Member;


class UserController extends Controller
{
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
        $User->password = $request->password; // ✅ เข้ารหัส password
        $User->major    = $request->major;
        $User->role     = 'นักศึกษา';
        $User->year     = $request->year;
        
        $User->save();
        return redirect('login')->with('success', 'บันทึกข้อมูลแล้ว');
    }
    
    public function login()
    {
        return view('login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function checklogin(Request $request)
    {
        $user = Account::where('std_id', $request->std_id)->first();
        $club = Member::all();
        $leaderclub = $user ? $user->clubs()->wherePivot('role', 'หัวหน้าชมรม')->first() : null;

        if (!$user) {
            return back()->withErrors(['std_id' => 'ไม่พบผู้ใช้งาน']);
        }

        if ($user->role === "หัวหน้าชมรม" && $leaderclub) {
            $pendingCount = Member::where('club_id', $leaderclub->id)
                ->where('status', 'pending')
                ->count();
            $activities = $leaderclub->activities()
                ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
                ->orderBy('date', 'asc')
                ->get();
            return view('leaderHome', compact('user', 'leaderclub', 'pendingCount', 'activities'));
        }

        if (!$user || $request->password != $user->password) {
            return redirect()->back()->withErrors([
                'std_id' => 'รหัสนักศึกษา หรือ รหัสผ่านไม่ถูกต้อง',
            ]);
        }

        if ($user->role === "แอดมิน") {
            return view('adminpage', ['std_id' => $user->std_id]);
        }

        $clubs = Member::where('student_id', $user->std_id)->get();
        if (!$clubs->isEmpty()) {
        $activities = [];
        $pendingCount = 0;
        if ($leaderclub) {
            $activities = $leaderclub->activities()
                ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
                ->orderBy('date', 'asc')
                ->get();
            $pendingCount = Member::where('club_id', $leaderclub->id)->where('status', 'pending')->count();
        }
        $clubs = Member::where('student_id', $user->std_id)->get();

        if (!$clubs->isEmpty()) {
            $activities = collect(); // เริ่มจาก collection ว่าง

            foreach ($clubs as $c) {
                $clubActivities = $c->club->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
                    ->orderBy('date', 'asc')
                    ->get();

                $activities = $activities->merge($clubActivities);
            }
            // เรียงใหม่ตามวันที่
            $activities = $activities->sortBy('date');
            $club = Member::all();
            return view('homepage', compact('user', 'club', 'activities'));
            }
        }

        return redirect()->route('clubs.index')->with(['user' => $user, 'clubs' => $clubs]);
    }
    public function logout()
    {  
        return redirect()->route('login');
    }
}
