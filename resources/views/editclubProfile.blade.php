@extends('layouts.headclub')
@section('title', 'Edit Club Profile')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    main {
        display: flex;
        flex-direction: column;
        margin: 3% 10%; 
        gap: 20px;
    }
    .btn-save {
        background-color: #5E5F68;
        color: white;
        border: none;
        border-radius: 20px;
        padding: 8px 15px;
        cursor: pointer;
        font-size: 14px;
        width: fit-content;
        margin-left: 65%;
        transition: 0.3s;
    }
    .btn-save:hover{
        color: #303032ff;
        background-color: #A9CF88;
    }
    .back {
        background: #d9e7f3;
        border-radius: 30px;
        border: 1px solid black;
        width: 10%;
        padding: 5px 20px;
        text-align: center;
        text-decoration: none;
        color: black;
        transition: 0.3s;
    }
    .back:hover{
        background-color: #5E5F68;
        color: white;
    }
    .box-showDetail{
        width: 95%;
        background: #f9f6f2;
        border-radius: 30px;
        display: flex;
        padding: 20px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .activityform{
        width: 50%;
        min-width: 350px;
        margin-top: 30px;
    }
    .activityform form {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .activityform input, .activityform textarea{
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
</style>
@endsection

@section('body')
    <main>
        <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
        <div class="box-showDetail">
            <img src="{{ $leaderclub->image ? asset('storage/'.$leaderclub->image) : asset('default.jpg') }}" 
                 alt="Club Image" style="width:300px;height:200px;border-radius:20px;object-fit:cover;">
            <div class="activityform">
               <form action="{{ route('updateProfile', ['id_club' => $leaderclub->id, 'from' => 'homepage']) }}" method="POST">
    @csrf
    <label>ชื่อชมรม:</label>
    <input type="text" name="name" value="{{ $leaderclub->name }}" required>

    <label>คำอธิบาย:</label>
    <textarea name="description" required>{{ $leaderclub->description }}</textarea>

    <button type="submit" class="btn btn-success">บันทึกการแก้ไข</button>
</form>

            </div>
        </div>    

        @if(session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'สำเร็จ!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ตกลง'
        });
        </script>
        @endif
h
    </tbody>
</table>

    </main>
@endsection
