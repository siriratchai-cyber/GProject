<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Member;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // ✅ หน้า Dashboard → แสดงเฉพาะชมรม approved
    public function dashboard()
    {
        $clubs = Club::withCount('members')->where('status','approved')->get();
        $user = Account::where('std_id', Session::get('std_id'))->first();

        return view('admin_dashboard', compact('clubs', 'user'));
    }

    // ✅ หน้า Requests → แสดงคำร้องทั้งหมด
    public function requests()
    {
        $pendingClubs = Club::where('status','pending')->get();

        $pendingLeaders = Member::with('account','club')
            ->where('role','หัวหน้าชมรม')
            ->where('status','pending_leader')->get();

        $pendingResign = Member::with('account','club')
            ->where('role','หัวหน้าชมรม')
            ->where('status','pending_resign')->get();

        $user = Account::where('std_id', Session::get('std_id'))->first();

        return view('admin_requests', compact('pendingClubs','pendingLeaders','pendingResign','user'));
    }

    // ✅ อนุมัติ/ปฏิเสธการสร้างชมรม
    public function approveClub($club_id)
    {
        $club = Club::findOrFail($club_id);
        $club->status = 'approved';
        $club->save();

        // สมาชิกที่สร้าง → approved ด้วย
        Member::where('club_id',$club->id)->update(['status'=>'approved']);

        return back()->with('success','✅ อนุมัติสร้างชมรมแล้ว');
    }

    public function rejectClub($club_id)
    {
        $club = Club::findOrFail($club_id);
        $club->delete();
        return back()->with('success','❌ ปฏิเสธคำขอสร้างชมรมแล้ว');
    }

    // ✅ อนุมัติ/ปฏิเสธการขอเป็นหัวหน้า
    public function approveLeader($member_id)
    {
        $member = Member::findOrFail($member_id);
        $has = Member::where('club_id',$member->club_id)
            ->where('role','หัวหน้าชมรม')
            ->where('status','approved')->exists();

        if($has){
            return back()->withErrors(['msg'=>'⚠ มีหัวหน้าชมรมอยู่แล้ว']);
        }

        $member->status = 'approved';
        $member->save();
        return back()->with('success','✅ อนุมัติหัวหน้าชมรมแล้ว');
    }

    public function rejectLeader($member_id)
    {
        $member = Member::findOrFail($member_id);
        $member->role = 'สมาชิก';
        $member->status = 'approved';
        $member->save();
        return back()->with('success','❌ ปฏิเสธคำขอเป็นหัวหน้าแล้ว');
    }

    // ✅ อนุมัติคำขอลาออกของหัวหน้า → เปลี่ยนเป็นสมาชิก
    public function approveResign($member_id)
    {
        $member = Member::findOrFail($member_id);
        $member->role = 'สมาชิก';
        $member->status = 'approved';
        $member->save();
        return back()->with('success','✅ อนุมัติการลาออกของหัวหน้าแล้ว');
    }

    // แสดงฟอร์มแก้ไขชมรม
    public function editClub($id)
    {
        $club = Club::with(['members.account'])->findOrFail($id);
        return view('admin_edit_club', compact('club'));
    }

    public function editMember($member_id)
    {
        $member = Member::with('account')->findOrFail($member_id);
        return view('admin_edit_member', compact('member'));
    }

    public function updateMember(Request $request, $member_id)
    {
        $member = Member::findOrFail($member_id);
        $member->role = $request->input('role');
        $member->status = $request->input('status');
        $member->save();

        return redirect()->back()->with('success', 'อัปเดตข้อมูลสมาชิกเรียบร้อยแล้ว');
    }

    // อัปเดตข้อมูลชมรม
    public function updateClub(Request $request, $club_id)
    {
        $club = Club::findOrFail($club_id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $club->name = $request->name;
        $club->description = $request->description;
        $club->save();

        return redirect()->route('admin.dashboard')->with('success', 'แก้ไขชมรมเรียบร้อยแล้ว');
    }
}
