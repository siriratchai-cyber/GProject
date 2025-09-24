@extends('layouts.headclub')
@section('title', 'Activity')
@section('club_name', $club->name)
@section('username', $leader->std_id)

@section('style')
<style>
    main {
        display: flex;
        flex-direction: column;
        margin: 3% 10%; 
        gap: 20px;
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
    div .back{
        background: #d9e7f3;
        border-radius: 30px;
        border: 1px solid black;
        width: 8%;
        height: 10%;
        padding: 5px 15px;
        margin-left: -8%;
        display: flex; 
        align-items: center;
        justify-content: center;
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
        <div>
            <a href="#" class="back">⬅ กลับไป</a>
        </div>
            <div class="box-showDetail">
                <div>
                    <img src="{{ asset('uploads/' . $club->image )}}" alt="">
                </div>
                <div class="activityform">
                    <form action="{{ route('editProfile', ['id_club' => $club->id, 'id_member' => $leader->id])  }}" method="post">
                        @csrf
                        <label>ชื่อชมรม: </label>
                        <input type="text" name="name_club" required value="{{$club->name}}"><br>

                        <label>รายละเอียดชมรม:</label>
                        <textarea name="club_detail" rows="7" >{{$club->description}}</textarea><br>

                        <button type="submit" class="btn-save">บันทึกข้อมูล</button>
                    </form>
                </div>
            </div>    
    </main>
@endsection