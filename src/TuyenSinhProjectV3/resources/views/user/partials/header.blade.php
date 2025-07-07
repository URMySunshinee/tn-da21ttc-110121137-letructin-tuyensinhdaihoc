  <style>
    #mu-menu{
      position: relative;
    }
    
    #back-btn{
      position: absolute;
      left: 3%;
      top:120%;
      z-index: 1000;
      background-color: #f0f0f0; /* Nền xám nhạt */
      color: #333; /* Màu chữ đen xám */
      border: 1px solid #ccc; /* Viền mỏng */
      padding: 5px 10px; /* Đệm bên trong nút */
      border-radius: 5px; /* Góc bo tròn nhẹ */
      font-size: 16px; /* Kích thước chữ */
      cursor: pointer; /* Biểu tượng con trỏ khi di chuột */
      transition: all 0.3s ease; /* Hiệu ứng chuyển động mượt mà khi tương tác */
      display: flex; /* Sử dụng flexbox để căn giữa icon và text */
      align-items: center; /* Căn giữa theo chiều dọc */
      gap: 8px; /* Khoảng cách giữa icon và text */
      text-decoration: none; /* Đảm bảo không có gạch chân nếu dùng thẻ a */
    }

    #back-btn:hover {
      background-color: #e0e0e0; /* Nền đậm hơn khi di chuột */
      border-color: #b3b3b3;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1); /* Đổ bóng nhẹ */
    }

    #back-btn:active {
      background-color: #d0d0d0; /* Nền đậm hơn nữa khi click */
      box-shadow: none;
      transform: translateY(1px); /* Hiệu ứng nhấn xuống */
    }

    /* CSS cho header top responsive - Force override */
    .mu-header-top-left {
      display: flex !important;
      flex-direction: row !important;
      align-items: center !important;
      gap: 15px !important;
      flex-wrap: nowrap !important;
      width: 100% !important;
    }

    .mu-top-email,
    .mu-top-phone {
      display: flex !important;
      align-items: center !important;
      gap: 6px !important;
      font-size: 13px !important;
      white-space: nowrap !important;
      flex-shrink: 0 !important;
    }

    .mu-top-email {
      flex-shrink: 0 !important;
      min-width: auto !important;
      overflow: hidden !important;
    }

    .mu-top-email span {
      text-overflow: ellipsis !important;
      overflow: hidden !important;
      white-space: nowrap !important;
      display: block !important;
      max-width: 350px !important;
    }

    .mu-top-phone {
      flex-shrink: 0 !important;
      min-width: auto !important;
    }

    /* Responsive cho tablet và mobile */
    @media (max-width: 1200px) {
      .mu-top-email span {
        max-width: 280px !important;
      }
      .mu-header-top-left {
        gap: 12px !important;
      }
    }

    @media (max-width: 992px) {
      .mu-top-email span {
        max-width: 200px !important;
      }
      .mu-top-email,
      .mu-top-phone {
        font-size: 12px !important;
      }
      .mu-header-top-left {
        gap: 10px !important;
      }
    }

    @media (max-width: 768px) {
      .mu-top-email span {
        max-width: 150px !important;
      }
      .mu-top-email,
      .mu-top-phone {
        font-size: 11px !important;
      }
      .mu-header-top-left {
        gap: 8px !important;
      }
    }

    @media (max-width: 576px) {
      .mu-top-email span {
        max-width: 100px !important;
      }
      .mu-top-email,
      .mu-top-phone {
        font-size: 10px !important;
      }
      .mu-header-top-left {
        gap: 6px !important;
      }
    }
  </style>
  <!--START SCROLL TOP BUTTON -->
    <a class="scrollToTop" href="#">
      <i class="fa fa-angle-up"></i>      
    </a>
  <!-- END SCROLL TOP BUTTON -->

  <!-- Start header  -->
  <header id="mu-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="mu-header-area">
            <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="mu-header-top-left">
                  <div class="mu-top-email">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>126 Nguyễn Thiện Thành, K4, P. Hoà Thuận, Vĩnh Long</span>
                  </div>
                  <div class="mu-top-phone">
                    <i class="fa-solid fa-phone"></i>
                    <span>(0294) 3855 246</span>
                  </div>
                </div>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="mu-header-top-right">
                  <nav>
                    <ul class="mu-top-social-nav">
                      <li><a href="https://www.facebook.com/TraVinhUniversity.TVU" target="_blank" title="Facebook TVU"><span class="fa-brands fa-facebook"></span></a></li>
                      <li><a href="https://www.youtube.com/@TruongDaihocTraVinhTVU" target="_blank" title="Youtube TVU"><span class="fa-brands fa-youtube"></span></a></li>
                      <li><a href="https://www.tvu.edu.vn/" target="_blank" title="Website chính thức"><span class="fa fa-globe"></span></a></li>
                      <li><a href="https://zalo.me/daihoctravinh" target="_blank" title="Zalo TVU"><span class="fa fa-comment"></span></a></li>
                      <li><a href="mailto:tuyensinh@tvu.edu.vn" title="Email tuyển sinh"><span class="fa fa-envelope"></span></a></li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- End header  -->
  <!-- Start menu -->
  <section id="mu-menu">
    <nav class="navbar navbar-default" role="navigation">  
      <div class="container">
        <div class="navbar-header">
          <!-- FOR MOBILE VIEW COLLAPSED BUTTON -->
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <!-- LOGO -->              
          <!-- TEXT BASED LOGO -->
          <!-- <a class="navbar-brand" href="index.html"><i class="fa fa-university"></i><span>Varsity</span></a> -->
          <!-- IMG BASED LOGO  -->
          <a class="" href="{{route('user.home')}}">
            <img src="/assets/img/tvu-logo.gif" alt="logo">
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul id="top-menu" class="nav navbar-nav navbar-right main-nav">
            <li class="{{ Route::currentRouteName() === 'user.home' || Route::currentRouteName() === 'user.home1' ? 'active' : '' }} "><a href="{{route('user.home')}}">Trang chủ</a></li>            
            <li class="{{ Route::currentRouteName() === 'user.majorList' ? 'active' : '' }}"><a href="{{route('user.majorList')}}">Ngành học</a></li>
            <li class="{{ Route::currentRouteName() === 'user.admissionInfo' ? 'active' : '' }}"><a href="{{route('user.admissionInfo')}}">Thông tin xét tuyển</a></li>
            <li class="{{ Route::currentRouteName() === 'user.blogList' ? 'active' : '' }}"><a href="{{route('user.blogList')}}">Bài viết</a></li>

@if (Auth::check())
    <li class="{{ Route::currentRouteName() === 'user.aiChat' ? 'active' : '' }}">
        <a href="{{route('user.aiChat')}}">Tư vấn viên AI</a>
    </li>
@else
    <li>
        <a href="{{route('user.auth')}}?redirect=aiChat" onclick="showLoginAlert(); return true;">
            Tư vấn viên AI
        </a>
    </li>
@endif
            <!-- <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <span class="fa fa-angle-down"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="blog-archive.html">Blog Archive</a></li>                
                <li><a href="blog-single.html">Blog Single</a></li>                
              </ul>
            </li>             -->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">  @if (Auth::check()) {{Auth::user()->name}} @else Tài khoản @endif <span class="fa fa-angle-down"></span></a>
              <ul class="dropdown-menu" role="menu">
                @if (Auth::check()) 
                <li><a onclick="logout()"><form id="logout" action="{{route('logout')}}" method="POST">@csrf Đăng xuất</form></a></li>
                <li><a href="{{route('user.changeInfor')}}">Thông tin cá nhân</a></li>
                <li><a href="{{route('user.changePassword')}}">Đổi mật khẩu</a></li>
                 @else <li><a href="{{route('user.auth')}}">Đăng nhập/Đăng ký</a></li> @endif
                
              </ul>
            </li>    
            <li><a href="#" id="mu-search-icon"><i class="fa fa-search"></i></a></li>
          </ul>                     
        </div><!--/.nav-collapse -->        
      </div>     
    </nav>
    @if (Route::currentRouteName() === 'user.home' || Route::currentRouteName() === 'user.home1')
      
    @else
    <button id="back-btn" onclick="window.history.back()" title="Quay lại trang trước">
          <i class="fa fa-arrow-left"></i> Quay lại
    </button>
    @endif
  </section>
  <!-- End menu -->
  <!-- Start search box -->
  <div id="mu-search">
    <div class="mu-search-area">      
      <button class="mu-search-close"><span class="fa fa-close"></span></button>
      <div class="container">
        <div class="row">
          <div class="col-md-12">            
            <form class="mu-search-form">
              <input type="search" placeholder="Type Your Keyword(s) & Hit Enter">              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End search box -->
  <script>
    function logout(){
      document.querySelector("#logout").submit();
    }

    function showLoginAlert() {
    // Kiểm tra xem SweetAlert đã được load chưa
    if (typeof Swal !== 'undefined') {
        // Sử dụng SweetAlert nếu đã load
        Swal.fire({
            icon: 'error',  
            title: 'Yêu cầu đăng nhập',
            text: 'Vui lòng đăng nhập để sử dụng Tư vấn viên AI!',
            confirmButtonText: 'Đồng ý',
            confirmButtonColor: '#3085d6'
        });
    } else {
        // Sử dụng alert thông thường nếu SweetAlert chưa được load
        alert('Vui lòng đăng nhập để sử dụng Tư vấn viên AI!');
    }
}
  </script>