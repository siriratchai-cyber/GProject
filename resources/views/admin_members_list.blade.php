<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>จัดการสมาชิกชมรม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-4">
    <h3>สมาชิกของ {{ $club->name }}</h3>

    <table class="table table-bordered mt-3">
      <thead>
        <tr>
          <th>ชื่อ</th>
          <th>รหัสนักศึกษา</th>
          <th>ตำแหน่ง</th>
          <th>สถานะ</th>
          <th>การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        @foreach($club->members as $m)
        <tr>
          <td>{{ $m->name }}</td>
          <td>{{ $m->student_id }}</td>
          <td>{{ $m->role }}</td>
          <td>{{ $m->status }}</td>
          <td>
            <a href="{{ route('admin.member.edit', ['club_id' => $club->id, 'member_id' => $m->id]) }}"
               class="btn btn-sm btn-primary">แก้ไข</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
</html>
