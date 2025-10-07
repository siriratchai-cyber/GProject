@extends('layouts.headclub')
@section('title', 'กิจกรรมชมรม')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    main { 
        width: 95%;
        margin: 2% auto;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    p{ 
        font-size:18px; 
    }
    .box-activity{
        width: 100%;
        height: auto;
        background: #f9f6f2;
        border-radius: 30px; 
        display: flex;
        padding: 10px 20px;
        gap: 10px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .box-activity form {
        display: flex;
        flex-direction: column;
        justify-content: center;
        width: 100%;
        gap: 5px;
        padding: 3% 20%;
    }
    .back{ 
        position: absolute;
        left: 5%;
        top: 12%;
        background: none;
        border: 1px solid #000;
        border-radius: 20px;
        padding: 6px 20px;
        font-size: 15px;
        color: black;
        text-decoration: none;
    }
    .back:hover{
        background:#5E5F68; 
        color:white;
    }
    a{ 
        text-decoration:none; 
        color:black; 
    }
    .box-activity label {
        font-weight: bold;
        font-size: 14px;
    }

    .box-activity input,
    .box-activity textarea {
        width: 80%;
        padding: 6px 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    textarea{ 
        min-height:60px; 
    }

    .btn-save{ 
        background-color: #5E5F68;
        color: white;
        border: none;
        border-radius: 20px;
        color: white;
        padding: 8px 15px;
        cursor: pointer;
        font-size: 14px;
        width: fit-content;
        margin-left: 70%;
        margin-top: 2%;
    }
    .btn-save:hover{ 
        background:#A9CF88; 
        color:#303032; 
    }
    .btn-delete{ 
        border-style: none;
        color: black;
        background-color: #F69191;
        font-size: 14px;
        cursor: pointer;
        padding: 10px 25px;
        border-radius: 20px;
        margin-left: 40px;
    }
    .btn-delete:hover{ 
        background:red; 
        color:white;
    }
    .btn-cancel{ 
        border: 1px solid black;
        color: black;
        background-color: #f9f6f2;
        font-size: 14px;
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 20px;
        margin-left: 10px;
    }
    .btn-cancel:hover{ 
        background:red; 
        color:white;
    }
    .showactivity{
        border-collapse: collapse;
        font-size: 16px;
        min-width: 400px;
        width: 100%;
        border-radius: 10px 10px 5px 5px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0,0.15);
        background-color: #f9f6f2;
        margin-bottom: 30px;
    }
    .showactivity thead tr{
        background-color: #5E5F68;
        color: white;
        text-align: center;
        font-weight: bold;
    }
    .showactivity th, .showactivity td{
        padding: 10px 55px;
    }
    .showactivity tr{
        border-bottom: 1px solid #5E5F68;
    }
    .box-showActivities{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    a.btn-edit{
        border: 1px solid black;
        padding: 10px 20px;
        border-radius: 30px;
        font-size: 14px;
    }
    a.btn-edit:hover{
        color: white;
        background-color: #5E5F68;
    }
    .action-btns {
        display: flex;
        align-items: center;
        gap: 20px;
        justify-content: flex-end;
    }
    span{
        margin: 0px 45%;
    }
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
            alert("❌ วันหรือเวลาน้อยกว่าปัจจุบัน");
            Input_time.value = ""
        }
    }
</script>
@endsection

@section('body')
<main>
    <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id]) }}" class="back">⬅ กลับไป</a>

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
                                <form action="{{ route('deleteActivity', ['id_club' => $leaderclub->id, 'id_activity' => $a->id ]) }}" method="post">
                                    @csrf
                                    <button class="btn-delete">ลบ</button>
                                </form>
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
