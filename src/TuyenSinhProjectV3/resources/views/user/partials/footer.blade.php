<!-- Start footer -->
  <footer id="mu-footer">
    <!-- start footer top -->
    <div class="mu-footer-top">
      <div class="container">
        <div class="mu-footer-top-area">
          <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="mu-footer-widget">
                <h4>Thông Tin</h4>
                <ul>
                  <li><a href="{{route('user.aboutUs')}}">Giới thiệu về TVU</a></li>
                  <li><a href="{{route('user.blogDetail', 27)}}">Tại sao chọn TVU?</a></li>
                  <li><a href="{{ route('user.admissionInfo') }}">Thông tin tuyển sinh</a></li>
                  <li><a href="#">Sự kiện</a></li>
                  <li><a href="#">Sơ đồ trang web</a></li>
                  <li><a href="#">Điều khoản sử dụng</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="mu-footer-widget">
                <h4>Hỗ Trợ Sinh Viên</h4>
                <ul>   
                  <li><a href="{{ route('user.blogList') }}?category=2">Hướng dẫn đăng ký</a></li>    
                  <li><a href="{{ route('user.blogList') }}?category=4">Câu hỏi thường gặp</a></li>
                  <li><a href="https://dichvuvieclam.tvu.edu.vn/vi/" target="_blank">Việc làm cho sinh viên</a></li>
                  <li><a href="#">Tải tài liệu</a></li>
                  <li><a href="#">Các khóa học mới</a></li>
                  <li><a href="#">Tin tức học thuật</a></li>                   
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="mu-footer-widget">
                <h4 class="text-white">Lượt Truy Cập</h4>
                <ul style="list-style:none;padding-left:0; color:white;">
                  @php
                    $visitStats = \App\Http\Controllers\user\VisitController::getVisitStats();
                  @endphp
                  <li style="padding-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                    <span><span style="margin-right:33px; color: white;">👤</span>Hôm nay</span>
                    <span class="text-white" style="margin-left:24px; min-width:60px; text-align:center;">{{ number_format($visitStats['today'] ?? 0) }}</span>
                  </li>
                  <li style="padding-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                    <span><span style="margin-right:12px; color: white;">🧑‍💼</span>Hôm qua</span>
                    <span class="text-white" style="margin-left:24px; min-width:60px; text-align:center;">{{ number_format($visitStats['yesterday'] ?? 0) }}</span>
                  </li>
                  <li style="padding-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                    <span><span style="margin-right:31px; color: white;">👥</span>Tuần này</span>
                    <span class="text-white" style="margin-left:24px; min-width:60px; text-align:center;">{{ number_format($visitStats['week'] ?? 0) }}</span>
                  </li>
                  <li style="padding-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                    <span><span style="margin-right:23px; color: white;">👨‍👩‍👧‍👦</span>Tháng này</span>
                    <span class="text-white" style="margin-left:24px; min-width:60px; text-align:center;">{{ number_format($visitStats['month'] ?? 0) }}</span>
                  </li>
                  <li style="padding-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                    <span><span style="margin-right:22px; color: white;">👨‍👩‍👧‍👦</span>Năm này</span>
                    <span class="text-white" style="margin-left:24px; min-width:60px; text-align:center;">{{ number_format($visitStats['year'] ?? 0) }}</span>
                  </li>
                  <li style="padding-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                    <span><span style="margin-right:31px; color: white;">📊</span>Tất cả</span>
                    <span class="text-white" style="margin-left:24px; min-width:60px; text-align:center;">{{ number_format($visitStats['all'] ?? 0) }}</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
              <div class="mu-footer-widget">
                <h4>Liên Hệ</h4>
                <address>
                  <p>Đại học Trà Vinh, Số 126, Đường Nguyễn Thiện Thành, TP. Trà Vinh, Việt Nam</p>
                  <p>Điện thoại: (0294) 3856 358</p>
                  <p>Website: www.tvu.edu.vn</p>
                  <p>Email: tuyensinh@tvu.edu.vn</p>
                </address>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end footer top -->
    <!-- start footer bottom -->
    <div class="mu-footer-bottom">
      <div class="container">
        <div class="mu-footer-bottom-area">
          <p>&copy; 2025 Đại học Trà Vinh. Được thiết kế bởi <a href="#" rel="nofollow">Tin Le</a></p>
        </div>
      </div>
    </div>
    <!-- end footer bottom -->
</footer>

