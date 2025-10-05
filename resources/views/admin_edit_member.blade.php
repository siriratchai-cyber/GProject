<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขข้อมูลสมาชิก</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{background:#d9e7f3;font-family:'Sarabun',sans-serif;}
    .container{background:#f9f6f2;border-radius:15px;padding:30px;margin-top:30px;width:600px;}
    .btn-save{background:#5E5F68;color:white;border:none;border-radius:10px;padding:8px 18px;}
  </style>
</head>
<body>
  <div class="container">
    <h3>แก้ไขข้อมูลสมาชิก</h3>
    <form method="POST" action="{{ route('admin.members.update',[$club->id,$member->id]) }}">
      @csrf
      <label>ชื่อ</label>
      <input class="form-control" name="name" value="{{ $member->name }}">
      <label class="mt-3">รหัสนักศึกษา</label>
      <input class="form-control" value="{{ $member->student_id }}" readonly>
      <label class="mt-3">ตำแหน่ง</label>
      <select class="form-select" name="role">
        <option value="สมาชิก" {{ $member->role=='สมาชิก'?'selected':'' }}>สมาชิก</option>
        <option value="หัวหน้าชมรม" {{ $member->role=='หัวหน้าชมรม'?'selected':'' }}>หัวหน้าชมรม</option>
      </select>
      <label class="mt-3">สถานะ</label>
      <select class="form-select" name="status">
        <option value="approved" {{ $member->status=='approved'?'selected':'' }}>approved</option>
        <option value="pending" {{ $member->status=='pending'?'selected':'' }}>pending</option>
        <option value="rejected" {{ $member->status=='rejected'?'selected':'' }}>rejected</option>
      </select>
      <button class="btn-save mt-4" type="submit">บันทึก</button>
    </form>
  </div>
</body>
</html>
