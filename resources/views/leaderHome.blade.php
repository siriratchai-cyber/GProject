@extends('layouts.headclub')
@section('title', 'Home')

@section('style')
<style>
    * {
    box-sizing: border-box;
    }
    main {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 2%; 
        gap: 20px;
    }
    .box-welcome {
        background: #f9f6f2;
        border-radius: 40px;
        padding: 10px 20px;
        min-width: 200px;
        text-align: center;
    }
    p.textWelcome {
        text-align: center;
        margin: 0;
        font-size: 16px;
        color: #333;
    }
    .box-clubLeader {
        width: 90%;
        height: 22vh;
        background: #f9f6f2;
        border-radius: 30px; 
        padding: 10px;
        box-sizing: border-box;
    }
    p.text-1 {
        padding: 10px;
        text-indent: 25px;
        margin: 10px 0 10px 0;
    }
    .box-clubLeader img {
        padding: 10px;
        margin-top: -20px;
        margin-left: 5em;
        width: auto;
        height: 100px;
        border-radius: 30px;
    }
    .club-detail {
        display: flex;
        align-items: center;
        gap: 15px;
        margin: 30px 0px;
    }
    .club-detail img {
        width: 5vw;
        height: 9vh;
        border-radius: 50%;
    }
    .club-detail a {
        text-decoration: none;
        font-size: 16px;
        color: #333;
        margin-bottom: 20px;
    }
    .box-request {
        background: #f9f6f2;
        border-radius: 30px;
        border: 1px solid black;
        padding: 5px 15px;
        height: auto;
        display: flex; 
        align-items: center;
        justify-content: center;
        margin-left: 89%; 
    }
    a{
        color: black;
        text-decoration: none;
    }
    .box-request:hover{
        background-color: #5E5F68;
    }
    .request:hover{
        color: white;
    }
    .request {
        text-align: center;
        font-size: 14px;
    }
    .box-request span {
        color:red;
        font-weight: bold;
        margin-left: 5px;
    }
    .box-wel_rq {
        display: flex;
        align-items: center;
        width: 100%;
        height: 5vh;
        padding: 0 50px;
        box-sizing: border-box;
        position: relative;
    }
    .box-welcome-wrapper {
        position: absolute;
        left: 42%;
    }
    .container{
        display: flex;
        justify-content: flex-start;
        align-items: flex-start;
        margin-left: 7%; 
    }
    .activity{
        width: 45%;
        height: 400px;
        background: #f9f6f2;
        border-radius: 30px; 
        padding: 5px 30px;
        display: flex;
        flex-direction: column;
        word-wrap: break-word;  
        overflow-wrap: break-word;
        overflow-y: auto;
        overflow-x: hidden;
        gap: 10px;
    }
    .activity hr {
        height: 1px;  
        background-color: #000000ff; 
        margin: 10px 0;       
    }
    .activity p.content{
        margin: 2px 2px;
    }
    .activity p.content_head{
        margin: 2px 2px;
    }

    .showProfile{
        width: 45%;
        height: 400px;
        background: #f9f6f2;
        border-radius: 30px; 
        padding: 15px 30px;
        display: flex;
        flex-direction: column;
        margin-left: 40px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .showProfile img{
        width: 300px;
        height: 200px;
        margin: 0px 25%;
        border-radius: 30px;
    }
    .showProfile p{
        margin: 10px 0px;

    }
    .showProfile p.head{
        text-align: center;
        font-weight: bold;
    }
    .showProfile .btn_edit{
        background-color: #5E5F68;
        color: white;
        border: none;
        border-radius: 20px;
        color: white;
        padding: 8px 15px;
        cursor: pointer;
        font-size: 14px;
        width: fit-content;
        margin: 0px 70%;
    }
    .btn_edit:hover{
        background-color: #323339ff;
    }
    .club-detail a:hover{
        color: #5E5F68;
        text-decoration: underline;
    }
</style>
@endsection

@section('body')
    <main>
        <div class="box-wel_rq">
            <div class="box-welcome-wrapper">
                <div class="box-welcome">
                    <p class="textWelcome">Welcome Club leader</p>
                </div>
            </div>
            <div class="box-request">
                <a href="#" class="request">คำร้องขอ | <span>0</span></a>
            </div>  
        </div>
        <div class="box-clubLeader">
            <p class="text-1">ชมรมที่คุณดูแลอยู่</p>
            <div class="club-info">
                <p class="club-detail">
                    <img src="https://cdn.pixabay.com/photo/2024/11/08/12/57/cat-9183327_1280.jpg" alt="Club Image">
                    <a href="#">ชมรมแบดมินตัน</a>
                </p>
            </div>
        </div>
    </main>
        <div class="container">
            <div class="activity">
                <p>กิจกรรมทั้งหมดของชมรม</p>
                <p class="content_head">กิจกรรมที่ 1</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
                <p class="content_head">กิจกรรมที่ 2</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
                <p class="content_head">กิจกรรมที่ 3</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
                <p class="content_head">กิจกรรมที่ 4</p>
                <p class="content">welfkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkkwepfewwwwwwwwwwwwwwwwwwdlfpslfffffffffffffffffffffffffff</p>
                <hr>
            </div>
            <div class="showProfile">
                <p>โปรไฟล์ชมรม</p>
                <p class="head">ชมรมแบดมินตัน</p>
                <p><img src="https://cdn.pixabay.com/photo/2024/11/08/12/57/cat-9183327_1280.jpg" alt=""></p>
                <br>
                <form action="">
                    @csrf
                    <input type="submit" value="แก้ไขโปรไฟล์ชมรม" class="btn_edit">
                </form>
            </div>
        </div>
    
@endsection