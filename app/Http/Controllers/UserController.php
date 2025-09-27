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
<<<<<<< HEAD
        $club = Member::all();
        $leaderclub = $user->clubs()->wherePivot('role', 'หัวหน้าชมรม')->first();
        $pendingCount = Member::where('club_id', $leaderclub->id)
                      ->where('status', 'pending')
                      ->count();
        $activities = $leaderclub->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")->orderBy('date','asc')->get();
        $id = $user->std_id;
        if ($user && $request->password == $user->password) {
            if($user->role=="หัวหน้าชมรม"){
                return view('leaderHome', compact('user','leaderclub', 'pendingCount', 'activities'));
            }else if($request->role == "แอดมิน"){
                return view('adminpage', compact('id'));
            }else{
                return view('homepage', compact('id','club'));
            }
=======

        if (!$user || $request->password != $user->password) {
            return redirect()->back()->withErrors([
                'std_id' => 'รหัสนักศึกษา หรือ รหัสผ่านไม่ถูกต้อง',
            ]);
>>>>>>> 9a13378 (add function go to club)
        }

        // ดึงชมรมที่ user อยู่
        $clubs = Member::where('student_id', $user->id)->get(); 

        if ($clubs->isEmpty()) {
            // ถ้า user ยังไม่มีชมรม → ส่งไปหน้าเลือกชมรม
            
            return redirect()->route('clubs.index')->with(['user' => $user,'clubs' => $clubs]);
        }

        // ถ้ามีชมรม → ไป homepage
        return view('homepage', compact('user', 'clubs'));
    }

}
