@extends('layouts.headclub')
@section('title', 'Request and Members')
@section('club_name', $leaderclub->name)
@section('username', $user->std_id)

@section('style')
<style>
    @import url("{{ asset('css/request.css') }}");
</style>
@endsection

@section('body')
    <main>
        <div>
            @if($from == "homepage")
            <a href="{{ route('backtoHome', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
            @elseif($from == "club")
            <a href="{{ route('clubHomepage', ['id_club' => $leaderclub->id ]) }}" class="back">⬅ กลับไป</a>
            @endif
        </div>
        <div>
            <p class="text">คำร้องขอสมัครเข้าชมรม</p>
            <table class="showtable">
                <thead>
                    <th>ชื่อ</th><th>รหัสนักศึกษา</th><th>สาขา</th><th>ชั้นปี</th><th></th>
                </thead>
                <tbody>
                    @if($member_pending->isEmpty())
                    <tr>
                        <td colspan="5"><span class="request">ขณะนี้ยังไม่มีคำร้องเข้ามา</span></td>
                    </tr>
                    @else
                        @foreach($member_pending as $member)      
                        <tr>
                            <td>{{$member->name}}</td>
                            <td>{{$member->student_id}}</td>
                            <td>{{ $member->account->major}}</td>
                            <td>{{ $member->account->year}}</td>

                            <td>
                                <div class="btn-a_r">
                                <form action="{{ route('approved',['from' => $from,'id_club' => $member->club_id, 'id_member' => $member->id]) }}" method="post">
                                    @csrf
                                    <input type="submit" value="อนุมัติ" class="btn-approve">
                                </form>
                                <button type="button" class="btn-reject" data-bs-toggle="modal" data-bs-target="#deleteActivityModal{{ $member->id }}">
                                    ไม่อนุมัติ
                                </button>
                                <div class="modal fade" id="deleteActivityModal{{ $member->id }}" tabindex="-1" 
                                    aria-labelledby="deleteActivityLabel{{ $member->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 20px;">
                                    <div class="modal-body text-center">
                                        <p class="fs-5 fw-bold">ต้องการดำเนินการต่อหรือไม่</p>
                                        <div class="d-flex justify-content-center gap-3 mt-3">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                                        <form action="{{ route('rejected',['from' => $from, 'id_club' => $member->club_id, 'id_member' => $member->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-dark">ตกลง</button>
                                        </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div> 
                                </div>    
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="showmembers">
            <p class="text">รายชื่อนักศึกษาในชมรม</p>
            <table class="showtable">
                <thead>
                    <th>ชื่อ</th><th>รหัสนักศึกษา</th><th>สาขา</th><th>ชั้นปี</th><th>ตำแหน่ง</th>
                </thead>
                <tbody>
                    @foreach($member_approved as $member)
                    <tr>
                        <td>{{$member->name}}</td>
                        <td>{{$member->student_id}}</td>
                        <td>{{ optional($member->account)->major }}</td>
                        <td>{{ optional($member->account)->year }}</td>

                        <td>{{$member->role}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
@endsection