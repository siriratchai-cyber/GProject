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

    /* Buttons */
    .actions { display:flex; gap:15px; justify-content:flex-start; margin:10px 5% 0; }
    .btn { padding:8px 20px; border-radius:20px; border:none; cursor:pointer; font-size:14px; font-weight:bold; background:#f9f6f2; border:1px solid #ccc; transition:0.3s; }
    .btn:hover { background:#5E5F68; color:white; }

    /* Calendar + Activity layout */
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
    <div class="username-box">{{ $std_id }}</div>
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
  @if(!$hasLeader)
  <form action="{{ route('clubs.requestLeader',$club->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn">ขอเป็นหัวหน้าชมรม</button>
  </form>
  @endif
  <form id="leaveForm" action="{{ route('clubs.leave',$club->id) }}" method="POST">
    @csrf
    <button type="button" class="btn" onclick="confirmLeave()">ออกจากชมรม</button>
  </form>
</div>

<!-- Grid -->
<div class="grid">
  <!-- Calendar -->
  <div class="box">
    <h3>ปฏิทินกำหนดการกิจกรรม</h3>
    <div id="calendar"></div>
  </div>
<<<<<<< HEAD
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
                <p>รายละเอียด : {{ $activity->description }} | 📅 {{ $activity->date }} | 🕒 {{ $activity->time }} | 📍 {{ $activity->location }}</p>
                <hr>
              </div>
            </li>
          @endforeach
          </ul>
        @endif
      </div>
    </div>
=======

  <!-- Activity List -->
  <div class="box">
    <h3>กิจกรรมของชมรม</h3>
    <div id="activityList"></div>
>>>>>>> parent of cc8f0e0 (Merge branch 'feature-activity-update' into updateLeader)
  </div>
</div>

<script>
  const activities = @json($club->activities);
  let selectedDateCell = null; // เก็บ cell ที่ถูกเลือก

  document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const activityListEl = document.getElementById('activityList');

    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'th',
      firstDay: 0,
      selectable: true,
      events: activities.map(act => ({
        title: act.title,
        start: act.date,
        display: 'list-item',
        extendedProps: {
          description: act.description,
          time: act.time,
          location: act.location
        }
      })),
      dateClick: function(info) {
        // เอากรอบเขียวออกจาก cell ก่อนหน้า
        if (selectedDateCell) {
          selectedDateCell.classList.remove('selected');
        }
        // ใส่กรอบเขียวให้ cell ที่คลิก
        selectedDateCell = info.dayEl;
        selectedDateCell.classList.add('selected');

        showActivities(info.dateStr);
      }
    });

    calendar.render();

    // ✅ ฟังก์ชันโชว์กิจกรรมของวัน
    function showActivities(dateStr) {
      const todayActs = activities.filter(act => act.date === dateStr);
      activityListEl.innerHTML = "";
      if(todayActs.length === 0){
        activityListEl.innerHTML = "<p>- ไม่มีกิจกรรมในวันนี้ -</p>";
      } else {
        todayActs.forEach(act => {
          const div = document.createElement("div");
          div.classList.add("activity-card");
          div.innerHTML = `
            <strong>${act.title}</strong>
            วันที่: ${act.date} เวลา: ${act.time}<br>
            สถานที่: ${act.location}<br>
            รายละเอียด: ${act.description}
          `;
          activityListEl.appendChild(div);
        });
      }
    }

    // ✅ ค่าเริ่มต้นแสดงกิจกรรมวันนี้
    const today = new Date().toISOString().split('T')[0];
    showActivities(today);
  });

  function confirmLeave() {
    Swal.fire({
      title: 'ยืนยันการออกจากชมรม?',
      text: "คุณแน่ใจหรือไม่ว่าต้องการออกจากชมรมนี้",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ใช่, ออกจากชมรม',
      cancelButtonText: 'ยกเลิก'
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('leaveForm').submit();
      }
    })
  }
</script>

</body>
</html>
