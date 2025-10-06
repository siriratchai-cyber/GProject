<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Club;
use App\Models\Account;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function showActivity($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $user = session('user');
        $activities = $leaderclub->activities()->orderBy('date', 'asc')->get();
        return view('activity', compact('leaderclub', 'activities', 'user'));
    }


    public function addActivity(Request $request, $id_club)
    {
         $new_activity = new Activity;
        $new_activity->activity_name = $request->name;
        $new_activity->description = $request->description;
        $new_activity->date = $request->date;
        $new_activity->time = $request->time;
        $new_activity->location = $request->location;
        $new_activity->club_id = $id_club;
        $new_activity->status = "approved";
        $new_activity->save();

        return redirect()->route('showActivity', ['id_club' => $id_club])
            ->with('success', 'เพิ่มกิจกรรมสำเร็จ');
    }

    public function deleteActivity($id_club, $id_activity)
    {
        $activity = Activity::findOrFail($id_activity);
        $activity->delete();
        return redirect()->route('showActivity', ['id_club' => $id_club])
            ->with('success', 'ลบกิจกรรมสำเร็จ');
    }

    public function editActivity($id_club, $id_activity)
    {
        $user = session('user');
        if (!$user) return redirect('/login');
        $leaderclub = Club::findOrFail($id_club);
        $activity = Activity::findOrFail($id_activity);
        $activities = $leaderclub->activities()->orderBy('date', 'asc')->get();
        return view('activity', compact('activity', 'activities', 'leaderclub', 'user'));
    }

    public function updateActivity(Request $request, $id, $activity_id)
    {
        $activity = Activity::findOrFail($activity_id);
        $activity->activity_name = $request->name;
        $activity->description = $request->description;
        $activity->date = $request->date;
        $activity->time = $request->time;
        $activity->location = $request->location;
        $activity->save();

        return redirect()->route('showActivity', ['id_club' => $id])
            ->with('success', 'อัปเดตกิจกรรมแล้ว');
    }
}
