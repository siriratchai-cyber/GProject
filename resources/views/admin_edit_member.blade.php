<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขข้อมูลสมาชิก</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
<<<<<<< HEAD
    /* ===== โทนรวม & ฟอนต์ ===== */
    body.form-page {
      background-color: #cfe2f3;
      font-family: "Arial", sans-serif;
      margin: 0;
    }

    .app-header {
      background: #2d3e50;
      color: #fff;
      padding: 12px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      position: relative;
    }

    .app-header .username-box {
      border: 2px solid rgba(255, 255, 255, .6);
      border-radius: 8px;
      padding: 6px 12px;
      font-weight: 700;
      background: rgba(255, 255, 255, .06);
    }

    .app-header .club-title {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      font-weight: 800;
      font-size: 1.9rem;
      letter-spacing: .5px;
    }

    .app-header .nav-links a {
      color: #fff;
      text-decoration: none;
      font-weight: 700;
      margin-left: 20px;
    }

    .back-wrap {
      width: min(1100px, 92%);
      margin: 18px auto 0;
      display: flex;
      align-items: center;
    }

    .back-btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 44px;
      height: 44px;
      border: 2px solid #8ea5b8;
      border-radius: 50%;
      background: #e9f0f6;
      color: #2d3e50;
      text-decoration: none;
      font-size: 20px;
      font-weight: 800;
      box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
    }

    .form-card {
      background: #fbf5ef;
      border: 1px solid #b9b9b9;
      border-radius: 22px;
      width: min(1100px, 92%);
      margin: 16px auto 60px;
      padding: 26px 30px 32px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
    }

    .form-title {
      margin: 0 0 18px 0;
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: .2px;
    }

    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 18px 24px;
    }

    .form-group label {
      font-weight: 800;
      margin-bottom: 6px;
    }

    .form-control,
    .form-select {
      border: 1.5px solid #b8b8b8 !important;
      border-radius: 12px !important;
      background: #fff !important;
      padding: 8px 12px !important;
      box-shadow: none !important;
    }

    .btn-save {
      background: #ffffff;
      border: 1px solid #bdbdbd;
      border-radius: 10px;
      font-weight: 800;
      padding: 8px 14px;
      color: #222;
      box-shadow: 0 2px 0 rgba(0, 0, 0, .04);
    }

    .btn-back {
      background: #f1f1f1;
      border: 1px solid #cfcfcf;
      border-radius: 10px;
      font-weight: 800;
      padding: 8px 14px;
      color: #222;
      margin-left: 8px;
      box-shadow: 0 2px 0 rgba(0, 0, 0, .04);
      text-decoration: none;
      display: inline-block;
    }
=======
    body{background:#d9e7f3;font-family:'Sarabun',sans-serif;}
    .container{background:#f9f6f2;border-radius:15px;padding:30px;margin-top:30px;width:600px;}
    .btn-save{background:#5E5F68;color:white;border:none;border-radius:10px;padding:8px 18px;}
>>>>>>> parent of cc8f0e0 (Merge branch 'feature-activity-update' into updateLeader)
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
