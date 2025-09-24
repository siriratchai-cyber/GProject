@extends('layouts.headclub')
@section('title', 'Request and Members')
@section('club_name', $club->name)
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

    .showtable{
        border-collapse: collapse;
        font-size: 16px;
        min-width: 400px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0,0.15);
        background-color: #f9f6f2;
        margin-bottom: 30px;
    }
    .showtable thead tr{
        background-color: #5E5F68;
        color: white;
        text-align: left;
        font-weight: bold;
    }
    .showtable th, .showtable td{
        padding: 10px 55px;
    }
    .showtable tr{
        border-bottom: 1px solid #5E5F68;
    }
    .text{
        font-size: 20px;
        margin:  10px 5px 0px 0px;
    }
    .btn-approve{
        border-style: none;
        background-color: #A9CF88;
        border-radius: 20px;
        padding: 10px 40px;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-approve:hover{
        background-color: green;
        color: white;
    }
    .btn-reject{
        border-style: none;
        background-color: #F69191;
        font-size: 14px;
        cursor: pointer;
        padding: 10px 40px;
        border-radius: 20px;
    }
    .btn-reject:hover{
        background-color: red;
        color: white;
    }
    p{
        padding-bottom: 20px;
    }
    .showmembers{
        display: flex;
        flex-direction: column;
    }
    span.request{
        padding: 10px 350px;
        margin: 0px 125px;
    }
</style>
@endsection

@section('body')
    <main>
        <div>
            <a href="{{ route('backtoHome', ['id_club' => $club->id, 'id_member' => $user->id]) }}" class="back">⬅ กลับไป</a>
        </div>
        <div>
            <p class="text">คำร้องขอสมัครเข้าชมรม</p>
            <table class="showtable">
                <thead>
                    <th>ชื่อ</th><th>รหัสนักศึกษา</th><th>สาขา</th><th>ชั้นปี</th><th class="empty"></th><th class="empty"></th>
                </thead>
                <tbody>
                    @if($member_pending->isEmpty())
                    <tr>
                        <td colspan="6"><span class="request">ขณะนี้ยังไม่มีคำร้องเข้ามา</span></td>
                    </tr>
                    @else
                        @foreach($member_pending as $member)      
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->student_id}}</td>
                            <td>{{$member->account->major}}</td>
                            <td>{{$member->account->year}}</td>
                            <td><form action="{{ route('approved',['id_club' => $member->club_id, 'id_member' => $member->id]) }}" method="post">
                                @csrf
                                <input type="submit" value="อนุมัติ" class="btn-approve">
                            </form></td>
                            <td><form action="{{ route('rejected',['id_club' => $member->club_id, 'id_member' => $member->id]) }}" method="post">
                                @csrf
                                <input type="submit" value="ไม่อนุมัติ" class="btn-reject">
                            </form></td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="showmembers">
            <p class="text">รายชื่อนักศึกษาในชมรม</p>
            <table class="showtable">
                <thead>
                    <th>ชื่อ</th><th>รหัสนักศึกษา</th><th>สาขา</th><th>ชั้นปี</th><th>ตำแหน่ง</th>
                </thead>
                <tbody>
                    @foreach($member_approved as $member)
                    <tr>
                        <td>{{$member->name}}</td>
                        <td>{{$member->student_id}}</td>
                        <td>{{$member->account->major}}</td>
                        <td>{{$member->account->year}}</td>
                        <td>{{$member->role}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection