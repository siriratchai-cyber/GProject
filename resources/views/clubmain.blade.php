@extends('layouts.headclub')
@section('title', 'Club Homepage')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    * {
    box-sizing: border-box;
    }
    main {
        display: flex;
        flex-direction: column;
        margin: 3% 10%; 
        gap: 20px;
    }
    .request{
        background: #f9f6f2;
        border-radius: 30px;
        border: 1px solid black;
        padding: 5px 15px;
        height: auto;
        display: flex; 
        align-items: center;
        justify-content: center;
        margin-left: 89%; 
        text-align: center;
        font-size: 14px;
    }
    a{
        color: black;
        text-decoration: none;
    }
    .request:hover{
        color: white;
        background-color: #5E5F68;
    }
    span.showtotal{
        color:red;
        font-weight: bold;
        margin-left: 5px;
    }
    div .back{
        background: #d9e7f3;
        border-radius: 30px;
        border: 1px solid black;
        width: 10%;
        height: 10%;
        padding: 5px 15px;
        margin-left: -8%;
        display: flex; 
        align-items: center;
        justify-content: center;
    }
    .back:hover{
        background-color: #5E5F68;
        color: white;
    }
    a{
        color: black;
        text-decoration: none;
    }
    .box-member_edit a
    , .box-leave a{
        background-color: #f9f6f2;
        border-radius: 30px;
        margin: 0px 5px;
        padding: 5px 10px;
        font-size: 14px;
    }
    .box-member_edit a:hover
    , .box-leave a:hover
    , .edit-activity:hover{
        background-color: #5E5F68;
        color: white;
    }
    .box-showclub{
        width: 100%;
        height: auto;
        background: #f9f6f2;
        border-radius: 30px; 
        padding: 10px;
        box-sizing: border-box;
    }
    .box-showclub img{
        width: 300px;
        height: 150px;
        margin: 0px 30px 20px 20px;
        border-radius: 30px;
        border: 1px solid black;
        float: left;
    }
    .box-leave{
        display: flex; 
        align-items: center;
        justify-content: center;
        margin-left: 950px; 
    }
    .text-1{
        font-size: 18px;
        margin-bottom: 10px;
    }
    .edit-activity{
        background-color: #f9f6f2;
        border-radius: 30px;
        border: 1px solid black;
        padding: 5px 10px;
        font-size: 14px;
        display: flex; 
        align-items: center;
        justify-content: center;
        margin-left: 90%; 
        width: 10%;
    }
    .activity{
        width: 100%;
        height: 300px;
        background: #f9f6f2;
        border-radius: 30px; 
        padding: 5px 30px;
        display: flex;
        flex-direction: column;
        word-wrap: break-word;  
        overflow-wrap: break-word;
        overflow-y: auto;
        overflow-x: hidden;
        gap: 10px;
    }
    .activity hr {
        height: 1px;  
        background-color: #000000ff; 
        margin: 10px 0px 2px 0px;       
    }
    .activity p.content{
        margin: 2px 2px;
    }
    .activity p.content_head{
        margin: 5px 2px;
        padding-top: 15px;
    }
</style>
@endsection

@section('body')
    <main>
            <div class="box-select">
                <a href="{{ route('backtoHome', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
                <a href="{{ route('requestToleader',['id_club' => $leaderclub->id ]) }}" class="request">คำร้องขอ | <span class="showtotal">{{$pendingCount}}</span></a>
            </div>
            <div class="box-member_edit">
                <a href="{{ route('requestToleader',['id_club' => $leaderclub->id ]) }}">สมาชิกทั้งหมด</a>
                <a href="{{ route('editProfile', ['id_club' => $leaderclub->id ]) }}">แก้ไขโปรไฟล์</a>
            </div>
            <div class="box-showclub">
                <p>
                   <img src="{{ $leaderclub->image ? asset('storage/'.$leaderclub->image) : asset('default.jpg') }}" alt="">
                    <p>{{$leaderclub->description}}
                    </p>
                </p>
            </div>
            <div class="box-leave">
                <a href="">เลิกเป็นหัวหน้าชมรม</a>
                <a href="">ออกจากชมรม</a>
            </div>
            <p class="text-1">กิจกรรมของชมรม</p>
            <div class="activity">
                <p class="content_head">กิจกรรมที่ 1</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
                <p class="content_head">กิจกรรมที่ 2</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
                <p class="content_head">กิจกรรมที่ 3</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
                <p class="content_head">กิจกรรมที่ 4</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
            </div>
            <a href="{{ route('activity', ['id_club' => $leaderclub->id ]) }}" class="edit-activity">แก้ไขกิจกรรม</a>
    </main>
    
@endsection