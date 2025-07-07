@extends('user.layout')
@section('title', 'Thông tin cá nhân')
@section('content')
  <style>
    body {
      background-color: #f7f7f7;
      padding: 30px 0;
    }
    .profile-box {
      background: #fff;
      width: 80%;
      margin-top: 100px;
      margin-bottom: 50px;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h3 {
      margin-bottom: 20px;
      text-align: center;
    }
    .avatar-preview {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }
    .form-group.required label:after {
      content: "*";
      color: red;
      margin-left: 5px;
    }
    
    /* CSS cho phần danh sách yêu thích */
    .favorites-container {
      background: #fff;
      width: 80%;
      margin: 20px auto 100px;
      padding: 25px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .favorites-title {
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid #f0f0f0;
    }
    .favorites-section {
      margin-bottom: 30px;
    }
    .favorite-item {
      padding: 15px;
      margin-bottom: 15px;
      border-radius: 5px;
      border-left: 4px solid #6366f1;
      background-color: #f9f9f9;
      transition: all 0.3s ease;
    }
    .favorite-item:hover {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      transform: translateY(-2px);
    }
    .favorite-item h5 {
      margin-bottom: 8px;
      color: #333;
    }
    .favorite-item p {
      margin-bottom: 8px;
      color: #666;
    }
    .favorite-item .date {
      font-size: 12px;
      color: #999;
      font-style: italic;
    }
    .no-items {
      padding: 15px;
      text-align: center;
      color: #888;
      font-style: italic;
    }
    .blog-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
    }
    .blog-image {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 4px;
      margin-right: 15px;
    }
    .blog-details {
      flex: 1;
    }
    .view-more-btn {
      display: inline-block;
      margin-top: 5px;
      color: #6366f1;
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
    }
    .view-more-btn:hover {
      text-decoration: underline;
    }
  </style>

  
<div class="container" style="display: flex; justify-content: center;">
  <div class="profile-box">
    <h3>Thông tin cá nhân</h3>
    {{-- Hiển thị thông báo lỗi hoặc thành công --}}
    @if ($errors->any())
      <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
          <div>{{ $error }}</div>
        @endforeach
      </div>
    @endif
    @if (session('success'))
      <div style="text-align: center;" class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="profileForm" action="" method="POST">
      @csrf
      <!-- Tên -->
      <div class="form-group required">
        <label for="name">Họ và tên</label>
        <input type="text" class="form-control" name="name" id="name" placeholder="Nhập họ tên" value="{{Auth::user()->name}}" required>
      </div>

      <!-- Email -->
      <div class="form-group required">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" value="{{Auth::user()->email}}" placeholder="Nhập email" required>
      </div>

      <!-- Số điện thoại -->
      <div class="form-group required">
        <label for="phone">Số điện thoại</label>
        <input type="text" class="form-control" name="phone" id="phone" maxlength="10" pattern="[0-9]{10}" value="{{Auth::user()->phone}}" placeholder="Nhập số điện thoại" required>
      </div>

      <div class="form-group required">
        <label for="address">Địa chỉ</label>
        <input type="text" class="form-control" name="address" id="address" value="{{Auth::user()->address}}" placeholder="Nhập địa chỉ" required>
      </div>

      <div class="form-group required">
        <label for="age">Tuổi</label>
        <input type="number" class="form-control" name="age" id="age" min="1" max="100" step="1" value="{{Auth::user()->age}}" placeholder="Nhập số tuổi" required>
      </div>

      <!-- Nút lưu -->
      <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
    </form>
  </div>
</div>

<!-- Phần hiển thị các ngành học và bài viết đã thích -->
<div class="container">
  <div class="favorites-container">
    <h3 class="favorites-title">Danh sách yêu thích và lưu trữ của bạn</h3>
    
    <!-- Ngành học đã thích -->
    <div class="favorites-section">
      <h4><i class="fa fa-graduation-cap"></i> Ngành học đã thích</h4>
      <div class="row">
        @if(isset($likedMajors) && count($likedMajors) > 0)
          @foreach($likedMajors as $major)
            <div class="col-md-6">
              <div class="favorite-item">
                <h5>{{ $major->name_major }}</h5>
                <p>{{ \Illuminate\Support\Str::limit($major->description_major, 115) }}</p>
                <div class="date">Đã thích vào ngày: {{ \Carbon\Carbon::parse($major->date_like)->format('d/m/Y') }}</div>
                <a href="{{ route('user.majorDetail', ['id' => $major->id]) }}" class="view-more-btn">Xem chi tiết</a>
              </div>
            </div>
          @endforeach
        @else
          <div class="col-12 no-items">Bạn chưa thích ngành học nào.</div>
        @endif
      </div>
    </div>
    
    <!-- Bài viết đã thích -->
    <div class="favorites-section">
      <h4><i class="fa fa-newspaper-o"></i> Bài viết đã lưu</h4>
      <div class="row">
        @if(isset($likedBlogs) && count($likedBlogs) > 0)
          @foreach($likedBlogs as $blog)
            <div class="col-md-6">
              <div class="favorite-item blog-item">
                <img src="{{ $blog->image_blog }}" alt="{{ $blog->name_blog }}" class="blog-image">
                <div class="blog-details">
                  <h5>{{ \Illuminate\Support\Str::limit($blog->name_blog, 55) }}</h5>
                  <div class="date">Đã lưu vào ngày: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</div>
                  <a href="{{ route('user.blogDetail', ['id' => $blog->id]) }}" class="view-more-btn">Xem chi tiết</a>
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="col-12 no-items">Bạn chưa lưu bài viết nào.</div>
        @endif
      </div>
    </div>
  </div>
</div>

  <script>
    document.getElementById('profileForm').addEventListener('submit', function(event) {
      // Kiểm tra xem người dùng có nhập đầy đủ thông tin không
      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const phone = document.getElementById('phone').value.trim();
      const address = document.getElementById('address').value.trim();
      const age = document.getElementById('age').value;

      if (!name || !email || !phone || !address || !age) {
        event.preventDefault(); // Ngăn chặn gửi form nếu có trường trống
        alert('Vui lòng điền đầy đủ thông tin.');
      }
    });
  </script>
@endsection
