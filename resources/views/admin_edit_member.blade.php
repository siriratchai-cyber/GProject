@extends('layouts.headadmin')
@section('title', 'แก้ไขสมาชิก')

@section('username')
  {{ $user->std_id }}
@endsection

@section('body')
  <style>
    body.form-page {
      background-color: #cfe2f3;
      font-family: "Arial", sans-serif;
    }

    .form-card {
      background: #fbf5ef;
      border-radius: 22px;
      width: min(1100px, 92%);
      margin: 30px auto 60px;
      padding: 30px 35px 40px;
    }

    .btn-back {
      background: #5E5F68;
      color: white;
      border-radius: 20px;
      padding: 6px 18px;
      text-decoration: none;
      font-weight: 600;
      display: inline-block;
    }

    .form-title {
      margin: -45px 0 30px 0;
      font-size: 1.5rem;
      font-weight: 800;
      letter-spacing: .2px;
      text-align: center;
      color: #2d3e50;

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
      border: 1px solid #b8b8b8;
      border-radius: 12px;
      background: #fff;
      padding: 8px 12px;
      box-shadow: none;
    }

    .btn-save {
      background: #ffffff;
      border: 1px solid #bdbdbd;
      border-radius: 10px;
      font-weight: 800;
      padding: 8px 14px;
      color: #222;
    }
  </style>

  <div class="form-card form-page">

    <a class="btn-back mb-3" href="{{ route('admin.members.edit', $club->id) }}">⬅ กลับ</a>

    <h4 class="form-title">แก้ไขข้อมูลสมาชิกใน {{ $club->name }}</h4>

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        <ul class="mb-0">
          @foreach($errors->all() as $e)
            <li>{{ $e }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('admin.members.update', [$club->id, $member->id]) }}">
      @csrf
      @method('PUT')

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">ชื่อ-นามสกุล</label>
          <input type="text" name="std_name" class="form-control"
            value="{{ old('std_name', optional($account)->std_name) }}">
        </div>

        <div class="form-group">
          <label class="form-label">รหัสนักศึกษา</label>
          <input type="text" name="std_id" class="form-control"
            value="{{ old('std_id', optional($account)->std_id) }}">
        </div>

        <div class="form-group">
          <label class="form-label">อีเมล</label>
          <input type="email" name="email" class="form-control"
            value="{{ old('email', optional($account)->email) }}">
        </div>

        <div class="form-group">
          <label class="form-label">รหัสผ่าน</label>
          <input type="text" name="password" class="form-control"
            value="{{ old('password', optional($account)->password) }}">
        </div>

        <div class="form-group">
          <label class="form-label">ชั้นปี</label>
          <input type="number" name="year" class="form-control"
            value="{{ old('year', optional($account)->year) }}">
        </div>

        <div class="form-group">
          <label class="form-label">สาขา</label>
          <select name="major" class="form-select">
            <option value="">-- เลือก --</option>
            @foreach(['CY', 'GIS', 'CS', 'IT'] as $mem)
              <option value="{{ $mem }}" @selected(old('major', $account->major ?? '') === $mem)>
                {{ $mem }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <input type="hidden" name="role" value="{{ $member->role }}">
      <input type="hidden" name="status" value="{{ $member->status }}">

      <div class="mt-4 text-center">
        <button class="btn-save" type="submit">บันทึกการแก้ไข</button>
      </div>
    </form>
  </div>
@endsection
