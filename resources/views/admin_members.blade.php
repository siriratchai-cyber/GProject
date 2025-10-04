<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>จัดการสมาชิกชมรม</title>

  <style>

    body.page-members {
      background-color: #cfe2f3;
      font-family: "Sarabun", sans-serif;
      margin: 0;
    }

    .header {
      background: #2d3e50;
      color: white;
      padding: 12px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .username-box {
      border: 2px solid rgba(255, 255, 255, 0.6);
      border-radius: 8px;
      padding: 6px 12px;
      font-weight: 600;
      background: rgba(255, 255, 255, 0.08);
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav-btn {
      color: white;
      text-decoration: none;
      font-weight: 700;
    }

    .nav-btn:hover {
      text-decoration: underline;
    }

    /* ===== กล่องคอนเทนต์หลัก ===== */
    .content-wrapper {
      background: #fbf5ef;
      border: 1px solid #b9b9b9;
      border-radius: 22px;
      width: min(1100px, 92%);
      margin: 28px auto 60px auto;
      padding: 26px 30px 32px;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
    }

    .page-title {
      margin: 6px 0 20px;
      font-size: 1.6rem;
      font-weight: 800;
      letter-spacing: .2px;
    }

    /* ===== ตาราง ===== */
    .member-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: #ffffff;
      border: 1px solid #d0d0d0;
      border-radius: 12px;
      overflow: hidden;
    }

    .member-table thead {
      background: #eef3f8;
    }

    .member-table th {
      font-weight: 700;
      text-align: left;
      padding: 12px 14px;
      border-bottom: 1px solid #d9e1ea;
      font-size: 0.98rem;
    }

    .member-table td {
      padding: 11px 14px;
      border-bottom: 1px solid #eee;
      vertical-align: middle;
      font-size: 0.96rem;
    }

    .member-table tr:nth-child(odd) {
      background: #fcfcfc;
    }

    /* ===== ปุ่มในตาราง ===== */
    .member-actions {
      white-space: nowrap;
    }

    .btn-edit {
      display: inline-block;
      padding: 6px 10px;
      border-radius: 999px;
      background: #fff8c6;
      border: 1px solid #d7cfa4;
      font-weight: 700;
      text-decoration: none;
      color: #333;
      margin-right: 6px;
    }

    .btn-delete {
      padding: 6px 10px;
      border-radius: 999px;
      border: 0;
      font-weight: 700;
      background: #f79b9b;
      color: #fff;
      cursor: pointer;
    }

    .btn-delete:hover {
      opacity: .92;
    }

    .form-delete {
      display: inline;
    }

    /* ===== ปุ่มด้านล่าง ===== */
    .page-buttons {
      margin-top: 20px;
    }

    .btn {
      display: inline-block;
      padding: 8px 14px;
      border-radius: 10px;
      border: 1px solid #bdbdbd;
      background: #ffffff;
      margin-right: 10px;
      font-weight: 700;
      text-decoration: none;
      color: #222;
      box-shadow: 0 2px 0 rgba(0, 0, 0, 0.04);
    }

    .btn-add {
      background: #e7f6e7;
      border-color: #a6d2a6;
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
  </style>
</head>

<body class="page-members">

  <header class="header">
    <div class="username-box">username</div>
    <div class="club-title">CP club</div>
    <div class="nav-links">
      <a href="{{ route('admin.dashboard') }}" class="nav-btn">Dashboard</a>
      <a href="{{ route('logout') }}" class="nav-btn">Logout</a>
    </div>
  </header>

  <div class="back-wrap">
    <a class="back-btn" href="{{ route('admin.dashboard') }}">←</a>
  </div>
  <div class="content-wrapper">
    <h3 class="page-title">สมาชิกใน {{ $club->name }}</h3>

    <table class="member-table">
      <thead>
        <tr>
          <th>ชื่อ-นามสกุล</th>
          <th>รหัสนักศึกษา</th>
          <th>อีเมล</th>
          <th>รหัสผ่าน</th>
          <th>ชั้นปี</th>
          <th>สาขา</th>
          <th>ตำแหน่ง</th>
          <th>การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        @foreach($club->members as $mem)
          <tr>
            <td>{{ $mem->account->std_name ?? $mem->name }}</td>
            <td>{{ $mem->account->std_id ?? $mem->student_id }}</td>
            <td>{{ $mem->account->email ?? '-' }}</td>
            <td>{{ $mem->account?->password ?? '-' }}</td>
            <td>{{ $mem->account->year ?? '-' }}</td>
            <td>{{ $mem->account->major ?? '-' }}</td>
            <td>{{ $mem->role }}</td>
            <td class="member-actions">
              <a href="{{ route('admin.members.edit', [$club->id, $mem->id]) }}" class="btn-edit">แก้ไข</a>
              <form action="{{ route('admin.members.destroy', [$club->id, $mem->id]) }}" method="POST"
                class="form-delete">
                @csrf @method('DELETE')
                <button class="btn-delete" onclick="return confirm('ลบสมาชิกนี้หรือไม่?')">ลบ</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="page-buttons">
      <a href="{{ route('admin.members.create', $club->id) }}" class="btn btn-add">เพิ่มสมาชิก</a>
    </div>
  </div>

</body>

</html>