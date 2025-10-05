<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Club;
use App\Models\Account;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function showActivity($id_club)
{
    // ดึงข้อมูล club จาก id
    $leaderclub = Club::findOrFail($id_club);

    // ดึง user จาก session
    $user = session('user');

    // ดึงกิจกรรมทั้งหมดของชมรมนั้น
    $activities = $leaderclub->activities()->orderBy('date', 'desc')->get();

    // ส่งข้อมูลไปยังหน้า view
    return view('activity', compact('leaderclub', 'activities', 'user'));
}


    public function addActivity(Request $request, $id)
    {
        Activity::create([
            'activity_name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
            'club_id' => $id,
            'status' => 'approved',
        ]);

        return redirect()->route('showActivity', ['id' => $id])
            ->with('success', 'เพิ่มกิจกรรมสำเร็จ');
    }

    public function deleteActivity($id, $activity_id)
    {
        Activity::findOrFail($activity_id)->delete();
        return back()->with('success', 'ลบกิจกรรมเรียบร้อย');
    }

    public function editActivity($id, $activity_id)
    {
        $user = session('user');
        if (!$user) return redirect('/login');

        $club = Club::findOrFail($id);
        $activity = Activity::findOrFail($activity_id);
        $activities = $club->activities()->get();

        return view('activity', compact('activity', 'activities', 'club', 'user'));
    }

    public function updateActivity(Request $request, $id, $activity_id)
    {
        $activity = Activity::findOrFail($activity_id);
        $activity->update([
            'activity_name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'time' => $request->time,
            'location' => $request->location,
        ]);

        return redirect()->route('showActivity', ['id' => $id])
            ->with('success', 'อัปเดตกิจกรรมแล้ว');
    }
}
