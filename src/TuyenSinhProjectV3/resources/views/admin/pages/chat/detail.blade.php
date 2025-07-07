@extends('admin.layout')
@section('title', "Lịch sử chat của {$user->name}")
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{route('admin.chat')}}">Chats</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Lịch sử chat của người dùng {{$user->name}} </li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
          <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      height: 100vh;
    }
    .chat-container {
      flex: 1;
      padding: 20px;
      overflow-y: auto;
    }

    .message {
      max-width: 70%;
      margin-bottom: 10px;
      padding: 10px 15px;
      border-radius: 15px;
      clear: both;
    }

    .message.user {
      background-color: #d1e7dd;
      color: #000;
      float: right;
      text-align: right;
      border-bottom-right-radius: 0;
    }

    .message.gpt {
      background-color: #ffffff;
      color: #000;
      float: left;
      border-bottom-left-radius: 0;
      border: 1px solid #ddd;
    }

    .input-container {
      display: flex;
      padding: 10px;
      background: #fff;
      border-top: 1px solid #ccc;
      margin-bottom: 100px;
    }

    .input-container input {
      flex: 1;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    .input-container button {
      margin-left: 10px;
      padding: 10px 20px;
      font-size: 16px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .input-container button:hover {
      background-color: #0056b3;
    }
    .ai-title{
        margin-top: 200px;
    }
  </style>
<div class="container">
    <div class="chat-container" id="chat">
      </div>
</div>
      </div>
    </div>
  </main>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
        function loadMessage(){
       const chat = document.getElementById("chat");
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
fetch('/admin/load-message-admin/'+{{$user_id}}, {  
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
    })
    .then(response => response.json())  
    .then(data => {
      data.dataMessage.forEach(element => {
        if(element.type_message==0){
      const userMsg = document.createElement("div");
      userMsg.className = "message user";
      userMsg.textContent = element.message_content;
      chat.appendChild(userMsg);
        }else{
        const gptMsg = document.createElement("div");
        gptMsg.className = "message gpt";
        gptMsg.textContent = element.message_content;
        chat.appendChild(gptMsg);
        chat.scrollTop = chat.scrollHeight;
        }
      });
      const gptMsg = document.createElement("div");
        gptMsg.className = "message gpt";
        gptMsg.textContent = "Xin chào! Tôi có thể giúp gì cho bạn hôm nay?";
        chat.appendChild(gptMsg);
        chat.scrollTop = chat.scrollHeight;
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById("response").innerText = 'Có lỗi xảy ra!';
    });
}
loadMessage()
  </script>
  @endsection

