@extends('layouts.headadmin')
@section('title', 'แก้ไขข้อมูลชมรม')

@section('username')
  {{ $user->std_id }}
@endsection

@section('body')
  <style>
    body.page-edit {
      background: #d9e7f3;
      font-family: "Sarabun", sans-serif;
      margin: 0;
    }

    .edit-container {
      max-width: 1000px;
      margin: 20px auto;
      background: #f9f6f2;
      border-radius: 20px;
      padding: 40px 45px;
    }

    h3 {
      font-weight: 800;
      color: #2d3e50;
      text-align: center;
      margin-bottom: 30px;
      margin-top: -55px;
    }

    .form-section {
      display: flex;
      gap: 40px;
      flex-wrap: wrap;
      align-items: flex-start;
      justify-content: center;
    }

    .image-box {
      flex: 1 1 300px;
      text-align: center;
    }

    .image-box img {
      width: 100%;
      max-width: 300px;
      height: 220px;
      object-fit: cover;
      border-radius: 15px;
      border: 1.5px solid #ccc;
      margin-bottom: 15px;
    }

    .form-fields {
      flex: 1 1 400px;
    }

    label {
      font-weight: 600;
      color: #2b2b2b;
      margin-top: 10px;
    }

    .form-control {
      border-radius: 12px;
      border: 1.5px solid #ccc;
    }

    .btn-save {
      background: #2d3e50;
      color: white;
      border: none;
      border-radius: 12px;
      padding: 10px 26px;
      font-weight: 700;
      margin-top: 25px;
    }

    .btn-back {
      background: #5e5f68;
      color: white;
      border-radius: 25px;
      padding: 7px 18px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 20px;
    }

    .btn-member {
      background: #a9cf88;
      color: black;
      border-radius: 12px;
      padding: 8px 18px;
      text-decoration: none;
      font-weight: 700;
      display: inline-block;
      position: absolute;
      bottom: 25px;
      left: 150px;
    }
  </style>

  <div class="edit-container page-edit">
    <a href="{{ route('admin.dashboard') }}" class="btn-back">⬅ กลับ</a>
    <h3>แก้ไขข้อมูล{{ $club->name }}</h3>

    <form method="POST" action="{{ route('admin.clubs.update', $club->id) }}" enctype="multipart/form-data">
      @csrf

      <div class="form-section">
        <div class="image-box">
          @if($club->image)
            <img id="preview" src="{{ asset('storage/' . $club->image) }}" alt="รูปชมรม">
          @else
            <img id="preview" src="https://via.placeholder.com/300x200?text=Preview" alt="Preview">
          @endif
          <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(event)">
        </div>

        <div class="form-fields">
          <div class="mb-3">
            <label>ชื่อชมรม</label>
            <input class="form-control" name="name" value="{{ $club->name }}" required>
          </div>

          <div class="mb-3">
            <label>รายละเอียด</label>
            <textarea class="form-control" name="description" rows="4" required>{{ $club->description }}</textarea>
          </div>
        </div>
      </div>

      <div class="text-center">
        <button class="btn-save" type="submit">บันทึกการแก้ไข</button>
      </div>
    </form>
    <div class="text-center">
      <a href="{{ route('admin.members.edit', $club->id) }}" class="btn-member">แก้ไขสมาชิกในชมรม</a>
    </div>
  </div>
@endsection