<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สร้างชมรมใหม่ - CP Club</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: "Sarabun", sans-serif; background: #d9e7f3; margin: 0; }
    header { background: #2d3e50; color: white; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center; }
    .logo { font-size: 28px; font-weight: bold; font-family: "Georgia", cursive; }
    .container { background: #f9f6f2; width: 60%; margin: 40px auto; padding: 30px; border-radius: 15px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
    .btn-submit { background: #5E5F68; color: white; border: none; border-radius: 10px; padding: 8px 18px; cursor: pointer; }
    .btn-submit:hover { background: #A9CF88; color: black; }
    .back-btn { text-decoration: none; background: #2d3e50; color: white; padding: 5px 15px; border-radius: 8px; }
    label { font-weight: bold; margin-top: 10px; }
  </style>
</head>
<body>

<header>
  <div class="logo">CP Club</div>
  <a href="{{ route('clubs.index') }}" class="back-btn">⬅ กลับ</a>
</header>

<div class="container">
  <h3 class="mb-4">สร้างชมรมใหม่</h3>

  <form action="{{ route('clubs.store') }}" method="POST">
    @csrf

    <label>ชื่อชมรม:</label>
    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>

    <label class="mt-3">คำอธิบาย:</label>
    <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>

    <label class="mt-3">สาขา:</label>
    <select name="major" class="form-select" required>
      <option value="">-- เลือกสาขา --</option>
      <option value="CS" {{ old('major')=='CS' ? 'selected' : '' }}>CS (Computer Science)</option>
      <option value="CY" {{ old('major')=='CY' ? 'selected' : '' }}>CY (Cybersecurity)</option>
      <option value="IT" {{ old('major')=='IT' ? 'selected' : '' }}>IT (Information Tech)</option>
      <option value="AI" {{ old('major')=='AI' ? 'selected' : '' }}>AI (Artificial Intelligence)</option>
      <option value="GIS" {{ old('major')=='GIS' ? 'selected' : '' }}>GIS (Geoinformatics)</option>
    </select>

    <button type="submit" class="btn-submit mt-4">บันทึก</button>
  </form>
</div>

@if(session('success'))
<script>
Swal.fire({
  icon: 'success',
  title: 'สำเร็จ!',
  text: "{{ session('success') }}",
  confirmButtonText: 'ตกลง'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
  icon: 'error',
  title: 'เกิดข้อผิดพลาด',
  html: `{!! nl2br(e(session('error'))) !!}`,
  confirmButtonText: 'ตกลง'
});
</script>
@endif

</body>
</html>
