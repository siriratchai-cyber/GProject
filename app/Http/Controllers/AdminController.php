<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Club;
use App\Models\Activity;
use App\Models\Member;

class AdminController extends Controller
{
    public function index()
    {
        $clubs = Club::where('status', 'approved')->get();
        return view('admin_home', compact('clubs'));
    }

    public function clubs()
    {
        $clubs = Club::where('status', 'approved')->get();
        return view('admin_clubs', compact('clubs'));
    }

    public function createClub()
    {
        return view('admin_club_create');
    }

    public function saveClub(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $club = new Club();
        $club->name = $request->name;
        $club->description = $request->description;

        if ($request->hasFile('image')) {
            $club->image = $request->file('image')->store('clubs', 'public');
        }

        $club->status = 'pending';

        $club->save();

        return redirect()->route('admin.clubs');
    }


    public function editClub($id)
    {
        $club = Club::find($id);
        return view('admin_club_edit', compact('club'));
    }

    public function updateClub(Request $request, $id)
    {
        $club = Club::find($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $club->name = $request->name;
        $club->description = $request->description;

        if ($request->hasFile('image')) {
            $club->image = $request->file('image')->store('clubs', 'public');
        }

        $club->save();

        return redirect()->route('admin.dashboard');
    }

    public function requests()
    {
        $clubs = Club::where('status', 'pending')->get();
        return view('admin_requests', compact('clubs'));
    }

    public function approveClub($id, $approve = true)
    {
        $club = Club::find($id);

        if ($approve) {
            $club->status = 'approved';
            $club->save();
            return redirect()->route('admin.requests');
        } else {
            $club->delete();
            return redirect()->route('admin.requests');
        }
    }

    public function destroyClub($id)
    {
        $club = Club::find($id);
        $club->delete();
        return redirect()->route('admin.clubs');
    }

    public function clubMembers($clubId)
    {
        $club = club::with(['members.account'])->findOrFail($clubId);
        return view('admin_members', compact('club'));
    }

    public function createMember($clubId)
    {
        $club = Club::find($clubId);
        return view('admin_members_edit', [
            'club' => $club,
            'member' => null,
            'account' => null,
        ]);
    }

    public function updateMember(Request $request, $clubId, $memberId)
    {
        $member = Member::where('club_id', $clubId)->find($memberId);
        $account = Account::where('std_id', $member->student_id)->first();

        if (!$account) {
            $account = new Account();
            $account->std_id = $member->student_id;
        }
        
        $account->std_name = $request->input('std_name', $account->std_name);
        $account->email = $request->input('email', $account->email ?? ($member->student_id . '@example.com'));
        $account->year = $request->input('year', $account->year);
        $account->major = $request->input('major', $account->major);
        $account->role = 'นักศึกษา';

        if ($request->filled('password')) {
            $account->password = $request->password;
        } else {
            $account->password = '12345678';
        }
        $account->save();
        if (empty($member->role))
            $member->role = 'สมาชิก';
        if (empty($member->status))
            $member->status = 'approved';
        $member->name = $account->std_name ?: '-';
        $member->save();

        return redirect()->route('admin.clubs.members', $clubId);
    }


    public function storeMember(Request $request, $clubId)
    {
        $data = $request->validate([
            'std_id' => 'required|string|max:100',
            'std_name' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:120',
            'password' => 'nullable|string|min:1',
            'year' => 'nullable|integer',
            'major' => 'nullable|string|max:255',
        ]);

        $account = Account::updateOrCreate(
            ['std_id' => $data['std_id']],
            [
                'std_name' => $data['std_name'] ?? '-',
                'email' => $data['email'] ?? ($data['std_id'] . '@example.com'),
                'password' => $data['password'] ?? (Account::where('std_id', $data['std_id'])->value('password') ?? '12345678'), // (แนะนำ: ควร Hash::make)
                'year' => $data['year'] ?? null,
                'major' => $data['major'] ?? null,
                'role' => 'นักศึกษา',
            ]
        );

        $exists = Member::where('club_id', $clubId)
            ->where('student_id', $account->std_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['std_id' => 'รหัสนี้อยู่ในชมรมแล้ว'])->withInput();
        }

        $member = new Member();
        $member->club_id = $clubId;
        $member->student_id = $account->std_id;
        $member->name = $account->std_name ?: '-';
        $member->role = 'สมาชิก';
        $member->status = 'approved';
        $member->save();

        return redirect()->route('admin.clubs.members', $clubId);
    }

    public function editMember($clubId, $memberRowId)
    {
        $club = Club::find($clubId);
        $member = Member::where('club_id', $clubId)->find($memberRowId);
        $account = Account::where('std_id', $member->student_id)->first();

        return view('admin_members_edit', [
            'club' => $club,
            'member' => $member,
            'account' => $account,
        ]);
    }

    public function destroyMember($clubId, $memberRowId)
    {
        Member::find($memberRowId)->delete();
        return redirect()->route('admin.clubs.members', $clubId);
    }
}
