@extends('user.layout')
@section('title', 'Trang chủ')
@section('content')
<title>Trang chủ</title>
<style>
  /* Container để căn giữa nút */
.view-all-button-container {
    display: flex;
    justify-content: center;
    margin-top: 50px; /* Giữ nguyên khoảng cách trên nếu bạn muốn */
    padding: 0 15px; /* Thêm padding ngang cho responsive trên màn hình nhỏ */
}

/* Style cho nút "XEM TẤT CẢ" */
.view-all-button {
    display: inline-flex; /* Đảm bảo nội dung căn giữa và icon nếu có */
    align-items: center;
    justify-content: center;
    width: auto; /* Chiều rộng tự động theo nội dung */
    min-width: 180px; /* Đảm bảo nút đủ lớn */
    height: 50px;
    padding: 0 30px; /* Padding ngang cho nội dung bên trong nút */
    background-color: #6366f1; /* Màu nền chính (ví dụ: màu tím của bạn) */
    color: #ffffff; /* Màu chữ trắng */
    border: none; /* Bỏ viền */
    border-radius: 8px; /* Bo tròn góc */
    font-size: 16px;
    font-weight: 600; /* Chữ đậm hơn */
    text-decoration: none; /* Bỏ gạch chân link */
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease; /* Hiệu ứng mượt mà */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ */
}

.view-all-button:hover {
    background-color: #4f46e5; /* Màu nền đậm hơn khi hover */
    transform: translateY(-2px); /* Nhấc nhẹ nút lên khi hover */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); /* Đổ bóng đậm hơn */
}

.view-all-button:active {
    transform: translateY(0); /* Trở về vị trí cũ khi nhấn */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Đổ bóng nhẹ hơn */
}

/* Responsive adjustment (tùy chọn) */
@media (max-width: 768px) {
    .view-all-button {
        width: 80%; /* Chiếm 80% chiều rộng trên màn hình nhỏ */
        min-width: unset; /* Bỏ min-width trên màn hình nhỏ */
        font-size: 15px;
        height: 45px;
    }
}

/* Style cho nút có viền */
.detail-button-outline {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 20px;
    background-color: transparent; /* Nền trong suốt */
    color: #6366f1; /* Màu chữ chính */
    border: 1.5px solid #6366f1; /* Viền màu tím/xanh */
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    /* margin-top: 15px; */
}

.detail-button-outline:hover {
    background-color: #6366f1; /* Nền màu tím/xanh khi hover */
    color: #ffffff; /* Chữ trắng khi hover */
    border-color: #6366f1; /* Viền vẫn màu tím/xanh */
}

.detail-button-outline:active {
    background-color: #4f46e5;
    border-color: #4f46e5;
    color: #ffffff;
}
</style>
@if (session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif
<!-- Start Slider -->
  <section id="mu-slider">
    <!-- Start single slider item -->
    <div class="mu-slider-single">
      <div class="mu-slider-img">
        <figure>
          <img src="https://tuyensinh.tvu.edu.vn/wp-content/uploads/2025/06/banner-tuyen-sinh-2025-t6-scaled.jpg" alt="img">
        </figure>
      </div>
      <!-- <div class="mu-slider-content">
        <h4>Welcome To Varsity</h4>
        <span></span>
        <h2>We Will Help You To Learn</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.</p>
        <a href="#" class="mu-read-more-btn">Read More</a>
      </div> -->
    </div>
    <!-- Start single slider item -->
    <!-- Start single slider item -->
    <div class="mu-slider-single">
      <div class="mu-slider-img">
        <figure>
          <img src="https://www.tvu.edu.vn/wp-content/uploads/2025/06/kiem-dinh-chat-luong-quoc-te-tvu-scaled.jpg" alt="img">
        </figure>
      </div>
      <!-- <div class="mu-slider-content">
        <h4>Premiumu Quality Free Template</h4>
        <span></span>
        <h2>Best Education Template Ever</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.</p>
        <a href="#" class="mu-read-more-btn">Read More</a>
      </div> -->
    </div>
    <!-- Start single slider item -->
    <!-- Start single slider item -->
    {{-- <div class="mu-slider-single">
      <div class="mu-slider-img">
        <figure>
          <img src="https://tuyensinh.tvu.edu.vn/wp-content/uploads/2025/06/banner-tuyen-sinh-2025-t6-scaled.jpg" alt="img">
        </figure>
      </div>
      <!-- <div class="mu-slider-content">
        <h4>Exclusivly For Education</h4>
        <span></span>
        <h2>Education For Everyone</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolor amet error eius reiciendis eum sint unde eveniet deserunt est debitis corporis temporibus recusandae accusamus.</p>
        <a href="#" class="mu-read-more-btn">Read More</a>
      </div> -->
    </div> --}}
    <!-- Start single slider item -->    
  </section>
  <!-- End Slider -->
   &nbsp;
  <!-- Start functional buttons section (TVU style, 2 rows, 3 columns, background image ready) -->
  <section id="mu-functional-buttons" style="margin-top:24px;margin-bottom:30px;">
    <div class="mu-bg-overlay"></div>
    <div class="container">
      <div class="mu-functional-btns-grid">
        <a style="text-decoration: none;" href="https://zalo.me/daihoctravinh" target="_blank" class="mu-func-btn mu-func-btn-blue">
          <span class="func-btn-icon"><i class="fa fa-headphones"></i></span>
          <span>Hỗ trợ tư vấn trực tuyến</span>
        </a>
        <a style="text-decoration: none;" href="https://xettuyen.tvu.edu.vn" target="_blank" class="mu-func-btn mu-func-btn-red">
          <span class="func-btn-icon"><i class="fa fa-paper-plane"></i></span>
          <span>Xét tuyển trực tuyến</span>
        </a>
        <a style="text-decoration: none;" href="{{ route('user.blogList') }}?category=7" class="mu-func-btn mu-func-btn-blue">
          <span class="func-btn-icon"><i class="fa fa-bar-chart"></i></span>
          <span>Tham khảo điểm trúng tuyển các năm</span>
        </a>
        <a style="text-decoration: none;" href="{{ route('user.admissionInfo') }}" class="mu-func-btn mu-func-btn-blue">
          <span class="func-btn-icon"><i class="fa fa-user"></i></span>
          <span>Thông tin xét tuyển</span>
        </a>
        <a style="text-decoration: none;" href="{{route('user.blogDetail', 22)}}" class="mu-func-btn mu-func-btn-blue">
          <span class="func-btn-icon"><i class="fa fa-file-text-o"></i></span>
          <span>Hướng dẫn hồ sơ & thủ tục nhập học</span>
        </a>
        <a style="text-decoration: none;" href="https://xettuyen.tvu.edu.vn/kqdhcdcq" target="_blank" class="mu-func-btn mu-func-btn-blue">
          <span class="func-btn-icon"><i class="fa fa-search"></i></span>
          <span>Tra cứu kết quả xét tuyển ĐHTV</span>
        </a>
      </div>
    </div>
    <style>
      #mu-functional-buttons {
        position: relative;
        min-height: 380px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url('/assets/img/tvu bckgrd 1.jpg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
      }
      .mu-bg-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.23); /* hoặc rgba(0,0,0,0.3) cho overlay tối */
        z-index: 1;
        pointer-events: none;
      }
      #mu-functional-buttons > .container {
        position: relative;
        z-index: 2;
        width: 100%;
        max-width: 1200px;
      }
      .mu-functional-btns-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 20px;
        justify-items: center;
        align-items: center;
        width: 100%;
        margin: 0 auto;
        padding: 0;
      }
      .mu-func-btn {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background: rgba(59,130,246,0.95);
        color: #fff;
        border-radius: 50px;
        font-weight: 500;
        font-size: 16px;
        padding: 10px 24px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.10);
        border: none;
        text-decoration: none;
        transition: background 0.2s, color 0.2s, box-shadow 0.2s, transform 0.15s;
        width: 100%;
        max-width: 350px;
        min-height: 50px;
        text-align: center;
        position: relative;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .mu-func-btn .func-btn-icon {
        font-size: 1.6em;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 4px;
        min-width: 24px;
      }
      .mu-func-btn-blue {
        background: rgba(59,130,246,0.95);
      }
      .mu-func-btn-blue:hover, .mu-func-btn-blue:focus {
        background: #2563eb;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59,130,246,0.13);
      }
      .mu-func-btn-red {
        background: #ef4444;
        color: #fff;
        box-shadow: 0 4px 15px rgba(239,68,68,0.13);
      }
      .mu-func-btn-red:hover, .mu-func-btn-red:focus {
        background: #dc2626;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239,68,68,0.18);
      }
      @media (max-width: 991px) {
        .mu-functional-btns-grid {
          grid-template-columns: repeat(2, 1fr);
          grid-template-rows: repeat(3, 1fr);
          gap: 15px;
        }
        .mu-func-btn {
          width: 100%;
          max-width: none;
          font-size: 14px;
          padding: 10px 15px;
        }
      }
      @media (max-width: 600px) {
        .mu-functional-btns-grid {
          grid-template-columns: 1fr;
          grid-template-rows: repeat(6, 1fr);
          gap: 10px;
        }
        .mu-func-btn {
          width: 100%;
          font-size: 14px;
          padding: 10px 15px;
        }
      }
    </style>
  </section>
  <!-- End functional buttons section -->
 
  <!-- Start service  -->
  <section id="mu-service">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="mu-service-area">
            <!-- Start single service -->
            <div class="mu-service-single">
              <span class="fa fa-book"></span>
              <h3>Dịch vụ Hỗ trợ sinh viên toàn diện</h3>
              <p> TVU cung cấp các dịch vụ hỗ trợ sinh viên như ký túc xá, tư vấn học tập, hướng nghiệp, hỗ trợ học bổng và vay vốn, giúp sinh viên yên tâm học tập và phát triển toàn diện trong suốt quá trình học.</p>
            </div>
            <!-- Start single service -->
            <!-- Start single service -->
            <div class="mu-service-single">
              <span class="fa fa-users"></span>
              <h3>Trung tâm Khởi nghiệp và Đổi mới sáng tạo</h3>
              <p>Là nơi hỗ trợ sinh viên, giảng viên và cộng đồng phát triển ý tưởng kinh doanh, nghiên cứu khoa học và kết nối với doanh nghiệp. Trung tâm tổ chức các cuộc thi khởi nghiệp, tập kỹ năng và hỗ trợ gọi vốn.</p>
            </div>
            <!-- Start single service -->
            <!-- Start single service -->
            <div class="mu-service-single">
              <span class="fa fa-table"></span>
              <h3>Bệnh viện Trường Đại học Trà Vinh</h3>
              <p>Cung cấp dịch vụ khám chữa bệnh cho cộng đồng và là nơi thực hành cho sinh viên ngành Y – Dược. Bệnh viện trang bị cơ sở vật chất hiện đại, phục vụ đào tạo và chăm sóc sức khỏe chất lượng cao.</p>
            </div>
            <!-- Start single service -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End service  -->

  <!-- Start about us -->
  <section id="mu-about-us">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-about-us-area">           
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="mu-about-us-left">
                  <!-- Start Title -->
                  <div class="mu-title">
                    <h2>Về Chúng Tôi</h2>              
                  </div>
                  <!-- End Title -->
                  <p style="line-height: 30px;">Đại học Trà Vinh (TVU) là trường đại học công lập đa ngành, hướng đến mô hình đại học cộng đồng, không vì lợi nhuận. TVU cam kết cung cấp môi trường học tập thực tiễn, gắn kết doanh nghiệp, thúc đẩy đổi mới sáng tạo và phục vụ cộng đồng, với mục tiêu đào tạo nguồn nhân lực chất lượng cao, đáp ứng yêu cầu phát triển bền vững của khu vực và cả nước.</p>
                </div>
              </div>
              <div class="col-lg-6 col-md-6">
                <div class="mu-about-us-right">  
                  <iframe id="mu-abtus-video" width="100%" height="371px" src="https://www.youtube.com/embed/Oldv1SoPS2M" title="Phim Trường Đại học Trà Vinh (Tháng 4/2025)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                  <!-- <a id="mu-abtus-video" href="" target="mutube-video">
                  <img width="100%" height="371px" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRRe55lGk6CCT_cZbknRzDEsVgTKmnP_eadCw&s" alt="img">
                </a>                 -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End about us -->
  <!-- Start about us counter -->
  <section id="mu-abtus-counter">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-abtus-counter-area">
            <div class="row">
               <!-- Start counter item -->
              <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="mu-abtus-counter-single">
                  <span class="fa fa-users"></span> <br><br>
                  <p>Hơn</p>
                  <b><h4 class="counter">20.000</h4></b>
                  <p>Sinh Viên</p>
                </div>
              </div>
              <!-- End counter item -->
              <!-- Start counter item -->
              <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="mu-abtus-counter-single">
                  <span class="fa fa-book"></span> 
                  
                  <h4 class="counter">55</h4>
                  <p>Ngành bậc đại học</p>
                </div>
              </div>
              <!-- End counter item -->
              
               <!-- Start counter item -->
              <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="mu-abtus-counter-single ">
                  <span class="fa fa-users"></span> <br><br>
                  <p>Hơn</p>
                  <h4 class="counter">1.200</h4>
                  <p>Giảng viên</p>
                </div>
              </div>
              <!-- End counter item -->
              <!-- Start counter item -->
              <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="mu-abtus-counter-single no-border">
                  <span class="fa fa-flask"></span>
                  <h4 class="counter">19</h4>
                  <p>Năm đào tạo</p>
                </div>
              </div>
              <!-- End counter item -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- End about us counter -->
  <!-- Start features section -->
  <section id="mu-features">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="mu-features-area">
            <!-- Start Title -->
            <div class="mu-title">
              <h2>Các ngành học nổi bật của chúng tôi</h2>
              <p>Trường Đại học Trà Vinh (TVU) hiện đào tạo đa dạng các ngành học thuộc các lĩnh vực như: Kinh tế, Luật, Ngôn ngữ, Văn hóa, Y Dược, Kỹ thuật, Công nghệ, Nông nghiệp, Thủy sản, và nhiều ngành khác. Các chương trình đào tạo được thiết kế nhằm đáp ứng nhu cầu phát triển nguồn nhân lực chất lượng cao cho khu vực Đồng bằng sông Cửu Long và cả nước.</p>
            </div>
            <!-- End Title -->
            <!-- Start features content -->
            <div class="mu-features-content">
              <div class="row">
                @foreach ( $dataMajor as $item )
                <div style="text-align: center;" class="col-lg-4 col-md-4  col-sm-6">
                  <div class="mu-single-feature">
                    <span class="fa fa-book"></span>
                    <div class="tinhchinh">
                    <h4>{{ Str::limit($item->name_major, 38) }}</h4>
                    </div>
                    <p class="text-limit">{{ Str::limit($item->description_major, 80)}}</p>
                    <a href="{{ route('user.majorDetail', ['id' => $item->id]) }}" class="detail-button">
                        XEM CHI TIẾT  
                    </a>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            
            <div class="view-all-button-container" style="display: flex;justify-content:center">
              <a class="view-all-button" href="{{route('user.majorList')}}">
                <i class="fa fa-arrow-right"></i> &nbsp;XEM TẤT CẢ
              </a>
            </div>
            <!-- End features content -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <section id="mu-regis">
    <div class="form-container">
      <h4 style="font-weight: bold;">Đăng ký tư vấn ngành học</h4>
      <form id="registrationForm" action="{{route('user.questionRequest')}}" method="POST">
        @csrf
        <div class="form-group">
          <label for="fullName">Họ và tên</label>
          <input type="text" class="form-control" name="name_request" id="fullName" required>
          <div class="error" id="fullNameError"></div>
        </div>
  
        <div class="form-group">
          <label for="phone">Số điện thoại</label>
          <input type="text" class="form-control" name="phone_request" id="phone" maxlength="10" required>
          <div class="error" id="phoneError"></div>
        </div>
  
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email_request" id="email" required>
          <div class="error" id="emailError"></div>
        </div>
  
        <div class="form-group">
          <label for="dob">Ngày sinh</label>
          <input type="date" class="form-control" name="birth" id="dob" required>
          <div class="error" id="dobError"></div>
        </div>
  
        <div class="form-group">
          <label for="city">Thành phố hiện tại</label>
          <select class="form-control" name="city_id" id="city" required>
            @foreach ($dataCity as $item)
              <option value="{{$item->id}}">{{$item->name_city}}</option>
            @endforeach
          </select>
          <div class="error" id="cityError"></div>
        </div>
  
        <div class="form-group">
          <label for="major">Ngành học quan tâm</label>
          <select class="form-control" name="major_id" id="major" required>
             @foreach ($dataMajorAll as $item)
              <option value="{{$item->id}}">{{$item->name_major}}</option>
            @endforeach
          </select>
          <div class="error" id="majorError"></div>
        </div>
  
        <div class="form-group">
          <label for="highschool">Trường THPT đã học</label>
          <input type="text" class="form-control" name="school" id="highschool" required>
          <div class="error" id="highschoolError"></div>
        </div>
  
        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
      </form>
    </div>
  <div class="form-description">
    <h4 style="font-weight: bold;">Hướng dẫn điền thông tin</h4>
    <p>Hãy điền đầy đủ thông tin vào form đăng ký dưới đây để nhận tư vấn về ngành học phù hợp với sở thích và năng lực của bạn. Chúng tôi sẽ hỗ trợ bạn tìm hiểu về các ngành học phổ biến, giúp bạn đưa ra quyết định đúng đắn cho tương lai học tập. Các thông tin bạn cần cung cấp bao gồm:</p>
    <ol>
      <li>Họ và tên: Điền đầy đủ họ tên của bạn.</li>
      <li>Số điện thoại: Cung cấp số điện thoại liên hệ để chúng tôi có thể hỗ trợ bạn nhanh chóng.</li>
      <li>Email: Địa chỉ email của bạn để chúng tôi gửi thông tin tư vấn và các tài liệu liên quan.</li>
      <li>Ngày sinh: Cung cấp ngày sinh để xác định độ tuổi và giai đoạn học tập của bạn.</li>
      <li>Thành phố hiện tại: Cho chúng tôi biết nơi bạn đang sống để tư vấn cho phù hợp với địa phương.</li>
      <li>Ngành học quan tâm: Lựa chọn ngành học mà bạn đang quan tâm, ví dụ như Công nghệ thông tin, Kinh doanh, Y tế, Kỹ thuật,...</li>
      <li>Trường THPT đã học: Cho biết tên trường THPT bạn đã học để chúng tôi hiểu rõ hơn về nền tảng học vấn của bạn.</li>
    </ol>
    <p>Sau khi hoàn tất đăng ký, chúng tôi sẽ liên hệ và cung cấp thông tin tư vấn chi tiết về ngành học bạn chọn. Hãy chắc chắn điền đúng và đầy đủ các thông tin yêu cầu để nhận được sự hỗ trợ tốt nhất.
    </p>
  </div>
  </section>
  <!-- End features section -->
  <!-- Start from blog -->
  <section id="mu-from-blog">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-from-blog-area">
            <!-- start title -->
            <div class="mu-title">
              <h2>Các bài viết gần đây</h2>
              <p>Khám phá những bài viết, sáng tác và cảm nhận từ sinh viên, giảng viên và cộng đồng TVU. Các bài viết này phản ánh những khoảnh khắc đáng nhớ, tình cảm gắn bó với mái trường, cũng như những đóng góp tích cực của TVU trong giáo dục, nghiên cứu và phục vụ cộng đồng. Đây là nơi lưu giữ những câu chuyện truyền cảm hứng, kỷ niệm đáng nhớ và những sáng tác nghệ thuật đặc sắc, góp phần khẳng định giá trị văn hóa và sứ mệnh của trường</p>
            </div>
            <!-- end title -->  
            <!-- start from blog content   -->
            <div class="mu-from-blog-content">
              <div class="row">
                @foreach ( $dataBlog as $item )
                <div class="col-md-4 col-sm-4">
                  <article class="mu-blog-single-item">
                    <figure class="mu-blog-single-img">
                      <a href="{{ route('user.blogDetail', ['id' => $item->id]) }}"><img width="100%" height="200px" src="{{$item->image_blog}}" alt="img"></a>
                      <figcaption class="mu-blog-caption">
                        <h3><a style="text-decoration: none; color:rgb(59, 59, 59);" href="{{ route('user.blogDetail', ['id' => $item->id]) }}"> {{ Str::limit($item->name_blog, 25) }} </a></h3>
                      </figcaption>                      
                    </figure>
                    <div class="mu-blog-meta">                 
                      <a style="text-decoration:none; color: #333333;" ><i class="fa fa-user"></i> {{$item->author_name}}</a>
                      <a style="text-decoration:none; color: #333333;"><i class="fa fa-calendar"></i> {{date('d/m/Y', strtotime($item->date_blog))}}</a>
                      <span><i class="fa fa-eye"></i> {{$item->view_blog}} lượt xem</span>                     
                    </div>
                    <div class="mu-blog-meta">
                      <a href="{{ route('user.blogList') }}?category={{ $item->name_category_blog }}">Chủ đề: {{$item->name_category_blog}}</a> 
                    </div>
                    
                  </article>
                </div>
                @endforeach
              </div>
            </div>     
            <div class="view-all-button-container" style="display: flex;justify-content:center">
              <a class="view-all-button" href="{{route('user.blogList')}}">
                <i class="fa fa-arrow-right"></i> &nbsp;XEM TẤT CẢ
              </a>
            </div>
            <!-- end from blog content   -->   
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
