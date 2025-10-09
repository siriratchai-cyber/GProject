@extends('layouts.headclub')
@section('title', 'Club Homepage')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    @import url("{{ asset('css/clubmain.css') }}");
</style>
@endsection

@section('body')
    <main>
            <div class="box-select">
                <a href="{{ route('backtoHome')}}" class="back">⬅ กลับ</a>
                <a href="{{ route('requestToleader', ['from' => 'club', 'id_club' => $leaderclub->id]) }}" class="request">
                    คำร้องขอ | <span>{{ $pendingCount }}</span>
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