<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $club->name }} - CP Club</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <style>
    body { margin:0; font-family: "Arial", sans-serif; background:#d9e7f3; }
    header { background:#2d3e50; color:white; display:flex; justify-content:space-between; align-items:center; padding:10px 30px; }
    .logo { font-size:28px; font-weight:bold; font-family:"Arial", cursive; }
    .nav { display:flex; gap:20px; }
    .nav a { color:white; text-decoration:none; font-weight:bold; }

    .club-info { display:flex; background:#f9f6f2; margin:20px auto; padding:20px; border-radius:20px; width:90%; gap:20px; align-items:center; }
    .club-info img { width:300px; height:150px; border-radius:20px; object-fit:cover; }
    .club-info p { flex:1; font-size:15px; line-height:1.6; color:#333; }
    .club-activities { display:flex; background:#f9f6f2; margin:20px auto; padding:20px; border-radius:20px; width:90%; gap:20px; align-items:center; }

    .actions { display:flex; gap:15px; justify-content:flex-start; margin:10px 5% 0; }
    .btn { padding:8px 20px; border-radius:20px; border:none; cursor:pointer; font-size:14px; font-weight:bold; background:#f9f6f2; border:1px solid #ccc; transition:0.3s; }
    .btn:hover { background:#5E5F68; color:white; }

    .grid { display:grid; grid-template-columns:1fr 2fr; gap:20px; margin:20px auto; width:90%; }
    .box { background:#f9f6f2; padding:20px; border-radius:20px; }
    .box h3 { margin-top:0; }

    #activityList .activity-card { background:white; border-radius:15px; padding:15px; margin-bottom:15px; }
    #activityList strong { display:block; margin-bottom:5px; }
    .btn-back {
      background: #5e5f68;
      color: white;
      border-radius: 25px;
      padding: 7px 18px;
      font-weight: 600;
      display: inline-block;
      margin-top: 25px;
      margin-left: 25px;
      text-decoration: none;
    }
  </style>
</head>
<body>

<header>
    <div class="username-box">{{ $std_id }}</div>
    <div class="logo">CP Club</div>
    <div class="nav">
      <a href="{{ route('clubs.index') }}">All Clubs</a>
      <a href="{{ route('homepage.index') }}">Dashboard</a>
      <a href="{{ route('logout') }}">Logout</a>
    </div>
  </header>
  <a href="{{ route('homepage.index') }}" class=" btn-back">⬅ กลับ</a>


@if(session('success'))
<script>
Swal.fire({ icon:'success', title:'สำเร็จ!', text:"{{ session('success') }}", confirmButtonColor:'#3085d6', confirmButtonText:'ตกลง' });
</script>
@endif
@if($errors->any())
<script>
Swal.fire({ icon:'error', title:'ไม่สำเร็จ!', text:"{{ implode(', ', $errors->all()) }}", confirmButtonColor:'#d33', confirmButtonText:'ปิด' });
</script>
@endif


<div class="club-info">
  <img src="{{ $club->image ? asset('storage/'.$club->image) : asset('default.jpg') }}" alt="Club Banner">
  <p>{{ $club->description }}</p>
</div>


<div class="actions">
  <form id="leaveForm" action="{{ route('clubs.cancel', $club->id) }}" method="POST">
    @csrf
    <button type="button" class="btn" onclick="confirmLeave()">ออกจากชมรม</button>
  </form>
  </div>
  <div class="club-activities">
    <div class="box">
      <h3>กิจกรรมของชมรม</h3>
      <div id="activityList">
        @if($activities->isEmpty())
            <p class="no-data">ยังไม่มีกิจกรรม</p>
        @else
          <ul>
          @foreach($activities as $activity)
            <li>
              <div class="activity-item">
                <strong>{{ $activity->activity_name }}</strong>
                <📅>รายละเอียด : {{ $activity->description }} | 📅 {{ $activity->date }} | 🕒 {{ $activity->time }} | 📍 {{ $activity->location }}</📅>
                <hr>
              </div>
            </li>
          @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>

<script>
  let selectedDateCell = null; 

function confirmLeave() {
  Swal.fire({
    title: 'ยืนยันการออกจากชมรม?',
    text: "คุณแน่ใจหรือไม่ว่าต้องการออกจากชมรมนี้",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'ใช่, ออกจากชมรม',
    cancelButtonText: 'ยกเลิก'
  }).then((result) => {
    if (result.isConfirmed) {
      document.getElementById('leaveForm').submit();
    }
  });
}
</script>


</body>
</html>
