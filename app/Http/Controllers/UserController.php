<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Member;


class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('register');
    }
    
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
        $User->password = $request->password;
        $User->major    = $request->major;
        $User->role     = 'student';
        $User->year     = $request->year;
        
        $User->save();
        return redirect('login')->with('success', 'บันทึกข้อมูลแล้ว');
    }

    public function login()
    {
        return view('login');
    }

    public function checklogin(Request $request)
    {
        $user = Account::where('std_id', $request->std_id)->first();
        $club = Member::all();
        $id = $user->std_id;
        if ($user && $request->password == $user->password) {
            return view('homepage', compact('id','club'));
        }
        return redirect()->back()->withErrors([
            'std_id' => 'รหัสนักศึกษา หรือ รหัสผ่านไม่ถูกต้อง',
        ]);
    }

    public function homepage()
    {
        return view('homepage');
    }
}
