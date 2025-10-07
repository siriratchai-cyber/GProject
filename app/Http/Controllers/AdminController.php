<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Member;
use App\Models\Account;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = session('user');
        if (!$user) {
            return redirect('/login');
        }

        $clubs = Club::withCount('members')
            ->where('status', 'approved')
            ->get();

        return view('admin_dashboard', compact('clubs', 'user'));
    }

    public function requests()
    {
        $user = session('user');
        $pendingClubs = Club::where('status', 'pending')->get();
        $pendingLeaders = Member::where('role', 'หัวหน้าชมรม')
            ->where('status', 'pending_leader')->with('club')->get();
        $pendingResign = Member::where('role', 'หัวหน้าชมรม')
            ->where('status', 'pending_resign')->with('club')->get();

        return view('admin_requests', compact('pendingClubs', 'pendingLeaders', 'pendingResign', 'user'));
    }

    public function approveClub($id)
    {
        $club = Club::findOrFail($id);
        $club->update(['status' => 'approved']);
        Member::where('club_id', $club->id)->update(['status' => 'approved']);

        return back()->with('success', '✅ อนุมัติชมรมเรียบร้อย');
    }

    public function rejectClub($id)
    {
        $club = Club::findOrFail($id);
        $club->delete();
        return back()->with('success', '❌ ปฏิเสธคำขอสร้างชมรมแล้ว');
    }

    public function updatePassword(Request $request, $std_id)
    {
        $account = Account::where('std_id', $std_id)->firstOrFail();
        $account->update(['password' => $request->new_password]);
        return back()->with('success', 'อัปเดตรหัสผ่านเรียบร้อย');
    }

    public function editClub($id)
    {
        $club = Club::with(['members.account'])->findOrFail($id);
        return view('admin_edit_club', compact('club'));
    }

    public function updateClub(Request $request, $id)
    {
        $club = Club::findOrFail($id);
        $club->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'อัปเดตชมรมแล้ว');
    }

    public function destroyClub($id)
    {
        $club = Club::findOrFail($id);
        Member::where('club_id', $id)->delete();
        $club->delete();

        return redirect()->route('admin.dashboard')->with('success', 'ลบชมรมเรียบร้อยแล้ว');
    }

       
public function editMembers($id)
{
    $club = \App\Models\Club::with('members')->findOrFail($id);
    return view('admin_members_list', compact('club'));
}

<<<<<<< Updated upstream
public function editSingleMember($club_id, $member_id)
{
    $club = Club::findOrFail($club_id);

    $member = Member::where('club_id', $club_id)
        ->where('id', $member_id)
        ->firstOrFail();
=======
    public function editMembers($id)
    {
        $user = session('user');
        $club = Club::with('members')->findOrFail($id);
        return view('admin_members_list', compact('club', 'user'));
    }

    public function editSingleMember($club_id, $member_id)
    {
        $user = session('user');
        $club = Club::findOrFail($club_id);
>>>>>>> Stashed changes

    // ถ้าไม่มี account ให้สร้างใหม่อัตโนมัติ (ใช้ข้อมูลจาก member)
    $account = Account::firstOrCreate(
        ['std_id' => $member->student_id],
        [
            'std_name' => $member->name,
            'email' => strtolower($member->name) . '@gmail.com',
            'password' => '12345678', // ✅ รหัสผ่านข้อความธรรมดา
            'major' => 'CS',
            'year' => 1,
            'role' => 'นักศึกษา',
        ]
    );

<<<<<<< Updated upstream
    return view('admin_edit_member', compact('club', 'member', 'account'));
}
=======
        $account = Account::firstOrCreate(
            ['std_id' => $member->student_id],
            [
                'std_name' => $member->name,
                'email' => strtolower($member->name) . '@gmail.com',
                'password' => '12345678',
                'major' => 'CS',
                'year' => 1,
                'role' => 'นักศึกษา',
            ]
        );

        return view('admin_edit_member', compact('club', 'member', 'account' , 'user'));
    }
>>>>>>> Stashed changes


    public function updateMember(Request $request, $club_id, $member_id)
<<<<<<< Updated upstream
{
    // ✅ ตรวจสอบข้อมูลจากฟอร์ม
    $data = $request->validate([
        'std_name' => 'nullable|string|max:255',
        'std_id' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'password' => 'nullable|string|max:255',
        'major' => 'nullable|string|max:50',
        'year' => 'nullable|integer',
        'role' => 'nullable|string',
        'status' => 'nullable|string',
    ]);

    // ✅ ดึงข้อมูล member ในชมรมนี้
    $member = Member::where('club_id', $club_id)
        ->where('id', $member_id)
        ->firstOrFail();

    // ✅ อัปเดต role / status ของ member (ค่ามาจาก hidden input)
    $member->role = $data['role'] ?? $member->role;
    $member->status = $data['status'] ?? $member->status;
    $member->save();

    // ✅ อัปเดตข้อมูลในตาราง accounts
    $account = Account::where('std_id', $member->student_id)->first();
    if ($account) {
        $account->update([
            'std_name' => $data['std_name'] ?? $account->std_name,
            'email' => $data['email'] ?? $account->email,
            'password' => $data['password'] ?? $account->password,
            'major' => $data['major'] ?? $account->major,
            'year' => $data['year'] ?? $account->year,
        ]);
=======
    {
        $user = session('user');
        $data = $request->validate([
            'std_name' => 'nullable|string|max:255',
            'std_id' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'password' => 'nullable|string|max:255',
            'major' => 'nullable|string|max:50',
            'year' => 'nullable|integer',
            'role' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $member = Member::where('club_id', $club_id)
            ->where('id', $member_id)
            ->firstOrFail();
        $member->role = $data['role'] ?? $member->role;
        $member->status = $data['status'] ?? $member->status;
        $member->save();
        $account = Account::where('std_id', $member->student_id)->first();
        if ($account) {
            $account->update([
                'std_name' => $data['std_name'] ?? $account->std_name,
                'email' => $data['email'] ?? $account->email,
                'password' => $data['password'] ?? $account->password,
                'major' => $data['major'] ?? $account->major,
                'year' => $data['year'] ?? $account->year,
            ]);
        }

        return redirect()->route('admin.members.edit', $club_id)
            ->with('success', '✅ อัปเดตข้อมูลสมาชิกเรียบร้อยแล้ว');
>>>>>>> Stashed changes
    }

    return redirect()->route('admin.members.edit', $club_id)
        ->with('success', '✅ อัปเดตข้อมูลสมาชิกเรียบร้อยแล้ว');
}

    public function addMember(Request $request, $club_id)
<<<<<<< Updated upstream
{
    $request->validate([
        'student_id' => 'required|string',
        'name' => 'required|string|max:255',
        'role' => 'required|string',
        'status' => 'required|string',
        'major' => 'nullable|string',
        'year' => 'nullable|string'
    ]);
=======
    {
        $user = session('user');
        $request->validate([
            'student_id' => 'required|string',
            'name' => 'required|string|max:255',
            'role' => 'required|string',
            'status' => 'required|string',
            'major' => 'nullable|string',
            'year' => 'nullable|string'
        ]);
>>>>>>> Stashed changes

    // 🔹 ถ้ายังไม่มี account ให้สร้างอัตโนมัติ
    $account = Account::firstOrCreate(
        ['std_id' => $request->student_id],
        [
            'std_name' => $request->name,
            'email' => strtolower(str_replace(' ', '', $request->name)) . '@gmail.com',
            'password' =>'12345678',
            'major' => $request->major ?? '',
            'year' => $request->year ?? '',
            'role' => 'นักศึกษา'
        ]
    );

    // 🔹 เพิ่มข้อมูลในตาราง members
    Member::create([
        'club_id' => $club_id,
        'name' => $request->name,
        'student_id' => $request->student_id,
        'role' => $request->role,
        'status' => $request->status
    ]);

    return redirect()->route('admin.members.edit', $club_id)
        ->with('success', 'เพิ่มสมาชิกใหม่และสร้างบัญชีให้อัตโนมัติแล้ว');
}

}
