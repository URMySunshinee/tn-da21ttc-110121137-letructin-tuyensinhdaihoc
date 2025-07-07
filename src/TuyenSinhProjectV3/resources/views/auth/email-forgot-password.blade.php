<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Đặt lại mật khẩu</title>
  <style>
    .button {
      background-color: #28a745;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 5px;
      display: inline-block;
      font-weight: bold;
    }
    .container {
      max-width: 600px;
      margin: auto;
      padding: 20px;
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      border: 1px solid #ddd;
      border-radius: 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Yêu cầu đặt lại mật khẩu</h2>
    <p>Xin chào,</p>
    <p>Bạn đã yêu cầu đặt lại mật khẩu. Nhấn vào nút bên dưới để tiến hành:</p>
    <p>
      <a href="{{ route('auth.reset-password', ['token' => $token]) }}" class="button">Đặt lại mật khẩu</a>
    </p>
    <p>Nếu bạn không yêu cầu hành động này, vui lòng bỏ qua email này.</p>
    <p>Trân trọng,<br>Đội ngũ hỗ trợ</p>
  </div>
</body>
</html>
