@extends('layouts.headclub')
@section('title', 'Edit Club Profile')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    @import url("{{ asset('css/editProfile.css') }}");
</style>
@endsection

@section('body')
<main>
    <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>

    <div class="box-showDetail">
        <h4>แก้ไขโปรไฟล์ชมรม</h4><br>
        <img src="{{ asset('storage/'.$leaderclub->image) }}" alt="Club Image" class="club-img">
        
        <form action="{{ route('updateProfile', ['id_club' => $leaderclub->id ])}}" method="POST" enctype="multipart/form-data" class="activityform">
            @csrf
            <label>เลือกรูปโปรไฟล์:</label>
            <input type="file" name="image" class="form-control">

            <label>ชื่อชมรม:</label>
            <input type="text" name="name_club" required value="{{ $leaderclub->name }}">

            <label>รายละเอียดชมรม:</label>
            <textarea name="club_detail" rows="6">{{ $leaderclub->description }}</textarea>

            <button type="submit" class="btn-save">บันทึกข้อมูล</button>
        </form>
    </div>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const input = document.querySelector('input[name="image"]')
  const preview = document.querySelector('.club-img')

  input.addEventListener('change', (e) => {
    const file = e.target.files[0]
    if (file) {
      const reader = new FileReader()
      reader.onload = (event) => {
        preview.src = event.target.result
      };
      reader.readAsDataURL(file)
    }
  });
});
</script>
@endsection
