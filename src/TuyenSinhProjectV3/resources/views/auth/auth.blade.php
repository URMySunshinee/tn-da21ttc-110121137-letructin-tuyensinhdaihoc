@extends('user.layout')
@section('title')
  <span id="dynamicTitle">Đăng nhập</span>
@endsection
@section('content')
<style>
  body {
    background: none !important;
  }
  .login-bg {
    min-height: 100vh;
    width: 100vw;
    background: url('assets/img/tvu bckgrd 1.jpg') no-repeat center center fixed;
    background-size: cover;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    z-index: 1;
  }
  .auth-box {
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    padding: 36px 32px 28px 32px;
    border-radius: 18px;
    box-shadow: 0 8px 32px 0 rgba(60,72,88,0.18);
    max-width: 650px;
    width: 100%;
    margin: 48px auto;
    display: block;
  }
  .auth-box h4 {
    font-weight: 600;
    margin-bottom: 24px;
    color: #2d3a4b;
    letter-spacing: 0.5px;
  }
  .form-group label {
    font-size: 15px;
    color: #2d3a4b;
    margin-bottom: 6px;
    font-weight: 500;
  }
  .form-control {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 15px;
    padding: 10px 12px;
    margin-bottom: 8px;
    background: #f9fafb;
    transition: border 0.2s;
  }
  .form-control:focus {
    border-color: #6366f1;
    background: #fff;
    outline: none;
    box-shadow: 0 0 0 2px #6366f133;
  }
  .btn-block {
    width: 100%;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 0;
    margin-top: 8px;
    transition: background 0.2s;
  }
  .btn-primary {
    background: #6366f1;
    border: none;
  }
  .btn-primary:hover {
    background: #4f46e5;
  }
  .btn-success {
    background: #22c55e;
    border: none;
  }
  .btn-success:hover {
    background: #16a34a;
  }
  .btn-warning {
    background: #f59e42;
    border: none;
    color: #fff;
  }
  .btn-warning:hover {
    background: #d97706;
  }
  .toggle-link {
    color: #6366f1;
    cursor: pointer;
    text-decoration: underline;
    font-weight: 500;
  }
  .toggle-link:hover {
    color: #4f46e5;
  }
  .has-error .help-block {
    color: #ef4444;
    font-size: 13px;
    margin-top: 2px;
  }
  .alert {
    margin-bottom: 18px;
    text-align: center;
    border-radius: 8px;
    font-size: 16px;
    letter-spacing: 0.5px;
    padding: 10px 12px;
  }
  .text-center {
    text-align: center;
  }
  .hidden { display: none !important;
  }
  
  .or-separator {
    text-align: center;
    position: relative; /* Quan trọng để định vị các pseudo-elements */
    margin: 20px 0; /* Khoảng cách trên dưới */
    color: #888; /* Màu chữ "Hoặc" */
  }

  .or-separator::before,
  .or-separator::after {
      content: '';
      position: absolute;
      top: 50%; /* Căn giữa theo chiều dọc */
      width: calc(50% - 30px); /* 50% chiều rộng trừ đi khoảng trống cho chữ và lề */
      border-bottom: 1px solid #ccc; /* Đường kẻ ngang */
  }

  .or-separator::before {
      left: 0; /* Đường kẻ bên trái */
  }

  .or-separator::after {
      right: 0; /* Đường kẻ bên phải */
  }


</style>
<div class="login-bg">
  <div class="auth-box">
    {{-- Hiển thị thông báo lỗi hoặc thành công --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form id="loginForm" action="{{route('login')}}" method="POST" novalidate>
      @csrf 
        
        <h4 class="text-center">Đăng nhập</h4>
        <div class="text-center" style="margin-bottom: 18px;">
          <a href="{{ route('auth.google') }}" class="btn btn-danger btn-block" style="background: #ea4335; color: #fff; font-weight:600; border:none; border-radius:8px; padding:10px 0; margin-bottom:10px; display: flex; align-items: center; justify-content: center; gap: 8px;">
            <img src="/assets/img/logo-gg.png" alt="Google logo" style="width:22px; height:22px; border-radius:50%; margin-right:8px;"> Đăng nhập bằng tài khoản Google
          </a>
        </div>
        <h5 class="or-separator" style="text-align: center;">Hoặc</h5>
        <div class="form-group">
          <label for="loginEmail">Email</label>
          <input type="email" class="form-control" name="email" id="loginEmail" required>
          <span class="help-block" style="display: none;">Vui lòng nhập email hợp lệ.</span>
        </div>
        <div class="form-group">
          <label for="loginPassword">Mật khẩu</label>
          <input type="password" class="form-control" name="password" id="loginPassword" required minlength="8">
          <span class="help-block" style="display: none;">Mật khẩu phải có ít nhất 8 ký tự.</span>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        
        <p class="text-center" style="margin-top: 14px;"><i>Chưa có tài khoản?</i> <span style="text-decoration: none;" class="toggle-link" onclick="switchForm('register')">Đăng ký</span></p>
        <p class="text-center" style="margin-top: 10px;"><i>Quên mật khẩu?</i> <span style="text-decoration: none;" class="toggle-link" onclick="switchForm('forgot')">Nhấn vào đây</span></p>
      </form>
    <form id="forgotForm" action="{{route('user.sendMailResetPass')}}" method="POST" class="hidden" novalidate>
      @csrf
      <h4 class="text-center">Quên mật khẩu</h4>
      <div class="form-group">
        <label for="forgotEmail">Email</label>
        <input type="email" class="form-control" name="email" id="forgotEmail" required placeholder="Vui lòng nhập địa chỉ email tài khoản của bạn để chúng tôi có thể hỗ trợ!">
        <span class="help-block" style="display: none;">Vui lòng nhập email hợp lệ.</span>
      </div>
      <button type="submit" class="btn btn-warning btn-block">Gửi liên kết đặt lại mật khẩu</button>
      <p class="text-center" style="margin-top: 10px;"><i>Nhớ mật khẩu? Quay lại</i> <span style="text-decoration: none;" class="toggle-link" onclick="switchForm('login')">Đăng nhập</span></p>
    </form>
    <form id="registerForm" action="{{route('register')}}" method="POST" class="hidden" novalidate>
      @csrf
      <h4 class="text-center">Đăng ký</h4>
      <div class="form-group">
        <label for="name">Tên</label>
        <input type="text" class="form-control" name="name" id="name" required>
        <span class="help-block" style="display: none;">Vui lòng nhập tên.</span>
      </div>
      <div class="form-group">
        <label for="registerEmail">Email</label>
        <input type="email" class="form-control" name="email" id="registerEmail" required>
        <span class="help-block" style="display: none;">Vui lòng nhập email hợp lệ.</span>
      </div>
      <div class="form-group">
        <label for="registerPassword">Mật khẩu</label>
        <input type="password" class="form-control" name="password" id="registerPassword" minlength="8" required>
        <span class="help-block" style="display: none;">Mật khẩu phải có ít nhất 8 ký tự.</span>
      </div>
      <div class="form-group">
        <label for="phone">Số điện thoại</label>
        <input type="text" class="form-control" name="phone" id="phone" maxlength="10" pattern="^[0-9]{10}$" required>
        <span class="help-block" style="display: none;">Số điện thoại phải gồm 10 chữ số.</span>
      </div>
      <div class="form-group">
        <label for="address">Địa chỉ</label>
        <input type="text" class="form-control" name="address" id="address" maxlength="255" required>
        <span class="help-block" style="display: none;">Vui lòng nhập địa chỉ.</span>
      </div>
      <div class="form-group">
        <label for="age">Tuổi</label>
        <input type="number" class="form-control" name="age" id="age" min="1" max="100" step="1"  required>
        <span class="help-block" style="display: none;">Vui lòng nhập tuổi.</span>
      </div>
      <button type="submit" class="btn btn-success btn-block">Đăng ký</button>
      <p class="text-center" style="margin-top: 10px;">Đã có tài khoản? <span class="toggle-link" onclick="switchForm('login')">Đăng nhập</span></p>
    </form>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
  function setTitle(type) {
    let title = 'Đăng nhập';
    if (type === 'register') title = 'Đăng ký';
    else if (type === 'forgot') title = 'Quên mật khẩu';
    document.title = title + ' ';
    if (document.getElementById('dynamicTitle')) {
      document.getElementById('dynamicTitle').textContent = title;
    }
  }
  function switchForm(type) {
    $('#loginForm, #registerForm, #forgotForm').addClass('hidden');
    if (type === 'login') {
      $('#loginForm').removeClass('hidden');
    } else if (type === 'register') {
      $('#registerForm').removeClass('hidden');
    } else if (type === 'forgot') {
      $('#forgotForm').removeClass('hidden');
    }
    setTitle(type);
  }
  function showError($input, message) {
    $input.closest('.form-group').addClass('has-error');
    $input.siblings('.help-block').text(message).show();
  }
  function clearErrors(form) {
    form.find('.form-group').removeClass('has-error');
    form.find('.help-block').hide();
  }
  $('#loginForm').on('submit', function(e) {
    e.preventDefault();
    var $form = $(this);
    clearErrors($form);
    var email = $('#loginEmail').val().trim();
    var pass = $('#loginPassword').val();
    var valid = true;
    if (!email || !email.includes('@')) {
      showError($('#loginEmail'), 'Vui lòng nhập email hợp lệ.');
      valid = false;
    }
    if (!pass || pass.length < 8) {
      showError($('#loginPassword'), 'Mật khẩu phải có ít nhất 8 ký tự.');
      valid = false;
    }
    if (valid) {
      $form.off('submit');
      $form.submit();
    }
  });
  $('#registerForm').on('submit', function(e) {
    e.preventDefault();
    var $form = $(this);
    clearErrors($form);
    var name = $('#name').val().trim();
    var email = $('#registerEmail').val().trim();
    var pass = $('#registerPassword').val();
    var phone = $('#phone').val().trim();
    var address = $('#address').val().trim();
    var age = $('#age').val().trim();
    var valid = true;
    if (!name) {
      showError($('#name'), 'Vui lòng nhập tên.');
      valid = false;
    }
    if (!email || !email.includes('@')) {
      showError($('#registerEmail'), 'Vui lòng nhập email hợp lệ.');
      valid = false;
    }
    if (!pass || pass.length < 8) {
      showError($('#registerPassword'), 'Mật khẩu phải có ít nhất 8 ký tự.');
      valid = false;
    }
    if (!phone.match(/^[0-9]{10}$/)) {
      showError($('#phone'), 'Số điện thoại phải gồm 10 chữ số.');
      valid = false;
    }
    if (!address) {
      showError($('#address'), 'Vui lòng địa chỉ.');
      valid = false;
    }
    if (!age) {
      showError($('#age'), 'Vui lòng tuổi.');
      valid = false;
    }
    if (valid) {
      $form.off('submit');
      $form.submit();
    }
  });

  //Kiểm tra form quên mật khẩu
  $('#forgotForm').on('submit', function(e) {
    e.preventDefault();
    var $form = $(this);
    clearErrors($form);
    var email = $('#forgotEmail').val().trim();
    var valid = true;
    if (!email || !email.includes('@')) {
      showError($('#forgotEmail'), 'Vui lòng nhập email của bạn.');
      valid = false;
    }
    if (valid) {
      $form.off('submit');
      $form.submit();
    }
  });

  $(document).ready(function() {
    setTitle('login');

    const authBox = document.querySelector('.auth-box');
        if (authBox) {
            authBox.scrollIntoView({
                behavior: 'smooth', // Cuộn mượt mà
                block: 'center'    // Căn giữa theo chiều dọc
            });
        }
  });
</script>
@endsection
