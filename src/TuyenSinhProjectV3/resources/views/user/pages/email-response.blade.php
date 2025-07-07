<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thư phản hồi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #0a5dc2;
        }
        .content {
            font-size: 16px;
            margin-bottom: 30px;
        }
        .footer {
            font-size: 14px;
            color: #666666;
            border-top: 1px solid #dddddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Thư phản hồi từ Trường Đại học Trà Vinh
        </div>
        <div class="content">
            Kính chào <strong>{{$name_request}}</strong>,<br><br>
            Cảm ơn bạn đã liên hệ với chúng tôi.<br><br>
            Chúng tôi đã nhận được thông tin từ bạn và sẽ phản hồi trong thời gian sớm nhất.<br><br>
            Họ và tên: <strong>{{$name_request}}</strong>
            <br>
            Số điện thoại: <strong>{{$phone_request}}</strong>
            <br>
            Email: <strong>{{$email_request}}</strong>
            <br>
            Ngày sinh: <strong>{{$birth}}</strong>
            <br>
            Thành phố sinh sống hiện tại: <strong>{{$name_city->name_city}}</strong>
            <br>
            Ngành học quan tâm: <strong>{{$name_major->name_major}}</strong>
            <br>
            Trường thpt đang học: <strong>{{$school}}</strong>
            <br>
            Nếu bạn cần hỗ trợ gấp, vui lòng liên hệ trực tiếp qua hotline <strong>0294 3855 246</strong> hoặc email <strong>tuyensinh@tvu.edu.vn</strong>.<br><br>
            Trân trọng,<br>
            <strong>Phòng Tuyển Sinh - Trường Đại học Trà Vinh</strong>
        </div>
        <div class="footer">
            Đây là email tự động, vui lòng không trả lời email này.<br>
            © 2025 Trường Đại học Trà Vinh
        </div>
    </div>
</body>
</html>
