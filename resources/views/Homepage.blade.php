@extends('layouts.headclub')
@section('title', 'Home Page')
@section('club_name', 'CP club')
@section('username', $user->std_id)

@section('style')
    <style>
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 2%; 
            gap: 20px;
        }
        .box-welcome {
            background: #f9f6f2;
            border-radius: 40px;
            padding: 10px 20px;
            min-width: 200px;
            text-align: center;
        }
        p.textWelcome {
            text-align: center;
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .active-club{
            background: #f5f5f5ff;
            padding: 10px 30px;
            margin: 40px 50px 10px;
            border-radius: 20px; 
        }
        .activity-club{
            background: #f5f5f5ff;
            padding: 10px 30px;
            margin: 10px 50px 10px 50px;
            border-radius: 20px; 
        }
    </style>
@endsection
@section('body')
        <main>
            <div class="box-welcome">
                <p class="textWelcome">Welcome Najaa</p>
            </div> 
        </main>
            <div class="active-club">
                <h3>ชมรมที่อยู่ : </h3>
                @foreach($myClubs as $club)
                    <div >
                        <img src="{{ asset('storage/'.$club->image) }}" style="width:40px;height:40px;border-radius:50%;">
                        <a href="{{ route('club.detail',[$club->id, $user->std_id]) }}" style="font-weight:bold;text-decoration:none;color:#000;">
                            {{ $club->name }}
                        </a>
                        <br><br>
                    </div>
                @endforeach
            </div>
            <div class="activity-club">
                <h3>กิจกรรมที่กำลังจะมาถึง : </h3>
                @foreach($upcomingActivities as $act)
                    <div style="display:flex;align-items:center;gap:10px;margin:15px 0;">
                        <img src="{{ asset('storage/'.$act->club->image) }}" style="width:40px;height:40px;border-radius:50%;">
                        <div>
                            <b>{{ $act->club->name }}</b><br>
                            • วันที่ {{ \Carbon\Carbon::parse($act->date)->format('d F Y') }} | เวลา {{ $act->time }} น. | {{ $act->description }}
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        
@endsection