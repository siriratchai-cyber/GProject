<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Member;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClubController extends Controller
{
    /** -------------------- หน้า All Club -------------------- */
    public function index()
    {
        $user = session('user');
        if (!$user) return redirect('/login');

        $clubs = Club::where('status', 'approved')->get();
        return view('cpclub', compact('clubs', 'user'));
    }
    public function show($id)
    {
        $club = Club::with('members', 'activities')->findOrFail($id);
        $activities = $club->activities;
        return view('club_detail', compact('club', 'activities'));
    }


    /** -------------------- หน้า Create Club -------------------- */
    public function create()
    {
        $user = session('user');
        if (!$user) return redirect('/login');

        return view('create_club', compact('user'));
    }

    /** -------------------- Store Club -------------------- */
    public function store(Request $request)
{
    $user = session('user');
    if (!$user) return redirect('/login');

    $std_id = $user->std_id;

    // ตรวจข้อมูลพื้นฐาน
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    // ตรวจชื่อชมรมซ้ำในระบบ
    if (Club::where('name', $request->name)->exists()) {
        return back()->with('error', 'ชื่อชมรมซ้ำกับที่มีอยู่แล้ว')->withInput();
    }

    // ตรวจว่าไม่มีหัวหน้าชมรมในระบบเลย (อันนี้อาจไม่จำเป็นตอนสร้าง แต่ถ้าคุณหมายถึง “เมื่อสร้าง” ก็ตรวจได้)
    // แต่ทั่วไปตอนสร้างยังไม่มีสมาชิกเลย — มักจะให้ผู้สร้างเป็นหัวหน้า
    // ดังนั้นอาจไม่ต้องตรวจตรงนี้

    // สร้างชมรม
    $club = Club::create([
        'name' => $request->name,
        'description' => $request->description,
        'status' => 'pending',
    ]);

    // สร้างผู้เป็นหัวหน้าชมรม พร้อมข้อมูล major ที่เลือก
    Member::create([
        'club_id' => $club->id,
        'student_id' => $std_id,
        'name' => $user->std_name,
        'role' => 'หัวหน้าชมรม',
        'status' => 'approved',
        'major' => $request->major,  // ถ้าคุณเพิ่มคอลัมน์ major
    ]);

    return redirect()->route('clubs.index')->with('success', '✅ สร้างชมรมใหม่เรียบร้อย');
}

    /** -------------------- Club Homepage -------------------- */

public function clubHomepage($id_club)
{
    $user = session('user');
    if (!$user) return redirect('/login');

    $leaderclub = Club::findOrFail($id_club);
    $activities = $leaderclub->activities()->where('date', '>=', now())
        ->orderBy('date', 'asc')->get();
    $pendingCount = Member::where('club_id', $id_club)->where('status', 'pending')->count();

    return view('clubmain', compact('activities', 'leaderclub', 'pendingCount', 'user'));
}

 
    /** -------------------- Join Club -------------------- */
    public function join($club_id)
    {
        $user = session('user');
        if (!$user) return redirect('/login');

        $already = Member::where('club_id', $club_id)
            ->where('student_id', $user->std_id)
            ->exists();

        if ($already) {
            return back()->with('error', 'คุณได้สมัครชมรมนี้ไปแล้ว');
        }

        Member::create([
            'club_id' => $club_id,
            'student_id' => $user->std_id,
            'name' => $user->std_name,
            'role' => 'สมาชิก',
            'status' => 'pending',
        ]);

        return back()->with('success', 'ส่งคำร้องสมัครชมรมเรียบร้อย');
    }

    /** -------------------- Cancel Join -------------------- */
    public function cancelJoin($club_id)
    {
        $user = session('user');
        if (!$user) return redirect('/login');

        Member::where('club_id', $club_id)
            ->where('student_id', $user->std_id)
            ->delete();

        return back()->with('success', 'ยกเลิกคำร้องเรียบร้อย');
    }

    public function backtoHomepage($id_club){

    $user = session('user');
    if (!$user) {
        return redirect('/login');
    }

    $account = Account::where('std_id', $user->std_id)->first();
    if ($account->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    // ✅ ให้กลับไป homepage หลัก (UserController จะจัดการตาม role เอง)
    return redirect()->route('homepage.index');
}



/** -------------------- หน้าแก้ไขโปรไฟล์ -------------------- */
public function editProfile($id_club)
{
    $user = session('user');
    $leaderclub = Club::findOrFail($id_club);
    return view('editClubProfile', compact('user', 'leaderclub'));
}

/** -------------------- อัปเดตโปรไฟล์ชมรม -------------------- */
public function updateProfile(Request $request, $id_club)
{
    $leaderclub = Club::findOrFail($id_club);
    if ($request->hasFile('image')) {
        $leaderclub->image = $request->file('image')->store('clubs', 'public');
    }
    $leaderclub->name = $request->name_club;
    $leaderclub->description = $request->club_detail;
    $leaderclub->save();
    return redirect()->route('clubHomepage', ['id_club' => $id_club])
        ->with('success', 'อัปเดตโปรไฟล์ชมรมเรียบร้อย');
}

/** -------------------- Request สมาชิก -------------------- */
public function requestToLeader($id_club, $from)
{
    $user = session('user');

    $leaderclub = Club::findOrFail($id_club);
    $member_pending = Member::with('account')
        ->where('club_id', $id_club)
        ->where('status', 'pending')
        ->get();
    $member_approved = Member::with('account')
        ->where('club_id', $id_club)
        ->where('status', 'approved')
        ->get();

    return view('requestandmembers', compact('user', 'leaderclub', 'from', 'member_pending', 'member_approved'));
}
/** -------------------- อนุมัติคำร้อง / ปฏิเสธคำร้อง -------------------- */
public function approved($id_club, $id_member, $from)
{
    $member = Member::findOrFail($id_member);
    $member->status = 'approved';
    $member->save();
    return redirect()->route('requestToleader', ['from' => $from, 'id_club' => $id_club])
        ->with('success', 'อนุมัติคำร้องเรียบร้อยแล้ว');
}

public function rejected($id_club, $id_member, $from)
{
    $member = Member::findOrFail($id_member);
    $member->delete();
    return redirect()->route('requestToleader', ['from' => $from, 'id_club' => $id_club])
        ->with('success', 'ปฏิเสธคำร้องเรียบร้อยแล้ว');
}



}
