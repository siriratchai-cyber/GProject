<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Home Page - CP club</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #d9e7f3;
    }

    header {
      background: #2d3e50;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 30px;
    }

    .logo {
      font-size: 22px;
      font-weight: bold;
    }

    .nav a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
      font-weight: bold;
    }

    /* Welcome Box */
    .welcome {
      text-align: center;
      margin: 20px 0;
    }
    .welcome span {
      background: #f5f5f5;
      padding: 10px 30px;
      border-radius: 20px;
      font-weight: bold;
    }

   .section {
  background: #f9f6f2;
  margin: 20px auto;       
  padding: 20px;
  border-radius: 20px;
  max-width: 900px;       
  width: 90%;             
}


    .section h3 {
      margin-bottom: 15px;
    }

    /* Club list */
    .club-list {
     display: flex;
    flex-direction: column;  
    gap: 15px;               /* ระยะห่างระหว่างการ์ด */
}


    .club-card {
      display: flex;
      align-items: center;
      background: #fff;
      padding: 12px 18px;
      border-radius: 12px;
      justify-content: space-between; /* ✅ ดันปุ่มไปขวาสุด */
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      gap: 10px;
    }

    .club-logo {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      margin-right: 10px;
    }

    .club-card p {
      flex: 1;                  /* ✅ ขยายเต็มพื้นที่ที่เหลือ */
      font-weight: bold;
      font-size: 16px;
      margin: 0;
      text-align: left;
      white-space: nowrap;       /* ✅ บรรทัดเดียวเท่านั้น */
      overflow: hidden;          /* ✅ ถ้ายาวเกินให้ตัด */
      text-overflow: ellipsis;   /* ✅ ใส่ ... ต่อท้าย */
    }

    .btn-detail {
      background: #5E5F68;
      color: #fff;
      padding: 6px 12px;
      border-radius: 10px;
      text-decoration: none;
      font-size: 14px;
      flex-shrink: 0;            /* ✅ ปุ่มไม่หด */
    }

    /* Activity card */
    .activity-card {
      background: #fff;
      padding: 10px 15px;
      border-radius: 10px;
      margin-bottom: 10px;
    }

  </style>
</head>
<body>

<header>
  <div class="logo">CP club</div>
  <div class="nav">
    <a href="{{ route('clubs.index') }}">All Clubs</a>
    <a href="{{ route('homepage.index') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
  </div>
</header>

{{-- ✅ Welcome Message --}}
<div class="welcome">
  <span>Welcome {{ $user->std_name }}</span>
</div>

{{-- ✅ Clubs --}}
<div class="section">
  <h3>ชมรมที่คุณอยู่</h3>
  @if($myClubs->isEmpty())
    <p>- ยังไม่มีชมรม -</p>
  @else
    <div class="club-list">
      @foreach($myClubs as $club)
        <div class="club-card">
          <img src="{{ $club->image ? asset('storage/'.$club->image) : asset('images/default.png') }}" 
               alt="club logo" class="club-logo">
          <p>{{ $club->name }}</p>
          <a href="{{ route('clubs.show',$club->id) }}" class="btn-detail">รายละเอียด</a>
        </div>
      @endforeach
    </div>
  @endif
</div>

{{-- ✅ Activities --}}
<div class="section">
  <h3>กิจกรรมที่กำลังมาถึง</h3>
  @if(empty($activities))
    <p>- ยังไม่มีกิจกรรม -</p>
  @else
    @foreach($activities as $act)
      <div class="activity-card">
        <p>{{ $act->title }} | {{ $act->date }} เวลา {{ $act->time }}</p>
      </div>
    @endforeach
  @endif
</div>

</body>
</html>
