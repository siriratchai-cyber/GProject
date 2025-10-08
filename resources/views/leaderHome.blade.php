@extends('layouts.headclub')

@section('title', 'Club Leader Home')
@section('club_name', $leaderclub->name)
@section('username', $account->std_id)


@section('style')
<style>
    @import url("{{ asset('css/leaderhome.css') }}");
</style>
@endsection

@section('body')
<main>
    <div class="welcome">
        <span>👋 Welcome Club Leader</span>
    </div>

    <a href="{{ route('requestToleader', ['from' => 'homepage', 'id_club' => $leaderclub->id]) }}" class="request-btn">
        คำร้องขอ | <span>{{ $pendingCount }}</span>
    </a>

    <div class="club-header">
        <img src="{{ $leaderclub->image ? asset('storage/'.$leaderclub->image) : asset('default.jpg') }}" alt="Club Image">
        <div class="club-info">
            <h3>{{ $leaderclub->name }}</h3>
            <p>{{ $leaderclub->description }}</p>
        </div>
        <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id]) }}" class="edit-btn">จัดการชมรม</a>
    </div>

    <div class="activity-section">
        <div class="activity-box">
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
    </div>
</main>
@endsection
