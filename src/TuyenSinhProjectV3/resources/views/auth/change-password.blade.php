@extends('user.layout')
@section('title', 'Đổi mật khẩu')
@section('content')
<style>
  body {
    background: none !important;
  }
  .login-bg {
    min-height: 100vh;
    width: 100vw;
    background: url('/assets/img/tvu bckgrd 1.jpg') no-repeat center center fixed;
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
    max-width: 700px;
    width: 100%;
    margin: 48px auto;
    display: block;
  }
  .auth-box h4 {
    font-weight: 600;
    margin-bottom: 24px;
    color: #2d3a4b;
    letter-spacing: 0.5px;
    text-align: center;
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
  .alert {
    margin-bottom: 18px;
    text-align: center;
    border-radius: 8px;
    font-size: 16px;
    letter-spacing: 0.5px;
    padding: 10px 12px;
  }
</style>
<div class="login-bg">
  <div class="auth-box">
    <h4>Đổi mật khẩu</h4>
    @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
    @endif
    @if (session('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif
    <form id="changePasswordForm" action="" method="POST">
      @csrf
      <div class="form-group">
        <label for="currentPassword">Mật khẩu hiện tại</label>
        <input type="password" class="form-control" name="old_password" id="currentPassword" required>
      </div>
      <div class="form-group">
        <label for="newPassword">Mật khẩu mới</label>
        <input type="password" class="form-control" name="password" id="newPassword" required minlength="8">
      </div>
      <div class="form-group">
        <label for="confirmPassword">Xác nhận mật khẩu mới</label>
        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" required minlength="8">
      </div>
      <button type="submit" class="btn btn-primary btn-block">Xác nhận</button>
    </form>
  </div>
</div>
@endsection
