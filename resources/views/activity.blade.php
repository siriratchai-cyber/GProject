@extends('layouts.headclub')
@section('title', 'กิจกรรมชมรม')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    @import url("{{ asset('css/activity.css') }}");
</style>

<script>
    function checkTime() {
        const Input_date = document.getElementById('activity_date');
        const Input_time = document.getElementById('activity_time');
        const date = Input_date.value;
        const time = Input_time.value;

        const selectedDateTime = new Date(`${date}T${time}`);
        const now = new Date();

        if (selectedDateTime < now) {
            alert(" วันหรือเวลาน้อยกว่าปัจจุบัน");
            Input_time.value = ""
        }
    }
</script>
@endsection

@section('body')
<main>
    <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id]) }}" class="back">⬅ กลับ</a>

    <h4 class="text-show1">กิจกรรมที่กำลังดำเนินการอยู่</h4>
    <div class="box-showActivities">
        <table class="showactivity">
            <thead>
                <th>วัน</th><th>ชื่อกิจกรรม</th><th></th>
            </thead>
            <tbody>
                @if($activities->isEmpty())
                    <tr><td colspan="3"><span>ยังไม่มีกิจกรรม</span></td></tr>
                @else
                 @foreach($activities as $a)
                    <tr>
                    <td>{{ $a->date }}</td>
                    <td>{{ $a->activity_name }}</td>
                    <td>
                    <div class="action-btns">
                            <button type="button" class="btn-delete" data-bs-toggle="modal" data-bs-target="#deleteActivityModal{{ $a->id }}">
                                ลบ
                                </button>
                                <div class="modal fade" id="deleteActivityModal{{ $a->id }}" tabindex="-1" aria-labelledby="deleteActivityLabel{{ $a->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 20px;">
                                    <div class="modal-body text-center">
                                        <p class="fs-5 fw-bold">คุณต้องการที่จะลบกิจกรรม <br>ใช่หรือไม่</p>
                                        <div class="d-flex justify-content-center gap-3 mt-3">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <form action="{{ route('deleteActivity', ['id_club' => $leaderclub->id, 'id_activity' => $a->id ]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-dark">ตกลง</button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            <a href="{{ route('editActivity', ['id_club' => $leaderclub->id, 'id_activity' => $a->id ]) }}" class="btn-edit" >แก้ไข</a>
                    </div>
                    </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
    </div>
    
    <hr>
    @if(!isset($activity))
        <h4 class="text-show2">เพิ่มกิจกรรมใหม่</h4>
        <div class="box-activity">
            <form method="POST" action="{{ route('addActivity',['id_club'=>$leaderclub->id]) }}">

                @csrf
                <label>ชื่อกิจกรรม:</label>
                <input type="text" name="name" required>
                <label>รายละเอียดกิจกรรม:</label>
                <textarea name="description" required></textarea>
                <label>วันที่:</label>
                <input type="date" name="date" min="{{ date('Y-m-d') }}" id="activity_date" onchange="checkTime()" required>
                <label>เวลา:</label>
                <input type="time" name="time" id="activity_time" onchange="checkTime()" required>
                <label>สถานที่:</label>
                <input type="text" name="location" required>
                <button type="submit" class="btn-save">บันทึกข้อมูล</button>
            </form>
        </div>
    @else
        <h4 class="text-show2">แก้ไขกิจกรรม</h4>
        <div class="box-activity">
            <form method="POST" action="{{ route('updateActivity',['id_club'=>$leaderclub->id,'id_activity'=>$activity->id]) }}">
                @csrf
                <label>ชื่อกิจกรรม:</label>
                <input type="text" name="name" value="{{ $activity->activity_name }}" required>
                <label>รายละเอียด:</label>
                <textarea name="description">{{ $activity->description }}</textarea>
                <label>วันที่:</label>
                <input type="date" name="date" value="{{ $activity->date }}" min="{{ date('Y-m-d') }}" id="activity_date" onchange="checkTime()" required>
                <label>เวลา:</label>
                <input type="time" name="time" value="{{ $activity->time }}" id="activity_time" onchange="checkTime()" required>
                <label>สถานที่:</label>
                <input type="text" name="location" value="{{ $activity->location }}" required>
                <div class="btn-save_cancel">
                    <button type="submit" class="btn-save">บันทึกข้อมูล</button>
                    <a href="{{ route('showActivity', ['id_club' => $leaderclub->id ]) }}" class="btn-cancel">ยกเลิก</a>
                </div>
            </form>
        </div>
    @endif
</main>
@endsection
