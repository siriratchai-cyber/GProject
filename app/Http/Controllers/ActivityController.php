<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\Member;
use App\Models\Account;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function activity($id_club){
        $leaderclub = Club::findOrFail($id_club);
        $activities = $leaderclub->activities()->orderBy('date','asc')->get();
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        return view('activity',compact('activities','leaderclub','user'));
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
        $leaderclub = Club::findOrFail($id_club);
        $activities = $leaderclub->activities()->orderBy('date','asc')->get();
        $leader = Member::where('club_id', $id_club)->where('role', 'หัวหน้าชมรม')->with('account')->first();
        $user = $leader->account;
        return view('activity',compact('activities','leaderclub','user'));
    }

}
