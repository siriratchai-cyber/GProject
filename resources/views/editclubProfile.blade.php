@extends('layouts.headclub')
@section('title', 'Edit Club Profile')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    main {
        width: 100%;
        min-height: 100vh;
        display: flex;
        justify-content: center; 
        align-items: center;     
    }

    .back {
        position: absolute;
        left: 5%;
        top: 12%;
        background: none;
        border: 1px solid #000;
        border-radius: 20px;
        padding: 6px 20px;
        font-size: 15px;
        color: black;
        text-decoration: none;
    }

    .back:hover {
        background-color: #5E5F68;
        color: white;
    }

    .box-showDetail {
        width: 100%;
        max-width: 800px;
        background: #f9f6f2;
        border-radius: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 40px 20px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .club-img {
        width: 300px;
        height: 200px;
        border-radius: 20px;
        margin-bottom: 15px;
    }

    .activityform {
        width: 100%;
        max-width: 600px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .activityform label {
        align-self: flex-start;
        font-weight: bold;
    }

    .activityform input,
    .activityform textarea {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 15px;
        background: white;
    }

    .activityform input {
        width: 100%;
        margin-bottom: 10px;
    }

    .btn-save {
        background-color: #5E5F68;
        color: white;
        border: none;
        border-radius: 25px;
        padding: 10px 25px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
        transition: 0.3s;
    }

    .btn-save:hover {
        background-color: #A9CF88;
        color: #303032;
    }

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
@endsection
