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
    public function showactivity($id,$std_id)
    {
        $club = Club::with('members', 'activities')->findOrFail($id);
        $activities = $club->activities;
        return view('club_detail', compact('club', 'activities', 'std_id'));
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

    $request->validate([
        'name' => 'required|string|max:255|unique:clubs,name',
        'description' => 'required|string',
        'creator_role' => 'required|in:หัวหน้าชมรม,สมาชิก',
        'members' => 'required|array|min:4', // รวมผู้สร้าง = 5
    ]);

    // -------------------------
    // ✅ ตรวจชื่อ/รหัสซ้ำทั้งหมดแบบละเอียด
    // -------------------------
    $duplicateMessages = [];
    $members = $request->members;
    $creatorName = trim(mb_strtolower($user->std_name));
    $creatorID = trim($user->std_id);

    // ตรวจสมาชิกกับสมาชิก
    for ($i = 0; $i < count($members); $i++) {
        $m1Name = trim(mb_strtolower($members[$i]['student_name']));
        $m1ID = trim($members[$i]['student_id']);

        for ($j = $i + 1; $j < count($members); $j++) {
            $m2Name = trim(mb_strtolower($members[$j]['student_name']));
            $m2ID = trim($members[$j]['student_id']);

            // ชื่อซ้ำ
            if ($m1Name === $m2Name) {
                $duplicateMessages[] = "ชื่อซ้ำระหว่าง สมาชิกคนที่ " . ($i + 1) . " และ " . ($j + 1);
            }

            // รหัสซ้ำ
            if ($m1ID === $m2ID) {
                $duplicateMessages[] = "รหัสนักศึกษาซ้ำระหว่าง สมาชิกคนที่ " . ($i + 1) . " และ " . ($j + 1);
            }
        }
    }

    // ตรวจสมาชิกกับผู้กรอกฟอร์ม
    foreach ($members as $i => $m) {
        $name = trim(mb_strtolower($m['student_name']));
        $id = trim($m['student_id']);

        if ($name === $creatorName) {
            $duplicateMessages[] = "ชื่อซ้ำระหว่าง สมาชิกคนที่ " . ($i + 1) . " กับผู้กรอกฟอร์ม";
        }
        if ($id === $creatorID) {
            $duplicateMessages[] = "รหัสนักศึกษาซ้ำระหว่าง สมาชิกคนที่ " . ($i + 1) . " กับผู้กรอกฟอร์ม";
        }
    }

    // ถ้ามีข้อมูลซ้ำ แสดง SweetAlert
    if (!empty($duplicateMessages)) {
        $errorMessage = "⚠️ ตรวจพบข้อมูลซ้ำ:\n" . implode("\n", array_unique($duplicateMessages));
        return back()
            ->with('error', nl2br(e($errorMessage))) // ✅ แสดงบรรทัดใหม่ถูกต้อง
            ->withInput();
    }

    // ✅ ตรวจจำนวนสมาชิก (รวมผู้สร้าง)
    if (count($members) + 1 < 5) {
        return back()
            ->with('error', nl2br(e('❌ ต้องมีสมาชิกอย่างน้อย 5 คนรวมผู้สร้างชมรม')))
            ->withInput();
    }

    // ✅ ตรวจหัวหน้าชมรมต้องมี 1 คนเท่านั้น
    $leaders = ($request->creator_role === 'หัวหน้าชมรม') ? 1 : 0;
    foreach ($members as $m) {
        if ($m['position'] === 'หัวหน้าชมรม') $leaders++;
    }
    if ($leaders !== 1) {
        return back()
            ->with('error', nl2br(e('❌ ต้องมีหัวหน้าชมรมเพียง 1 คน')))
            ->withInput();
    }

    // ✅ สร้างชมรม
    $club = new Club();
    $club->name = $request->name;
    $club->description = $request->description;
    $club->status = 'pending';

    if ($request->hasFile('image')) {
        $club->image = $request->file('image')->store('clubs', 'public');
    }

    $club->save();

    // ✅ เพิ่มผู้สร้าง
    Member::create([
        'club_id' => $club->id,
        'student_id' => $user->std_id,
        'name' => $user->std_name,
        'role' => $request->creator_role,
        'status' => 'approved',
    ]);

    // ✅ เพิ่มสมาชิกในฟอร์ม
    foreach ($members as $m) {
        Member::create([
            'club_id' => $club->id,
            'student_id' => $m['student_id'],
            'name' => $m['student_name'],
            'major' => $m['branch'] ?? null,
            'year_level' => $m['year_level'] ?? null,
            'role' => $m['position'],
            'status' => 'pending',
        ]);
    }

    return redirect()->route('clubs.index')
        ->with('success', '✅ สร้างชมรมใหม่เรียบร้อย รอการอนุมัติจากผู้ดูแลระบบ');
}

    /** -------------------- Club Homepage -------------------- */



public function clubHomepage($id_club)
{
    $user = session('user');
    if (!$user) return redirect('/login');

    $leaderclub = Club::findOrFail($id_club);
    $activities = $leaderclub->activities()
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
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
public function requestToLeader($from, $id_club)
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
public function approved($from, $id_club, $id_member)
{
    $member = Member::findOrFail($id_member);
    $member->status = 'approved';
    $member->save();
    return redirect()->route('requestToleader', ['from' => $from, 'id_club' => $id_club])
        ->with('success', 'อนุมัติคำร้องเรียบร้อยแล้ว');
}

public function rejected($from, $id_club, $id_member)
{
    $member = Member::findOrFail($id_member);
    $member->delete();
    return redirect()->route('requestToleader', ['from' => $from, 'id_club' => $id_club])
        ->with('success', 'ปฏิเสธคำร้องเรียบร้อยแล้ว');
}



}
