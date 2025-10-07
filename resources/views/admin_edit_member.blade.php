<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <title>{{ isset($member) ? 'แก้ไขสมาชิก' : 'เพิ่มสมาชิกใหม่' }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
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
  </style>
</head>

<body class="form-page">

  <header class="app-header">
    <div class="username-box">username</div>
    <div class="club-title">CP club</div>
    <div class="nav-links">
      <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      <a href="{{ route('logout') }}">Logout</a>
    </div>
  </header>

  <div class="back-wrap">
    <a class="back-btn" href="{{ route('admin.members.edit', $club->id) }}">←</a>

  </div>

  <div class="form-card">
    <h4 class="form-title">
      {{ isset($member) ? 'แก้ไขสมาชิก' : 'เพิ่มสมาชิกใหม่' }} ใน {{ $club->name }}
    </h4>

    @if($errors->any())
      <div class="alert alert-danger mb-3">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>
        @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ isset($member)
  ? route('admin.members.update', [$club->id, $member->id])
  : route('admin.members.store', $club->id) }}">
      @csrf
      @if(isset($member)) @method('PUT') @endif

      <div class="form-grid">
        <div class="form-group">
          <label class="form-label">ชื่อ-นามสกุล</label>
          <input type="text" name="std_name" class="form-control"
            value="{{ old('std_name', optional($account)->std_name) }}">
        </div>

        <div class="form-group">
          <label class="form-label">รหัสนักศึกษา</label>
          <input type="text" name="std_id" class="form-control" value="{{ old('std_id', optional($account)->std_id) }}">
        </div>

        <div class="form-group">
          <label class="form-label">อีเมล</label>
          <input type="email" name="email" class="form-control" value="{{ old('email', optional($account)->email) }}">
        </div>

       <div class="form-group">
  <label class="form-label">รหัสผ่าน</label>
  <input type="text" name="password" class="form-control"
         value="{{ old('password', optional($account)->password) }}">
</div>


        <div class="form-group">
          <label class="form-label">ชั้นปี</label>
          <input type="number" name="year" class="form-control" value="{{ old('year', optional($account)->year) }}">
        </div>

        <div class="form-group">
          <label class="form-label">สาขา</label>
          <select name="major" class="form-select">
            <option value="">-- เลือก --</option>
            @foreach(['CY', 'GIS', 'CS', 'IT'] as $mem)
              <option value="{{ $mem }}" @selected(old('major', $account->major ?? '') === $mem)>{{ $mem }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <input type="hidden" name="role" value="{{ $member->role ?? 'สมาชิก' }}">
<input type="hidden" name="status" value="{{ $member->status ?? 'approved' }}">


      <div class="mt-4">
        <button class="btn-save" type="submit">{{ isset($member) ? 'บันทึกการแก้ไข' : 'เพิ่มสมาชิก' }}</button>
      </div>
    </form>
  </div>

</body>

</html>