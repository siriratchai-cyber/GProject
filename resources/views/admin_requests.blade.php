<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>จัดการคำร้องทั้งหมด</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#d9e7f3;font-family:'Arial',sans-serif;}
    .container{background:#f9f6f2;border-radius:15px;padding:30px;margin-top:20px;}
    table{background:white;border-radius:10px;overflow:hidden;}
    th{background:#5E5F68;color:white;}
    .btn-ok{background:#A9CF88;border:none;border-radius:20px;padding:6px 18px;}
    .btn-no{background:#F69191;border:none;border-radius:20px;padding:6px 18px;}
  </style>
</head>
<body>
<div class="container">
  <h3>คำร้องขอสร้างชมรม</h3>
  <table class="table">
    <thead><tr><th>ชื่อชมรม</th><th>รายละเอียด</th><th>จัดการ</th></tr></thead>
    <tbody>
      @forelse($pendingClubs as $club)
      <tr>
        <td>{{ $club->name }}</td>
        <td>{{ $club->description }}</td>
        <td>
          <form action="{{ route('admin.clubs.approve',$club->id) }}" method="POST" style="display:inline">@csrf<button class="btn-ok">อนุมัติ</button></form>
          <form action="{{ route('admin.clubs.reject',$club->id) }}" method="POST" style="display:inline">@csrf<button class="btn-no">ไม่อนุมัติ</button></form>
        </td>
      </tr>
      @empty
      <tr><td colspan="3" class="text-center">ไม่มีคำร้อง</td></tr>
      @endforelse
    </tbody>
  </table>

  <h3 class="mt-5">คำร้องขอเป็นหัวหน้าชมรม</h3>
  <table class="table">
    <thead><tr><th>ชมรม</th><th>ชื่อ</th><th>รหัส</th><th>จัดการ</th></tr></thead>
    <tbody>
      @forelse($pendingLeaders as $m)
      <tr>
        <td>{{ $m->club->name }}</td><td>{{ $m->account->std_name }}</td><td>{{ $m->student_id }}</td>
        <td>
          <form action="{{ route('admin.leader.approve',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn-ok">อนุมัติ</button></form>
          <form action="{{ route('admin.leader.reject',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn-no">ไม่อนุมัติ</button></form>
        </td>
      </tr>
      @empty
      <tr><td colspan="4">ไม่มีคำร้อง</td></tr>
      @endforelse
    </tbody>
  </table>

  <h3 class="mt-5">คำขอลาออกจากหัวหน้าชมรม</h3>
  <table class="table">
    <thead><tr><th>ชมรม</th><th>ชื่อ</th><th>รหัส</th><th>จัดการ</th></tr></thead>
    <tbody>
      @forelse($pendingResign as $m)
      <tr>
        <td>{{ $m->club->name }}</td><td>{{ $m->account->std_name }}</td><td>{{ $m->student_id }}</td>
        <td>
          <form action="{{ route('admin.resign.approve',$m->id) }}" method="POST">@csrf<button class="btn-ok">อนุมัติลาออก</button></form>
        </td>
      </tr>
      @empty
      <tr><td colspan="4">ไม่มีคำขอลาออก</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
</body>
</html>
