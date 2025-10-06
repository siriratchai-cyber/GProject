@extends('layouts.headclub')
@section('title', 'Activity')
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
        margin-left: 65%;
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
    a{
        color: black;
        text-decoration: none;
    }
    .back:hover{
        background-color: #5E5F68;
        color: white;
    }
    .box-showDetail{
        width: 95%;
        height: 500px;
        background: #f9f6f2;
        border-radius: 30px;
        display: flex;
        padding: 20px;
    }
    div img{
        width: 300px;
        height: 200px;
        margin: 0px 50% ;
        border-radius: 30px;
        margin-top: 30px;
    }
    .activityform{
        width: 50%;
        margin: 30px 0px 0px 20%;
    }
    .activityform form {
        display: flex;
        flex-direction: column;
        gap: 3px;
        max-width: 100%;
    }
    .activityform input, .activityform textarea{
        width: 80%;
        padding: 10px 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    .activityform label{
        margin: 5px 0px 0px 0px;
    }
    .btn-save:hover{
        color: #303032ff;
        background-color: #A9CF88;
    }
</style>
@endsection

@section('body')
    <main>
        <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
            <div class="box-showDetail">
                <div>
                    <img src="{{ $leaderclub->image ? asset('storage/'.$leaderclub->image) : asset('default.jpg') }}" alt="Club Image">
                </div>
                <div class="activityform">
                    <form action="{{ route('updateProfile', ['id_club' => $leaderclub->id ])}}" method="POST">
                        @csrf
                        <label>ชื่อชมรม: </label>
                        <input type="text" name="name_club" required value="{{$leaderclub->name}}"><br>

                        <label>รายละเอียดชมรม:</label>
                        <textarea name="club_detail" rows="7" >{{$leaderclub->description}}</textarea><br>

                        <button type="submit" class="btn-save">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>    
    </main>
@endsection