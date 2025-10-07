<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Student Homepage - CP Club</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Arial", sans-serif;
      background: #d9e7f3;
      margin: 0;
    }
    header {
      background: #2d3e50;
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 30px;
    }
    .logo {
      font-size: 32px;
      font-weight: bold;
      font-family: "Georgia", cursive;
      text-align: center;
      flex: 1;
    }
    .username-box {
      background: #1a3552;
      padding: 5px 15px;
      border-radius: 5px;
    }
    .nav { display: flex; gap: 20px; }
    .nav a { color: white; text-decoration: none; font-weight: bold; }
    .club-container { width: 80%; margin: 40px auto; display: flex; flex-direction: column; gap: 20px; }
    .section-box { background: #f9f6f2; border-radius: 20px; padding: 25px 30px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .club-item, .activity-item { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
    .no-data { color: #777; text-align: center; font-style: italic; }
  </style>
</head>
<body>
  <header>
    <div class="username-box">{{ $account->std_id }}</div>
    <div class="logo">CP Club</div>
    <div class="nav">
      <a href="{{ route('clubs.index') }}">All Clubs</a>
      <a href="{{ route('homepage.index') }}">Dashboard</a>
      <a href="{{ route('logout') }}">Logout</a>
    </div>
  </header>

  <div class="welcome-section d-flex justify-content-center mt-4">
    <div class="welcome-box bg-light px-4 py-2 rounded-pill fw-bold shadow">
      👋 Welcome {{ $account->std_name }}
    </div>
  </div>

  <div class="club-container">
    <!-- ชมรมที่เป็นสมาชิก -->
    <div class="section-box">
      <h4>ชมรมที่คุณเป็นสมาชิก</h4>
      @if($myClubs->isEmpty())
        <div class="no-data">คุณยังไม่ได้เข้าร่วมชมรมใด ๆ</div>
      @else
        @foreach($myClubs as $club)
          <div class="club-item">
            <img src="{{ $club->image ? asset('storage/'.$club->image) : asset('default.jpg') }}" style="width:60px;height:60px;border-radius:50%;">
            <a href="{{ route('clubs.show', ['id' => $club->id , 'std_id' => $account->std_id] ) }}" style="font-weight:bold;text-decoration:none;color:#000;" >{{ $club->name }}</a>
          </div>
        @endforeach
      @endif
    </div>

    <!-- กิจกรรมที่จะมาถึง -->
    <div class="section-box">
      <h4>กิจกรรมที่กำลังจะมาถึง</h4>
      @if($upcomingActivities->isEmpty())
        <div class="no-data">ยังไม่มีกิจกรรมในเร็ว ๆ นี้</div>
      @else
        @foreach($upcomingActivities as $act)
          <div class="activity-item">
            <img src="{{ $act->club->image ? asset('storage/'.$act->club->image) : asset('default.jpg') }}" alt="club" style="width:40px;height:40px;border-radius:50%;">
            <div>
              <b>{{ $act->club->name }}</b><br>
              วันที่ {{ \Carbon\Carbon::parse($act->date)->format('d F Y') }}<br>
              เวลา {{ $act->time }} | {{ $act->location }}
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</body>
</html>
