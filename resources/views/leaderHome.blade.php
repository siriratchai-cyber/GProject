@extends('layouts.headclub')

@section('title', 'Club Leader Home')
@section('club_name', $leaderclub->name)
@section('username', $account->std_id)


@section('style')
<style>
    body {
        background-color: #d9e7f3;
        font-family: "Arial", sans-serif;
    }

    main {
        width: 95%;
        margin: 2% auto;
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    .welcome {
        text-align: center;
        margin-top: -5%;
        margin-bottom: 30px;
    }
    .welcome span {
        background: #f9f6f2;
        padding: 10px 30px;
        border-radius: 25px;
        font-weight: bold;
        font-size: 18px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.08);
    }

    .request-btn {
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

    .request-btn:hover {
        background-color: #5E5F68;
        color: white;
    }

    .request-btn span {
        color: red;
        font-weight: bold;
    }

    .club-header {
        background: #f9f6f2;
        border-radius: 25px;
        padding: 20px 40px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .club-header img {
        width: 200px;
        height: 120px;
        border-radius: 15px;
        object-fit: cover;
        border: 1px solid #ccc;
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

    .edit-btn {
        background-color: #5E5F68;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 20px;
        cursor: pointer;
        transition: 0.2s;
        text-decoration: none;
    }

    .edit-btn:hover {
        background-color: #323339;
    }

    .activity-section {
        display: flex;
        justify-content: center;
    }

    .activity-box {
        width: 100%;
        background: #f9f6f2;
        border-radius: 25px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        padding: 20px 30px;
    }

    .activity-box h4 {
        font-size: 18px;
        border-bottom: 1px solid #ccc;
        padding-bottom: 8px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .activity-item {
        margin-bottom: 15px;
    }

    .activity-item strong {
        display: block;
        margin-bottom: 5px;
    }

    .no-data {
        font-style: italic;
        color: #666;
        text-align: center;
    }

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
