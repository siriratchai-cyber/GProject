@extends('layouts.headclub')
@section('title', 'กิจกรรมชมรม')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    main { display:flex; flex-direction:column; margin:3% 10%; gap:20px; }
    p{ font-size:18px; }
    .box-activity{ background:#f9f6f2; border-radius:30px; padding:20px; display:flex; flex-direction:column; gap:8px;}
    .back{ background:#d9e7f3; border:1px solid black; border-radius:30px; width:fit-content; padding:6px 20px;}
    .back:hover{background:#5E5F68; color:white;}
    a{ text-decoration:none; color:black; }

    input,textarea{ width:80%; border:1px solid #ccc; border-radius:10px; padding:6px 10px; font-size:14px; }
    textarea{ min-height:60px; }

    .btn-save{ background:#5E5F68; color:white; border:none; border-radius:20px; padding:8px 20px; margin-top:10px; cursor:pointer;}
    .btn-save:hover{ background:#A9CF88; color:#303032; }
    .btn-delete{ background:#F69191; border:none; border-radius:20px; padding:6px 25px; color:black; cursor:pointer;}
    .btn-delete:hover{ background:red; color:white;}
    .btn-cancel{ border:1px solid black; background:#f9f6f2; border-radius:20px; padding:6px 25px;}
    .btn-cancel:hover{ background:red; color:white;}

    table{ width:100%; border-collapse:collapse; background:#f9f6f2; box-shadow:0 0 8px rgba(0,0,0,.1);}
    th{ background:#5E5F68; color:white; padding:10px; text-align:center;}
    td{ padding:10px; text-align:center;}
</style>
@endsection

@section('body')
<main>
    <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id]) }}" class="back">⬅ กลับไป</a>

    <p>กิจกรรมที่กำลังดำเนินการอยู่</p>
    <table>
        <thead><tr><th>วันที่</th><th>ชื่อกิจกรรม</th><th>การจัดการ</th></tr></thead>
        <tbody>
            @forelse($activities as $a)
                <tr>
                    <td>{{ $a->date }}</td>
                    <td>{{ $a->activity_name }}</td>
                    <td>
                        <form action="{{ route('deleteActivity',['id'=>$leaderclub->id,'activity_id'=>$a->id]) }}" method="POST" style="display:inline">

                            @csrf
                            <button class="btn-delete">ลบ</button>
                        </form>
                        <a href="{{ route('editActivity',['id'=>$leaderclub->id,'activity_id'=>$a->id]) }}" class="btn-cancel">แก้ไข</a>

                    </td>
                </tr>
            @empty
                <tr><td colspan="3">ยังไม่มีกิจกรรม</td></tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    @if(!isset($activity) || !$activity)
        <p>เพิ่มกิจกรรมใหม่</p>
        <div class="box-activity">
            <form method="POST" action="{{ route('addActivity',['id'=>$leaderclub->id]) }}">

                @csrf
                <label>ชื่อกิจกรรม</label>
                <input type="text" name="name" required>
                <label>รายละเอียดกิจกรรม</label>
                <textarea name="description" required></textarea>
                <label>วันที่</label>
                <input type="date" name="date" required>
                <label>เวลา</label>
                <input type="time" name="time" required>
                <label>สถานที่</label>
                <input type="text" name="location" required>
                <button type="submit" class="btn-save">บันทึกข้อมูล</button>
            </form>
        </div>
    @else
        <p>แก้ไขกิจกรรม</p>
        <div class="box-activity">
            <form method="POST" action="{{ route('updateActivity',['id_club'=>$leaderclub->id,'id_activity'=>$activity->id]) }}">
                @csrf
                <label>ชื่อกิจกรรม</label>
                <input type="text" name="name" value="{{ $activity->activity_name }}" required>
                <label>รายละเอียด</label>
                <textarea name="description">{{ $activity->description }}</textarea>
                <label>วันที่</label>
                <input type="date" name="date" value="{{ $activity->date }}" required>
                <label>เวลา</label>
                <input type="time" name="time" value="{{ $activity->time }}" required>
                <label>สถานที่</label>
                <input type="text" name="location" value="{{ $activity->location }}" required>
                <button type="submit" class="btn-save">บันทึก</button>
                <a href="{{ route('showActivity',['id_club'=>$leaderclub->id]) }}" class="btn-cancel">ยกเลิก</a>
            </form>
        </div>
    @endif
</main>
@endsection
