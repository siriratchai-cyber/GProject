<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Club;
use App\Models\Member;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index() {
        $clubs = Club::with('members')->orderBy('created_at','desc')->get();
        return view('cpclub', compact('clubs'));
    }

    public function create() {
        return view('create_club');
    }

    public function store(Request $request) {
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
        $studentNames = [];
        $leaderCount = 0;

        foreach ($request->members as $index => $member) {
            if (in_array($member['student_id'], $studentIds)) {
                return back()->withErrors([
                    "members.$index.student_id" => "รหัสนักศึกษา {$member['student_id']} ซ้ำ"
                ])->withInput();
            }
            if (in_array($member['student_name'], $studentNames)) {
                return back()->withErrors([
                    "members.$index.student_name" => "ชื่อ {$member['student_name']} ซ้ำ"
                ])->withInput();
            }
            $studentIds[] = $member['student_id'];
            $studentNames[] = $member['student_name'];

            if ($member['position'] === 'หัวหน้าชมรม') $leaderCount++;
        }

        if ($leaderCount !== 1) {
            return back()->withErrors([
                'members' => 'ต้องมีหัวหน้าชมรม 1 คนพอดี (ตอนนี้มี '.$leaderCount.' คน)'
            ])->withInput();
        }

        $imagePath = $request->hasFile('image') ? $request->file('image')->store('clubs','public') : null;

        $club = Club::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        foreach ($request->members as $member) {
            Member::create([
                'club_id' => $club->id,
                'name' => $member['student_name'],
                'student_id' => $member['student_id'],
                'role' => $member['position'],
            ]);
        }

        return redirect()->route('clubs.index')->with('success','สร้างชมรมใหม่เรียบร้อยแล้ว');
    }

    public function requestMembers($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        $member_pending = Member::where('club_id', $id_club)->where('status','pending')->get();
        $member_approved = Member::where('club_id', $id_club)->where('status','approved')->get();
        return view('requestandmembers',compact('member_pending','member_approved','leaderclub','user'));
    }
    public function approvedMembers($id_club, $id_member){
        $member = Member::findOrFail($id_member);
        $member->status = "approved";
        $member->save();
        return redirect()->route('requestToleader', ['id_club' => $id_club])
            ->with('success', 'อนุมัติสำเร็จ');
    }
    public function rejectedMember($id_club, $id_member){
        $member = Member::findOrFail($id_member);
        $member->delete();
        return redirect()->route('requestToleader', ['id_club' => $id_club])
            ->with('success', 'ไม่อนุมัติสำเร็จ');
    }
    public function editedProfileForleader($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        return view('editclubProfile',compact('leaderclub','user'));
    }
    public function updateProfileForleader(Request $request, $id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leaderclub->name = $request->name_club;
        $leaderclub->description = $request->club_detail;
        $leaderclub->save();
        return redirect()->route('editProfile', ['id_club' => $id_club])
            ->with('success', 'แก้ไขโปรไฟล์สำเร็จ');
    }
    public function backtoHomepage($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        $pendingCount = Member::where('club_id', $leaderclub->id)
                      ->where('status', 'pending')
                      ->count();
        $activities = $leaderclub->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")->orderBy('date','asc')->get();
        return view('leaderHome',compact('activities','leaderclub','pendingCount','user'));
    }
    public function clubHomepage($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        $pendingCount = Member::where('club_id', $leaderclub->id)
                      ->where('status', 'pending')
                      ->count();
        $activities = $leaderclub->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")->orderBy('date','asc')->get();
        return view('clubmain',compact('activities','user','leaderclub','pendingCount'));
    }
    public function backtoclubHomepage($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        $pendingCount = Member::where('club_id', $leaderclub->id)
                      ->where('status', 'pending')
                      ->count();
        $activities = $leaderclub->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")->orderBy('date','asc')->get();
        return view('clubmain',compact('activities','user','leaderclub','pendingCount'));
    }
};
