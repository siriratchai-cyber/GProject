<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Member;
use App\Models\Account;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function showActivity($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        $activities = $leaderclub->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")->orderBy('date','asc')->get();
        $activity = null;
        return view('activity',compact('activity','leaderclub','user','activities'));
    }

    public function addActivity(Request $request,$id_club){
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

    public function deleteActivity($id_club, $id_activity){
        $activity = Activity::findOrFail($id_activity);
        $activity->delete();
        return redirect()->route('showActivity', ['id_club' => $id_club])
            ->with('success', 'ลบกิจกรรมสำเร็จ');
    }

    public function editActivity($id_club, $id_activity){
        $activity = Activity::findOrFail($id_activity);
        $leaderclub = Club::findOrFail($id_club);
        $activities = $leaderclub->activities()
                    ->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s') >= NOW()")->orderBy('date','asc')->get();
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        return view('activity',compact('activity','activities','leaderclub','user'));
    }

    public function updateActivity(Request $request, $id_club, $id_activity){
        $activity = Activity::findOrFail($id_activity);
        $activity->activity_name = $request->name;
        $activity->description = $request->description;
        $activity->date = $request->date;
        $activity->time = $request->time;
        $activity->location = $request->location;
        $activity->save();
        return redirect()->route('showActivity', ['id_club' => $id_club])
            ->with('success', 'อัปเดตกิจกรรมสำเร็จ');
    }

}
