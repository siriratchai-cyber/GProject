<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขข้อมูลชมรม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #d9e7f3;
      font-family: 'Sarabun', sans-serif;
    }
    .container {
      background: #f9f6f2;
      border-radius: 15px;
      padding: 30px;
      margin-top: 30px;
    }
    .btn-save {
      background: #2d3e50;
      color: white;
      border-radius: 10px;
      padding: 6px 16px;
      border: none;
    }
    .btn-save:hover {
      background: #5E5F68;
    }
    .btn-back {
      background: #5E5F68;
      color: white;
      border-radius: 10px;
      padding: 6px 16px;
      text-decoration: none;
    }
    .btn-back:hover {
      background: #2d3e50;
    }
    .btn-member {
      background: #A9CF88;
      color: black;
      border-radius: 10px;
      padding: 6px 16px;
      text-decoration: none;
      font-weight: bold;
    }
    .btn-member:hover {
      background: #7fb565;
      color: white;
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="{{ route('admin.dashboard') }}" class="btn-back mb-3">⬅ กลับ</a>
    <h3>แก้ไขชมรม: {{ $club->name }}</h3>

    <form method="POST" action="{{ route('admin.clubs.update', $club->id) }}" enctype="multipart/form-data">
      @csrf
      <label>ชื่อชมรม</label>
      <input class="form-control" name="name" value="{{ $club->name }}" required>

      <label class="mt-3">รายละเอียด</label>
      <textarea class="form-control" name="description" required>{{ $club->description }}</textarea>

      <label class="mt-3">รูปภาพ</label>
      @if($club->image)
        <img src="{{ asset('storage/'.$club->image) }}" width="200" class="d-block mb-2">
      @endif
      <input type="file" name="image" class="form-control mb-3">

      <button class="btn-save" type="submit">💾 บันทึก</button>
    </form>

    <hr>

    <!-- ปุ่มแก้ไขสมาชิก -->
    <a href="{{ route('admin.members.edit', $club->id) }}" class="btn-member mt-3">👥 แก้ไขสมาชิกในชมรม</a>

  </div>
</body>
</html>
