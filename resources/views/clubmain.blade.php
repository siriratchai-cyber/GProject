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
        width: 95%;
        margin: 2% auto;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    .request{
        position: absolute;
        right: 8%;
        top: 15%;
        background: #f9f6f2;
        border: 1px solid #000;
        border-radius: 20px;
        padding: 6px 20px;
        color: black;
        font-size: 14px;
        text-decoration: none;
    }
    a{
        color: black;
        text-decoration: none;
    }
    .request:hover{
        color: white;
        background-color: #5E5F68;
    }
    .request span {
        color: red;
        font-weight: bold;
    }
    span.showtotal{
        color:red;
        font-weight: bold;
        margin-left: 5px;
    }
    div .back{
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
        background-color: #5E5F68;
        color: white;
    }
    a{
        color: black;
        text-decoration: none;
    }
    .box-member_edit{
        margin-top: -1%;
    }
    .box-member_edit a{
        background-color: #f9f6f2;
        border-radius: 30px;
        margin: 0px 5px;
        padding: 5px 10px;
        font-size: 14px;
        border: 1px solid #000;
        border-radius: 20px;
        padding: 6px 20px;
    }
    .box-member_edit a:hover
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
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .box-showclub img{
        width: 300px;
        height: 150px;
        margin: 20px 30px 20px 20px;
        border-radius: 30px;
        border: 1px solid black;
        float: left;
    }
    .box-leave{
        display: flex; 
        align-items: center;
        justify-content: end;
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
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    }
    .activity hr {
        height: 1px;  
        background-color: #000000ff; 
        margin: 10px 10px 15px -25px;       
    }
    .activity p.content{
        margin: 0px 2px;
    }
    .activity p.content_head{
        margin: 5px 2px;
        padding-top: 15px;
    }
    .btn-leave{
        background: #f9f6f2;
        border-radius: 30px;
        border: 1px solid black;
        padding: 5px 15px;
        height: auto;
        font-size: 14px;
    }
    .btn-leave:hover{
        color: white;
        background-color: red;
    }
    .activity h4{
        font-size: 18px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 8px;
        margin-bottom: 15px;
        margin-top: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .club-info {
        flex: 1;
        margin-left: 40px;
    }

    .club-info h3 {
        font-size: 22px;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .club-info p {
        margin: 0;
        color: #444;
    }
</style>
@endsection

@section('body')
    <main>
            <div class="box-select">
                <a href="{{ route('backtoHome', ['id_club' => $leaderclub->id]) }}" class="back">⬅ กลับไป</a>
               <a href="{{ route('requestToleader', ['from' => 'club', 'id_club' => $leaderclub->id]) }}" class="request">
                    คำร้องขอ | <span>{{$pendingCount}}</span>
                </a>
            </div>
            <div class="box-member_edit">
                <a href="{{ route('requestToleader',['from' => 'club', 'id_club' => $leaderclub->id ]) }}">สมาชิกทั้งหมด</a>
                <a href="{{ route('editProfile', ['id_club' => $leaderclub->id ]) }}">แก้ไขโปรไฟล์</a>
            </div>
            <div class="box-showclub">
                <p>
                   <img src="{{ $leaderclub->image ? asset('storage/'.$leaderclub->image) : asset('default.jpg') }}" alt="club Image">
                    <div class="club-info">
                        <h3>{{ $leaderclub->name }}</h3>
                        <p>{{ $leaderclub->description }}</p>
                    </div>
                </p>
            </div>
            <div class="activity">
                <h4>
                กิจกรรมทั้งหมดของชมรม
                </h4>

                @if($activities->isEmpty())
                    <p class="no-data">ยังไม่มีกิจกรรม</p>
                @else
                <ul>
                    @foreach($activities as $activity)
                    <li>
                        <div class="activity-item">
                            <strong>{{ $activity->activity_name }}</strong>
                            <p>รายละเอียด : {{ $activity->description }}</p>
                            <p>📅 {{ $activity->date }} | 🕒 {{ $activity->time }} | 📍 {{ $activity->location }}</p>
                            <hr>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            <a href="{{ route('showActivity', ['id_club' => $leaderclub->id ]) }}" class="edit-activity">แก้ไขกิจกรรม</a>
    </main>
    
@endsection