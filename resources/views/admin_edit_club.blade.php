<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขรายละเอียดชมรม - CP club</title>
  <style>
    body { font-family: Arial, sans-serif; margin:0; background:#d9e7f3; }
    header { background:#2d3e50; color:white; display:flex; justify-content:space-between; align-items:center; padding:10px 30px; }
    header .logo { font-size: 28px; font-weight: bold; }
    header .nav a { color:white; margin-left:20px; text-decoration:none; font-weight:bold; }
    .container { margin:30px auto; width:85%; background:#f9f6f2; padding:25px; border-radius:20px; }
    .form-group { margin-bottom:20px; }
    label { font-weight:bold; display:block; margin-bottom:6px; }
    input, textarea { width:100%; padding:10px; border:1px solid #aaa; border-radius:10px; }
    img { width:250px; border-radius:10px; margin-bottom:15px; display:block; }
    .btn { background:#2d3e50; color:white; padding:10px 20px; border:none; border-radius:10px; cursor:pointer; }
    .btn:hover { background:#444; }
    .btn-back { background:#5E5F68; color:white; padding:8px 14px; border-radius:15px; text-decoration:none; }
    table { width:100%; border-collapse:collapse; margin-top:30px; background:white; border-radius:10px; overflow:hidden; }
    th,td { padding:12px; border-bottom:1px solid #eee; text-align:left; }
    th { background:#5E5F68; color:white; }
    .btn-edit { background:#f7e58d; padding:6px 12px; border:none; border-radius:10px; cursor:pointer; }
  </style>
</head>
<body>
<header>
  <div class="logo">CP club</div>
  <div class="nav">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.requests') }}">คำร้องขอ</a>
    <a href="{{ route('logout') }}">Logout</a>
  </div>
</header>

<div style="margin:20px 30px;">
  <a href="{{ route('admin.dashboard') }}" class="btn-back">← กลับ</a>
</div>

<div class="container">
  <h2>แก้ไขรายละเอียดชมรม</h2>

  <form action="{{ route('admin.clubs.update', $club->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>รูปภาพปัจจุบัน</label>
      @if($club->image)
        <img src="{{ asset('storage/'.$club->image) }}" alt="รูปภาพชมรม">
      @endif
      <input type="file" name="image">
    </div>

    <div class="form-group">
      <label>ชื่อชมรม</label>
      <input type="text" name="name" value="{{ $club->name }}">
    </div>

    <div class="form-group">
      <label>รายละเอียดชมรม</label>
      <textarea name="description" rows="5">{{ $club->description }}</textarea>
    </div>

    <button class="btn" type="submit">บันทึกการแก้ไข</button>
  </form>

  <h2 style="margin-top:40px;">สมาชิกในชมรม</h2>
  <table>
    <thead>
      <tr>
        <th>ชื่อ - นามสกุล</th>
        <th>รหัสนักศึกษา</th>
        <th>สถานะ</th>
        <th>จัดการ</th>
      </tr>
    </thead>
 <tbody>
  @forelse($club->members as $m)
    <tr>
      <td>{{ $m->name ?? '-' }}</td>   {{-- ✅ ดึงจาก members.name --}}
      <td>{{ $m->student_id ?? '-' }}</td>
      <td>{{ $m->role ?? '-' }}</td>
      <td>
        <form action="{{ route('admin.members.edit', $m->id) }}" method="GET" style="display:inline">
          <button type="submit" class="btn-edit">แก้ไข</button>
        </form>
      </td>
    </tr>
  @empty
    <tr><td colspan="4">- ไม่มีสมาชิก -</td></tr>
  @endforelse
</tbody>


  </table>
</div>
</body>
</html>
