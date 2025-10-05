<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>Admin Requests - CP club</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; background:#d9e7f3; }
    header {
      background:#2d3e50; color:white;
      display:flex; justify-content:space-between; align-items:center;
      padding:10px 30px;
      position: relative;
    }
    .username-box {
      background:#1a3552;
      padding:5px 15px;
      border-radius:5px;
      font-weight:bold;
    }
    .logo {
      position: absolute;
      left:50%;
      transform: translateX(-50%);
      font-size:28px;
      font-weight:bold;
      font-family:"Georgia", cursive;
    }
    .nav { display:flex; gap:20px; }
    .nav a { color:white; text-decoration:none; font-weight:bold; }

    .section {
      background:#f9f6f2;
      margin:20px 30px;
      padding:20px;
      border-radius:20px;
    }
    table {
      width:100%;
      border-collapse:collapse;
      background:#fff;
      border-radius:10px;
      overflow:hidden;
      margin-top:10px;
    }
    th,td { padding:12px 16px; border-bottom:1px solid #eee; }
    th { background:#5E5F68; color:#fff; text-align:left; }
    .btn { border:none; border-radius:16px; padding:8px 16px; cursor:pointer; }
    .ok { background:#A9CF88; }
    .no { background:#F69191; }
    .flash-success {
      margin:20px; padding:10px 20px;
      background:#A9CF88; color:#000;
      border-radius:10px; font-weight:bold;
    }
    .flash-error {
      margin:20px; padding:10px 20px;
      background:#F69191; color:#000;
      border-radius:10px; font-weight:bold;
    }
  </style>
</head>
<body>
<header>
  <div class="username-box">{{ session('std_id') }}</div> {{-- ✅ แสดงรหัสนักศึกษาแอดมิน --}}
  <div class="logo">CP club</div>
  <div class="nav">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('logout') }}">Logout</a>
  </div>
</header>

{{-- Flash Messages --}}
@if(session('success'))
  <div class="flash-success">✅ {{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="flash-error">❌ {{ $errors->first() }}</div>
@endif

<div class="section">
  <h3>คำร้องขอสร้างชมรม</h3>
  <table>
    <thead><tr><th>ชื่อชมรม</th><th>รายละเอียด</th><th>จัดการ</th></tr></thead>
    <tbody>
    @forelse($pendingClubs as $c)
      <tr>
        <td>{{ $c->name }}</td>
        <td>{{ $c->description }}</td>
        <td>
          <form action="{{ route('admin.clubs.approve',$c->id) }}" method="POST" style="display:inline">@csrf<button class="btn ok">อนุมัติ</button></form>
          <form action="{{ route('admin.clubs.reject',$c->id) }}" method="POST" style="display:inline">@csrf<button class="btn no">ปฏิเสธ</button></form>
        </td>
      </tr>
    @empty
      <tr><td colspan="3">- ไม่มีคำร้อง -</td></tr>
    @endforelse
    </tbody>
  </table>
</div>

<div class="section">
  <h3>คำร้องขอเป็นหัวหน้าชมรม</h3>
  <table>
    <thead><tr><th>ชมรม</th><th>ชื่อ - นามสกุล</th><th>รหัสนักศึกษา</th><th>จัดการ</th></tr></thead>
    <tbody>
    @forelse($pendingLeaders as $m)
      <tr>
        <td>{{ $m->club->name }}</td>
        <td>{{ $m->account->std_name }}</td>
        <td>{{ $m->student_id }}</td>
        <td>
          <form action="{{ route('admin.leader.approve',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn ok">อนุมัติ</button></form>
          <form action="{{ route('admin.leader.reject',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn no">ปฏิเสธ</button></form>
        </td>
      </tr>
    @empty
      <tr><td colspan="4">- ไม่มีคำร้อง -</td></tr>
    @endforelse
    </tbody>
  </table>
</div>

<div class="section">
  <h3>คำขอลาออกจากการเป็นหัวหน้าชมรม</h3>
  <table>
    <thead><tr><th>ชมรม</th><th>หัวหน้าปัจจุบัน</th><th>รหัสนักศึกษา</th><th>จัดการ</th></tr></thead>
    <tbody>
    @forelse($pendingResign as $m)
      <tr>
        <td>{{ $m->club->name }}</td>
        <td>{{ $m->account->std_name }}</td>
        <td>{{ $m->student_id }}</td>
        <td>
          <form action="{{ route('admin.resign.approve',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn ok">อนุมัติลาออก</button></form>
        </td>
      </tr>
    @empty
      <tr><td colspan="4">- ไม่มีคำร้อง -</td></tr>
    @endforelse
    </tbody>
  </table>
</div>

</body>
</html>
