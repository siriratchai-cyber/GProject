@extends('layouts.headclub')
@section('title', 'Activity')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)


@section('style')
<style>
    main {
        display: flex;
        flex-direction: column;
        margin: 3% 10%; 
        gap: 20px;
    }
    p{
        font-size: 18px;
    }
    div .box-activity{
        width: 100%;
        height: auto;
        background: #f9f6f2;
        border-radius: 30px; 
        padding: 10px;
        display: flex;
        padding: 10px 20px;
        display: flex;
        word-wrap: break-word;  
        overflow-wrap: break-word;
        gap: 10px;
    }
    
    div .back{
        background: #d9e7f3;
        border-radius: 30px;
        border: 1px solid black;
        width: 10%;
        height: 10%;
        padding: 5px 20px;
        margin-left: -8%;
        display: flex; 
        align-items: center;
        justify-content: flex-start;
    }
    a{
        color: black;
        text-decoration: none;
    }

    .box-activity form {
        display: flex;
        flex-direction: column;
        width: 100%;
        gap: 5px;
        margin: 3% 20%;
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

    .box-activity textarea {
        min-height: 60px;
    }

    .btn-save {
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
    }
    .back:hover{
        background-color: #5E5F68;
        color: white;
    }
    .btn-save:hover{
        color: #303032ff;
        background-color: #A9CF88;
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
    .box-showactivity{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    p{
        text-align: left;
        margin-bottom: 0px;
    }
    .btn-delete{
        border-style: none;
        color: black;
        background-color: #F69191;
        font-size: 14px;
        cursor: pointer;
        padding: 10px 40px;
        border-radius: 20px;
        margin-left: 40px;
    }
    .btn-delete:hover{
        background-color: red;
        color: white;
    }
    a.btn-edit{
        border: 1px solid black;
        padding: 10px 20px;
        border-radius: 30px;
    }
    a.btn-edit:hover{
        color: white;
        background-color: #5E5F68;
    }
    span{
        margin: 0% 45%;
    }
    .action-btns {
        display: flex;
        align-items: center;
        gap: 20px;
        justify-content: flex-end;
    }
    .btn-save_cancel{
        display: flex;
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
        cursor: pointer;
    }
    .btn-cancel:hover{
        color: white;
        background-color: red;
    }

</style>
@endsection

@section('body')
    <main>
        <div>
            <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
        </div>
        <p class="text-show">กิจกรรมที่กำลังดำเนินการอยู่</p>
        <div class="box-showactivity">
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
                                    <input type="submit" value="ลบ" class="btn-delete">
                                </form>
                                <a href="{{ route('editActivity', ['id_club' => $leaderclub->id, 'id_activity' => $a->id ]) }}" class="btn-edit">แก้ไข</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if( $activity == null )
        <p>เพิ่มกิจกรรมใหม่</p>
        <div>
            <div class="box-activity">
               <form action="{{ route('addActivity', ['id_club' => $leaderclub->id ]) }}" method="post">
                @csrf
                <label>ชื่อกิจกรรม: </label>
                <input type="text" name="name" required><br>

                <label>รายละเอียดกิจกรรม:</label>
                <textarea name="description" required></textarea><br>

                <label>วันที่: </label>
                <input type="date" name="date" required>

                <label>เวลา: </label>
                <input type="time" name="time" required><br>

                <label>สถานที่: </label>
                <input type="text" name="location" required><br><br>

                <button type="submit" class="btn-save">บันทึกข้อมูล</button>
            </form>
            </div>
        </div>
        @elseif($activity != null)
        <p>แก้ไขรายละเอียดกิจกรรม</p>
        <div>
            <div class="box-activity">
               <form action="{{ route('updateActivity', ['id_club' => $leaderclub->id, 'id_activity' => $activity->id ]) }}" method="post">
                @csrf
                <label>ชื่อกิจกรรม: </label>
                <input type="text" name="name" value="{{ $activity->activity_name }}" required><br>

                <label>รายละเอียดกิจกรรม:</label>
                <textarea name="description">{{ $activity->description }}</textarea><br>

                <label>วันที่: </label>
                <input type="date" name="date" value="{{ $activity->date }}" required>

                <label>เวลา: </label>
                <input type="time" name="time" value="{{ $activity->time }}" required><br>

                <label>สถานที่: </label>
                <input type="text" name="location" value="{{ $activity->location }}" required><br><br>

                <div class="btn-save_cancel">
                    <button type="submit" class="btn-save">บันทึกข้อมูล</button>
                    <a href="{{ route('showActivity', ['id_club' => $leaderclub->id ]) }}" class="btn-cancel">ยกเลิก</a>
                </div>
            </form>
            </div>
        </div>
        @endif
    </main>
@endsection