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
        if (!$user) return redirect('/login');

        $clubs = Club::withCount('members')->where('status', 'approved')->get();
        return view('admin_dashboard', compact('clubs', 'user'));
    }

    public function requests()
    {
        $user = session('user');
        if (!$user) return redirect('/login');

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
    $club = \App\Models\Club::findOrFail($id);

    // ลบสมาชิกในชมรมนี้ทั้งหมดก่อน เพื่อไม่ให้ foreign key error
    \App\Models\Member::where('club_id', $id)->delete();

    // ลบชมรม
    $club->delete();

    return redirect()->route('admin.dashboard')->with('success', 'ลบชมรมเรียบร้อยแล้ว');
}
public function editMembers($id)
{
    $club = \App\Models\Club::with('members')->findOrFail($id);
    return view('admin_edit_member', compact('club'));
}
public function editSingleMember($club_id, $member_id)
{
    $club = \App\Models\Club::findOrFail($club_id);
    $member = \App\Models\Member::findOrFail($member_id);

    return view('admin_edit_member', compact('club', 'member'));
}

}
