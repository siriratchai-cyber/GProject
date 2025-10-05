<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขสมาชิก</title>
  <style>
    body { font-family: Arial, sans-serif; background:#d9e7f3; margin:0; }
    header { background:#2d3e50; color:white; padding:10px 30px; display:flex; justify-content:space-between; }
    .form-box { background:#f9f6f2; margin:30px auto; padding:20px; border-radius:20px; width:500px; }
    label { display:block; margin-top:15px; font-weight:bold; }
    input, select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:8px; }
    button { margin-top:20px; padding:10px 20px; background:#5E5F68; color:white; border:none; border-radius:12px; cursor:pointer; }
  </style>
</head>
<body>
<header>
  <div>CP club</div>
  <div>
    <a href="{{ route('admin.dashboard') }}" style="color:white; margin-right:20px;">Dashboard</a>
    <a href="{{ route('logout') }}" style="color:white;">Logout</a>
  </div>
</header>

<div class="form-box">
  <h2>แก้ไขข้อมูลสมาชิก</h2>
  <form action="{{ route('admin.members.update',$member->id) }}" method="POST">
    @csrf

    <label>ชื่อ - นามสกุล</label>
    <input type="text" name="name" value="{{ $member->name ?? '-' }}" readonly>


    <label>รหัสนักศึกษา</label>
    <input type="text" value="{{ $member->student_id }}" disabled>

    <label>สถานะ (role)</label>
    <select name="role">
      <option value="สมาชิก" {{ $member->role=='สมาชิก'?'selected':'' }}>สมาชิก</option>
      <option value="หัวหน้าชมรม" {{ $member->role=='หัวหน้าชมรม'?'selected':'' }}>หัวหน้าชมรม</option>
    </select>

    <label>สถานะการอนุมัติ</label>
    <select name="status">
      <option value="approved" {{ $member->status=='approved'?'selected':'' }}>approved</option>
      <option value="pending" {{ $member->status=='pending'?'selected':'' }}>pending</option>
      <option value="rejected" {{ $member->status=='rejected'?'selected':'' }}>rejected</option>
    </select>

    <button type="submit">บันทึก</button>
  </form>
</div>
</body>
</html>
