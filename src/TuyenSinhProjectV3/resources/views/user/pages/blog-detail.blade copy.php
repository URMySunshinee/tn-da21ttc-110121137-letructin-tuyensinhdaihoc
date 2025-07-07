@extends('user.layout')
@section('title', 'Trang chủ')
@section('content')
<title>{{$dataBlog->name_blog}}</title>
 <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      margin: 0;
      padding: 20px;
    }

    .container-detail {
        display: flex;
        justify-content: center;
      background: #fff;
      border-radius: 10px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h1 {
      margin-bottom: 10px;
      color: #333;
    }

    .section {
      margin-top: 25px;
    }

    .section h2 {
      color: #0056b3;
      margin-bottom: 10px;
    }

    .section p {
      color: #555;
      line-height: 1.6;
    }

    .view-section {
      margin-top: 20px;
      display: flex;
      align-items: center;
    }
  </style>
   <div class="container-detail">
    <div class="container">
<div class="major-title" style="display:flex;flex-direction:column;align-items:center">
    <h1>{{$dataBlog->name_blog}}</h1>
    <p style="color:green">Tác giả: {{$dataBlog->author_name}} - Viết ngày: {{$dataBlog->date_blog}} - Chủ đề: {{$dataBlog->category_name}}</p>
</div>
    <div class="section">
      <h2>Mô tả bài viết</h2>
      <p>
        {{$dataBlog->description_blog}}
      </p>
      <div class="view-section">
        <div class=""> {{$dataBlog->view_blog}} lượt đọc</div>
      </div>
      <br>
    </div>
    <div class="section">
        {!! $dataBlog->content_blog !!}
    </div>
</div>
  </div>
@endsection
