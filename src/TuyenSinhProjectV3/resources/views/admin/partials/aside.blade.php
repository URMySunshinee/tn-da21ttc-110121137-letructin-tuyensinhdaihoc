<style>
  .dropdown-arrow {
    transition: transform 0.3s ease-in-out; /* Tạo hiệu ứng chuyển động mượt mà */
}

/* Khi dropdown mở, xoay mũi tên */
.nav-link[aria-expanded="true"] .dropdown-arrow {
    transform: rotate(180deg); /* Xoay 180 độ khi mở */
}

/* Ẩn pseudo-element mũi tên tự động của Bootstrap/Material */
a[data-bs-toggle="collapse"]::after,
a[data-bs-toggle="collapse"]::before {
  display: none !important;
  content: none !important;
}

</style>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="{{route('user.home')}}" target="blank_">
        <img src="{{ asset('assets1/img/logo-tvu.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">TVU-DASHBOARD</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->routeIs('admin.home') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.home')}}">
            <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li> 
        <!-- Nhóm Bài viết -->
        <li class="nav-item">
          <a class="nav-link text-dark d-flex align-items-center" data-bs-toggle="collapse" href="#menu-bai-viet" role="button" aria-expanded="{{ request()->routeIs('admin.blog*') || request()->routeIs('admin.blogCategory*') ? 'true' : 'false' }}" aria-controls="menu-bai-viet">
            <span class="d-flex align-items-center">
              <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">
              full_coverage
              </i> &nbsp;
              <span class="nav-link-text">Bài viết</span>
            </span>
            <i style="font-size: 1.5rem;" class="material-symbols-rounded dropdown-arrow">arrow_drop_down</i>
          </a>
          <div class="collapse {{ request()->routeIs('admin.blog*') || request()->routeIs('admin.blogCategory*') ? 'show' : '' }}" id="menu-bai-viet">
            <ul class="nav flex-column ms-3">
              <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('admin.blogCategory*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.blogCategory')}}">
                  <span>🗂️</span>&nbsp;
                  <span class="nav-link-text">Quản lý danh mục bài viết</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('admin.blog*') && !request()->routeIs('admin.blogCategory*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.blog')}}">
                  <span>📝</span>&nbsp;
                  <span class="nav-link-text">Quản lý bài viết</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- Nhóm Ngành học -->
        <li class="nav-item">
          <a class="nav-link text-dark d-flex align-items-center" data-bs-toggle="collapse" href="#menu-nganh-hoc" role="button" aria-expanded="{{ request()->routeIs('admin.major*') || request()->routeIs('admin.majorCategory*') || request()->routeIs('admin.subjectCombination*') ? 'true' : 'false' }}" aria-controls="menu-nganh-hoc">
            <span class="d-flex align-items-center">
              <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">table_view</i> &nbsp;
              <span class="nav-link-text">Ngành học</span>
            </span>
            <i style="font-size: 1.5rem;" class="material-symbols-rounded dropdown-arrow">arrow_drop_down</i>
          </a>
          <div class="collapse {{ request()->routeIs('admin.major*') || request()->routeIs('admin.majorCategory*') || request()->routeIs('admin.subjectCombination*') ? 'show' : '' }}" id="menu-nganh-hoc">
            <ul class="nav flex-column ms-3">
              <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('admin.majorCategory*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.majorCategory')}}">
                  <span>🏛️</span>&nbsp;
                  <span class="nav-link-text">Quản lý khối ngành</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('admin.major*') && !request()->routeIs('admin.majorCategory*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.major')}}">
                  <span>📚</span>&nbsp;
                  <span class="nav-link-text">Quản lý ngành học</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('admin.subjectCombination*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.subjectCombination')}}">
                  <span>📑</span>&nbsp;
                  <span class="nav-link-text">Quản lý tổ hợp môn</span>
                </a>
              </li>
            </ul>
          </div>
        </li>
        <!-- Các mục còn lại giữ nguyên -->
        
        
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->routeIs('admin.question*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.question')}}">
            <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">attach_email</i>
            <span class="nav-link-text ms-1">Quản lý tư vấn</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->routeIs('admin.user*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.user')}}">
            <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">account_circle</i>
            <span class="nav-link-text ms-1">Quản lý người dùng</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->routeIs('admin.chat*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.chat')}}">
            <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">chat</i>
            <span class="nav-link-text ms-1">Lịch sử Chatbot</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark {{ request()->routeIs('admin.report*') ? 'active bg-gradient-primary text-white' : '' }}" href="{{route('admin.report')}}">
            <i style="font-size: 1.4rem;" class="material-symbols-rounded opacity-5">analytics</i>
            <span class="nav-link-text ms-1">Thống kê trang web</span>
          </a>
        </li> &nbsp;
        <li class="nav-item">
          <form id="logout" action="{{route('logout')}}" method="POST">
            @csrf 
          <a class="nav-link text-dark" onclick="logout()">
            <i style="font-size: 1.4rem; color: red;" class="material-symbols-rounded opacity-5">logout</i>
            <span style="color: red;" class="nav-link-text ms-1">Đăng xuất</span>
          </a>
          </form>
        </li>
      </ul>
    </div>
  </aside>
       <script>
    function logout(){
      document.querySelector("#logout").submit();
    }
  </script>