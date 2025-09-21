@extends('layouts.headclub')
@section('title', 'Activity')

@section('style')
<style>
    * {
    box-sizing: border-box;
    }
    main {
        display: flex;
        flex-direction: column;
        margin: 3% 10%; 
        gap: 20px;
    }
    div .back{
        background: #d9e7f3;
        border-radius: 30px;
        border: 1px solid black;
        width: 10%;
        height: 10%;
        padding: 5px 20px;
        margin-left: -8%;
        display: flex; 
        align-items: center;
        justify-content: center;
    }
    .back:hover{
        background-color: #5E5F68;
        color: white;
    }
    a{
        color: black;
        text-decoration: none;
    }

    .showtable{
        border-collapse: collapse;
        font-size: 16px;
        min-width: 400px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0,0.15);
        background-color: #f9f6f2;
        margin-bottom: 30px;
    }
    .showtable thead tr{
        background-color: #5E5F68;
        color: white;
        text-align: left;
        font-weight: bold;
    }
    .showtable th, .showtable td{
        padding: 10px 55px;
    }
    .showtable tr{
        border-bottom: 1px solid #5E5F68;
    }
    .text{
        font-size: 20px;
        margin:  10px 5px 0px 0px;
    }
    .btn-approve{
        border-style: none;
        background-color: #A9CF88;
        border-radius: 20px;
        padding: 10px 40px;
        cursor: pointer;
        font-size: 14px;
    }
    .btn-approve:hover{
        background-color: green;
        color: white;
    }
    .btn-reject{
        border-style: none;
        background-color: #F69191;
        font-size: 14px;
        cursor: pointer;
        padding: 10px 40px;
        border-radius: 20px;
    }
    .btn-reject:hover{
        background-color: red;
        color: white;
    }
    p{
        padding-bottom: 20px;
    }
    .showmembers{
        display: flex;
        flex-direction: column;
    }
</style>
@endsection

@section('body')
    <main>
        <div>
            <a href="#" class="back">⬅ กลับไป</a>
        </div>
        <div>
            <p class="text">คำร้องขอสมัครเข้าชมรม</p>
            <table class="showtable">
                <thead>
                    <th>ชื่อ</th><th>รหัสนักศึกษา</th><th>สาขา</th><th>ชั้นปี</th><th class="empty"></th><th class="empty"></th>
                </thead>
                <tbody>
                    <tr>
                        <td>นายกรกกฏ กรรกร</td>
                        <td>683066666-6</td>
                        <td>CS</td>
                        <td>1</td>
                        <td><form action="">
                            <input type="submit" value="อนุมัติ" class="btn-approve">
                        </form></td>
                        <td><form action="">
                            <input type="submit" value="ไม่อนุมัติ" class="btn-reject">
                        </form></td>
                    </tr>
                    <tr>
                        <td>นางสาวชยนะ ชนะชญา</td>
                        <td>663077777-8</td>
                        <td>GIS</td>
                        <td>3</td>
                        <td><form action="">
                            <input type="submit" value="อนุมัติ" class="btn-approve">
                        </form></td>
                        <td><form action="">
                            <input type="submit" value="ไม่อนุมัติ" class="btn-reject">
                        </form></td>
                    </tr>
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
                    <tr>
                        <td>นายกรกกฏ กรรกร</td>
                        <td>683066666-6</td>
                        <td>CS</td>
                        <td>1</td>
                        <td>หัวหน้า</td>
                    </tr>
                    <tr>
                        <td>นางสาวชยนะ ชนะชญา</td>
                        <td>663077777-8</td>
                        <td>GIS</td>
                        <td>3</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
@endsection