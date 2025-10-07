<<<<<<< Updated upstream
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>แก้ไขข้อมูลชมรม</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
=======
@extends('layouts.headadmin')
@section('title', 'แก้ไขข้อมูลชมรม')

@section('username')
  {{ $user->std_id }}
@endsection

@section('body')
>>>>>>> Stashed changes
  <style>
    body {
      background: #d9e7f3;
<<<<<<< Updated upstream
      font-family: 'Arial', sans-serif;
    }
    .container {
      background: #f9f6f2;
      border-radius: 15px;
      padding: 30px;
      margin-top: 30px;
    }
    .btn-save {
      background: #2d3e50;
=======
      font-family: "Arial", sans-serif;
    }

    .club-edit-card {
      max-width: 1000px;
      margin: 10px auto;
      background: #f9f6f2;
      border-radius: 20px;
      padding: 40px 45px;
    }

    .club-edit-title {
      font-weight: 800;
      color: #2d3e50;
      margin-bottom: 30px;
      margin-top: -30px;
      text-align: center;
    }

    .club-edit-form {
      display: flex;
      flex-wrap: wrap;
      align-items: flex-start;
      gap: 40px;
      justify-content: center;
    }

    .club-image-section {
      flex: 0 0 320px;
      text-align: center;
    }


    .club-form-fields {
      flex: 1 1 500px;
    }

    label {
      font-weight: 600;
      color: #2b2b2b;
      margin-top: 10px;
    }

    .btn-save-club {
      background: #28a745;
>>>>>>> Stashed changes
      color: white;
      border-radius: 10px;
      padding: 6px 16px;
      border: none;
<<<<<<< Updated upstream
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
=======
      border-radius: 15px;
      padding: 10px 25px;
      font-weight: 700;
      margin-top: 30px;

    }

    .btn-back-club {
      background: #5E5F68;
      color: white;
      border-radius: 25px;
      padding: 7px 18px;
      text-decoration: none;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .btn-member-edit {
      position: absolute;
      left: 115px;
      margin-top: 55px;
      background: #A9CF88;
      color: #000;
      border-radius: 12px;
      padding: 8px 18px;
      text-decoration: none;
      font-weight: 700;
>>>>>>> Stashed changes
    }
  </style>
</head>
<body>
  <div class="container">
    <a href="{{ route('admin.dashboard') }}" class="btn-back mb-3">⬅ กลับ</a>
    <h3>แก้ไขชมรม: {{ $club->name }}</h3>

<<<<<<< Updated upstream
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
=======
  <div class="club-edit-card page-edit">
    <a href="{{ route('admin.dashboard') }}" class="btn-back-club">⬅ กลับ</a>
    <h3 class="club-edit-title">แก้ไขข้อมูล{{ $club->name }}</h3>

    <form method="POST" action="{{ route('admin.clubs.update', $club->id) }}" enctype="multipart/form-data"
      class="club-edit-form">
      @csrf
      <div class="club-image-section">
        @if($club->image)
          <img src="{{ asset('storage/' . $club->image) }}" class="club-image-preview">
        @endif
        <input type="file" name="image" class="form-control mt-2">
      </div>

      <div class="club-form-fields">
        <div class="mb-3">
          <label>ชื่อชมรม</label>
          <input class="form-control" name="name" value="{{ $club->name }}" required>
        </div>

        <div>
          <label>รายละเอียด</label>
          <textarea class="form-control" name="description" rows="4" required>{{ $club->description }}</textarea>
        </div>

        <div class="text-center">
          <button class="btn-save-club" type="submit">บันทึกการแก้ไข</button>
        </div>
      </div>
    </form>
    <div class="text-center">
      <a href="{{ route('admin.members.edit', $club->id) }}" class="btn-member-edit">แก้ไขสมาชิกในชมรม</a>
    </div>
  </div>
@endsection
>>>>>>> Stashed changes
