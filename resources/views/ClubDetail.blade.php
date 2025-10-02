@extends('layouts.headclub')
@section('title', 'Home Page')
@section('club_name', 'CP club')
@section('username', $userId)
@section('style')
<style>
    .club-box { background:#f8f6f3; border-radius:20px; padding:20px;margin:10px 50px 10px 50px; }
    .btn { padding:10px 20px; border:none; border-radius:8px; cursor:pointer; font-weight:bold; }
    .btn-leader { background:#f1f1f1; margin-right:10px; }
    .btn-leave { background:#f1f1f1; }
    .calendar, .activity-box {
        background:#f8f6f3; border-radius:20px; padding:20px; margin-top:20px;
    }
</style>
@endsection

@section('body')
    <div class="club-box" style="display:flex;gap:20px;border-radius: 20px;">
        <img src="{{ asset('storage/'.$club->image) }}" style="width:300px;border-radius:10px;">
        <div>
            <h2>CP {{ $club->name }}</h2>
            <p>{{ $club->description }}</p>

            <button class="btn btn-leader">ขอเป็นหัวหน้าชมรม</button>
            <button class="btn btn-leave" onclick="document.getElementById('leaveModal').style.display='block'">ออกจากชมรม</button>
        </div>
    </div>

    <div style="display:flex;gap:20px;margin:10px 50px 10px 50px;">
        <div class="activity-box" style="flex:2;">
            <h4>กิจกรรมของชมรม</h4>
            @foreach($club->activities as $act)
                <p><b>{{ $act->activity_name }}</b><br>
                {{ $act->description }} <br>
                เวลา {{ $act->time }} น. | {{ $act->location }}</p>
            @endforeach
        </div>
    </div>

    <!-- Modal ออกจากชมรม -->
    <div id="leaveModal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,.6);">
        <div style="background:#fff;padding:30px;border-radius:20px;width:400px;margin:10% auto;text-align:center;">
            <h3>คุณต้องการที่จะออกจากชมรมใช่หรือไม่</h3>
            <form action="{{ route('club.leave',$club->id) }}" method="POST">
                @csrf
                <button type="button" class="btn btn-leader" onclick="document.getElementById('leaveModal').style.display='none'">ผมไม่ออก</button>
                <button type="submit" class="btn btn-leave">ตกลง</button>
            </form>
        </div>
    </div>
@endsection
