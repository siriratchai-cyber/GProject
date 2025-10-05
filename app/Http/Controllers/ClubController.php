<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Club;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ClubController extends Controller
{
    // ✅ แสดงหน้า All Clubs
    public function index()
    {
        $clubs = Club::with('members')
            ->where('status', 'approved') // ✅ เอาเฉพาะที่แอดมินอนุมัติแล้ว
            ->orderBy('created_at', 'desc')
            ->get();

        $std_id = Session::get('std_id');
        $user = Account::where('std_id', $std_id)->first();

        return view('cpclub', compact('clubs', 'user'));
    }

    // ✅ ฟอร์มสร้างชมรม
    public function create()
    {
        return view('create_club');
    }

    // ✅ บันทึกชมรมใหม่ (รออนุมัติจากแอดมิน)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:clubs',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'members' => 'required|array|min:5',
            'members.*.student_name' => 'required|string|max:255',
            'members.*.student_id' => 'required|string|regex:/^\d{6,9}-\d$/',
            'members.*.position' => 'required|string',
        ]);

        $studentIds = [];
        $leaderCount = 0;

        foreach ($request->members as $index => $member) {
            if (in_array($member['student_id'], $studentIds)) {
                return back()->withErrors(["members.$index.student_id" => "รหัส {$member['student_id']} ซ้ำ"])->withInput();
            }
            $studentIds[] = $member['student_id'];
            if ($member['position'] === 'หัวหน้าชมรม') $leaderCount++;
        }

        if ($leaderCount !== 1) {
            return back()->withErrors(['members' => "ต้องมีหัวหน้าชมรม 1 คนพอดี (ตอนนี้มี $leaderCount คน)"])->withInput();
        }

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('clubs', 'public') 
            : null;

        // ✅ Club ใหม่รอแอดมินอนุมัติ
        $club = Club::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'pending',
        ]);

        // ✅ เพิ่มสมาชิกทั้งหมด (รออนุมัติพร้อมชมรม)
        foreach ($request->members as $member) {
            Member::create([
                'club_id' => $club->id,
                'name' => $member['student_name'],
                'student_id' => $member['student_id'],
                'role' => $member['position'],
                'status' => 'pending',
            ]);
        }

        return redirect()->route('clubs.index')->with('success', '✅ ส่งคำขอสร้างชมรมแล้ว รอแอดมินอนุมัติ');
    }

    // ✅ ดูคำขอเข้าชมรม
    public function requestMembers($from, $id_club)
    {
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader?->account;

        $member_pending = Member::where('club_id', $id_club)->where('status', 'pending')->get();
        $member_approved = Member::where('club_id', $id_club)->where('status', 'approved')->get();

        return view('requestandmembers', compact('member_pending', 'member_approved', 'leaderclub', 'user', 'from'));
    }

    // ✅ อนุมัติสมาชิก
    public function approvedMembers($from, $id_club, $id_member)
    {
        $member = Member::findOrFail($id_member);
        $member->status = "approved";
        $member->save();

        return redirect()->route('requestToleader', ['from' => $from, 'id_club' => $id_club])->with('success', '✅ อนุมัติสมาชิกแล้ว');
    }

    // ✅ ไม่อนุมัติสมาชิก
    public function rejectedMember($from, $id_club, $id_member)
    {
        $member = Member::findOrFail($id_member);
        $member->delete();

        return redirect()->route('requestToleader', ['from' => $from, 'id_club' => $id_club])->with('success', '❌ ไม่อนุมัติสำเร็จ');
    }

    // ✅ ฟอร์มแก้ไขโปรไฟล์ชมรม (หัวหน้า)
    public function editedProfileForleader($from, $id_club)
    {
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader?->account;

        return view('editclubProfile', compact('leaderclub', 'user', 'from'));
    }

    // ✅ อัปเดตโปรไฟล์ชมรม
    public function updateProfileForleader(Request $request, $from, $id_club)
    {
        $leaderclub = Club::findOrFail($id_club);
        $leaderclub->name = $request->name_club;
        $leaderclub->description = $request->club_detail;
        $leaderclub->save();

        return redirect()->route('editProfile', ['from' => $from, 'id_club' => $id_club])->with('success', 'แก้ไขโปรไฟล์สำเร็จ');
    }

    // ✅ กลับไปหน้า Home ของหัวหน้า
    public function backtoHomepage($id_club)
    {
        $leaderclub = Club::findOrFail($id_club);
        $std_id = Session::get('std_id');
        $user = Account::where('std_id', $std_id)->first();

        $pendingCount = Member::where('club_id', $leaderclub->id)->where('status', 'pending')->count();
        $activities = $leaderclub->activities()
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
            ->orderBy('date', 'asc')->get();

        return view('leaderHome', compact('activities', 'leaderclub', 'pendingCount', 'user'));
    }

    // ✅ หน้า Club homepage
    public function clubHomepage($id_club)
    {
        $leaderclub = Club::findOrFail($id_club);
        $std_id = Session::get('std_id');
        $user = Account::where('std_id', $std_id)->first();

        $pendingCount = Member::where('club_id', $leaderclub->id)->where('status', 'pending')->count();
        $activities = $leaderclub->activities()
            ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")
            ->orderBy('date', 'asc')->get();

        return view('clubmain', compact('activities', 'user', 'leaderclub', 'pendingCount'));
    }

    // ✅ นักศึกษาสมัครเข้าชมรม
    public function join($club_id)
    {
        $std_id = Session::get('std_id');
        $account = Account::where('std_id', $std_id)->firstOrFail();

        $exists = Member::where('club_id', $club_id)->where('student_id', $std_id)->exists();

        if (!$exists) {
            Member::create([
                'club_id' => $club_id,
                'name' => $account->std_name,
                'student_id' => $std_id,
                'role' => 'สมาชิก',
                'status' => 'pending',
            ]);
        }
        return back()->with('success', '✅ ส่งคำขอสมัครแล้ว');
    }

    // ✅ ยกเลิกคำขอสมัคร
    public function cancelJoin($club_id)
    {
        $std_id = Session::get('std_id');
        Member::where('club_id', $club_id)->where('student_id', $std_id)->where('status', 'pending')->delete();

        return back()->with('success', '❌ ยกเลิกคำขอแล้ว');
    }

    // ✅ ขอเป็นหัวหน้าชมรม
    // ClubController.php

// ขอเป็นหัวหน้า
public function requestLeader($club_id)
{
    $std_id = Session::get('std_id');
    $member = Member::where('club_id',$club_id)->where('student_id',$std_id)->firstOrFail();

    $hasLeader = Member::where('club_id',$club_id)
        ->where('role','หัวหน้าชมรม')
        ->where('status','approved')
        ->exists();

    if($hasLeader){
        return back()->withErrors(['msg'=>'ขณะนี้มีหัวหน้าชมรมอยู่แล้ว']);
    }

    $member->role = 'หัวหน้าชมรม';
    $member->status = 'pending_leader';
    $member->save();

    // ✅ flash message
    return back()->with('success','ได้ส่งคำร้องขอการเป็นหัวหน้าชมรมเรียบร้อยแล้ว รอรับการอนุมัติ');
}

// ออกจากชมรม
public function leaveClub($club_id)
{
    $std_id = Session::get('std_id');
    Member::where('club_id',$club_id)->where('student_id',$std_id)->where('role','สมาชิก')->delete();

    return back()->with('success','ออกจากชมรมแล้ว');
}

    // ✅ หัวหน้าขอลาออก (รอแอดมินอนุมัติ)
    public function requestResign($id_club)
    {
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->first();
        if ($leader) {
            $leader->status = $leader->status === "approved" ? "pending_resign" : "approved";
            $leader->save();
        }
        return redirect()->route('clubHomepage', ['id_club' => $id_club]);
    }

  
public function show($id)
{
    // ดึงชมรม + ข้อมูลสมาชิก + กิจกรรม
    $club = Club::with(['members','activities'])->findOrFail($id);

    // ดึง user ปัจจุบัน
    $std_id = Session::get('std_id');
    $user = Account::where('std_id', $std_id)->first();

    // นับว่ามีหัวหน้าชมรมหรือยัง
    $hasLeader = $club->members()
        ->where('role','หัวหน้าชมรม')
        ->where('status','approved')
        ->exists();

    return view('club_detail', compact('club','user','hasLeader'));
}


}
