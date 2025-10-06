<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>{{ $club->name }} - CP Club</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- FullCalendar -->
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

  <style>
    body { margin:0; font-family: "Arial", sans-serif; background:#d9e7f3; }
    header { background:#2d3e50; color:white; display:flex; justify-content:space-between; align-items:center; padding:10px 30px; }
    .logo { font-size:28px; font-weight:bold; font-family:"Georgia", cursive; }
    .nav { display:flex; gap:20px; }
    .nav a { color:white; text-decoration:none; font-weight:bold; }

    /* Club Info */
    .club-info { display:flex; background:#f9f6f2; margin:20px auto; padding:20px; border-radius:20px; width:90%; gap:20px; align-items:center; }
    .club-info img { width:300px; height:150px; border-radius:20px; object-fit:cover; }
    .club-info p { flex:1; font-size:15px; line-height:1.6; color:#333; }
    .club-activities { display:flex; background:#f9f6f2; margin:20px auto; padding:20px; border-radius:20px; width:90%; gap:20px; align-items:center; }
    /* Buttons */
    .actions { display:flex; gap:15px; justify-content:flex-start; margin:10px 5% 0; }
    .btn { padding:8px 20px; border-radius:20px; border:none; cursor:pointer; font-size:14px; font-weight:bold; background:#f9f6f2; border:1px solid #ccc; transition:0.3s; }
    .btn:hover { background:#5E5F68; color:white; }

    .grid { display:grid; grid-template-columns:1fr 2fr; gap:20px; margin:20px auto; width:90%; }
    .box { background:#f9f6f2; padding:20px; border-radius:20px; }
    .box h3 { margin-top:0; }

    /* Activity list */
    #activityList .activity-card { background:white; border-radius:15px; padding:15px; margin-bottom:15px; }
    #activityList strong { display:block; margin-bottom:5px; }

    /* Event dot (สีแดง) */
    .fc-daygrid-event-dot {
      border-color: red !important;
      background-color: red !important;
    }

    /* ✅ วันนี้ (วงกลมฟ้าอ่อน) */
    .fc-day-today .fc-daygrid-day-number {
      background: #87CEFA;
      color: black;
      border-radius: 50%;
      padding: 5px 9px;
      font-weight: bold;
    }

    /* ✅ วันที่เลือก (กรอบเขียว) */
    .fc-daygrid-day.selected {
      border: 2px solid green !important;
      border-radius: 10px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">CP Club</div>
  <div class="nav">
    <a href="{{ route('clubs.index') }}">All Clubs</a>
    <a href="{{ route('homepage.index') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
  </div>
</header>

<!-- Flash Message -->
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

<!-- Club Info -->
<div class="club-info">
  <img src="{{ $club->image ? asset('storage/'.$club->image) : asset('default.jpg') }}" alt="Club Banner">
  <p>{{ $club->description }}</p>
</div>

<!-- Buttons -->
<div class="actions">
  @if(empty($hasLeader) || !$hasLeader)
  <form action="{{ route('requestToleader', ['id_club' => $club->id, 'from' => 'clubdetail']) }}" method="GET">
    @csrf
    <button type="submit" class="btn">ขอเป็นหัวหน้าชมรม</button>
  </form>
@endif

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
