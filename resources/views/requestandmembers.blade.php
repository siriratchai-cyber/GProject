@extends('layouts.headclub')
@section('title', 'Request and Members')
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

    .showtable{
        border-collapse: collapse;
        font-size: 16px;
        min-width: 400px;
        width: 100%;
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
        margin:  -15px 5px 0px 0px;
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
    div.btn-a_r{
        display: flex;
        align-items: center;
        gap: 20px;
        justify-content: flex-end;
    }
</style>
@endsection

@section('body')
    <main>
        <div>
            @if($from == "homepage")
            <a href="{{ route('backtoHome', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
            @elseif($from == "club")
            <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
            @endif
        </div>
        <div>
            <p class="text">คำร้องขอสมัครเข้าชมรม</p>
            <table class="showtable">
                <thead>
                    <th>ชื่อ</th><th>รหัสนักศึกษา</th><th>สาขา</th><th>ชั้นปี</th><th></th>
                </thead>
                <tbody>
                    @if($member_pending->isEmpty())
                    <tr>
                        <td colspan="5"><span class="request">ขณะนี้ยังไม่มีคำร้องเข้ามา</span></td>
                    </tr>
                    @else
                        @foreach($member_pending as $member)      
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->student_id}}</td>
                            <td>{{ $member->account->major}}</td>
                            <td>{{ $member->account->year}}</td>

                            <td>
                                <div class="btn-a_r">
                                <form action="{{ route('approved',['from' => $from,'id_club' => $member->club_id, 'id_member' => $member->id]) }}" method="post">
                                    @csrf
                                    <input type="submit" value="อนุมัติ" class="btn-approve">
                                </form>
                                <form action="{{ route('rejected',['from' => $from, 'id_club' => $member->club_id, 'id_member' => $member->id]) }}" method="post">
                                    @csrf
                                    <button class="btn-reject">ไม่อนุมัติ</button>
                                </form> 
                                </div>    
                            </td>
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
                        <td>{{ optional($member->account)->major }}</td>
                        <td>{{ optional($member->account)->year }}</td>

                        <td>{{$member->role}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection