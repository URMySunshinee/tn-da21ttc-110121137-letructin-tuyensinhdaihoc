@extends('user.layout')
@section('title', 'Giới thiệu về Trường Đại học Trà Vinh')
@section('content')
<div style=" width: 100%; clear: both;"></div>
<style>
  /* CSS cho trang giới thiệu */
  .about-hero {
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://ddk.1cdn.vn/2024/09/20/dai-hoc-tra-vinh.jpg');
    background-size: cover;
    background-position: center;
    padding: 120px 0;
    color: #fff;
    text-align: center;
    position: relative;
    margin-bottom: 50px;
  }

  .about-hero h1 {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  .about-hero p {
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
  }

  .about-section {
    padding: 60px 0;
  }

  .section-title {
    text-align: center;
    margin-bottom: 50px;
  }

  .section-title h2 {
    font-size: 36px;
    font-weight: 700;
    color: #2563eb;
    position: relative;
    padding-bottom: 15px;
    margin-bottom: 20px;
  }

  .section-title h2:after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background-color: #2563eb;
  }

  .section-title p {
    max-width: 800px;
    margin: 0 auto;
    color: #555;
    font-size: 16px;
    line-height: 1.6;
  }

  .about-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 5px 30px rgba(0,0,0,0.07);
    padding: 30px;
    margin-bottom: 30px;
    transition: all 0.3s ease;
  }

  .about-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.12);
  }

  .about-card-icon {
    font-size: 48px;
    color: #2563eb;
    margin-bottom: 20px;
  }

  .about-card h3 {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #333;
  }

  .about-card p {
    color: #666;
    margin-bottom: 0;
    line-height: 1.7;
  }

  .timeline {
    position: relative;
    padding: 30px 0;
  }

  .timeline:before {
    content: '';
    position: absolute;
    width: 3px;
    background: #2563eb;
    top: 0;
    bottom: 0;
    left: 50%;
    margin-left: -1.5px;
  }

  .timeline-item {
    margin-bottom: 60px;
    position: relative;
  }

  .timeline-item:after {
    content: "";
    display: table;
    clear: both;
  }

  .timeline-year {
    background: #2563eb;
    color: white;
    width: 120px;
    text-align: center;
    padding: 10px 0;
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 5px;
    font-weight: 700;
    z-index: 1;
  }

  .timeline-content {
    position: relative;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    width: 45%;
    padding: 30px;
  }

  .timeline-content h3 {
    margin-top: 0;
    font-size: 20px;
    font-weight: 600;
    color: #333;
  }

  .timeline-content p {
    margin-bottom: 0;
    color: #666;
    line-height: 1.6;
  }

  .timeline-item:nth-child(odd) .timeline-content {
    float: right;
  }

  .timeline-item:nth-child(even) .timeline-content {
    float: left;
  }

  .timeline-content:before {
    content: '';
    position: absolute;
    top: 20px;
    width: 20px;
    height: 20px;
    background: #2563eb;
    border-radius: 50%;
  }

  .timeline-item:nth-child(odd) .timeline-content:before {
    left: -60px;
  }

  .timeline-item:nth-child(even) .timeline-content:before {
    right: -60px;
  }

  .stat-box {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 40px 20px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
  }

  .stat-box:hover {
    background: #2563eb;
    color: white;
    transform: translateY(-5px);
  }

  .stat-box:hover .stat-number, 
  .stat-box:hover .stat-text {
    color: white;
  }

  .stat-icon {
    font-size: 48px;
    color: #2563eb;
    margin-bottom: 15px;
    transition: all 0.3s ease;
  }

  .stat-box:hover .stat-icon {
    color: white;
  }

  .stat-number {
    font-size: 36px;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    transition: all 0.3s ease;
  }

  .stat-text {
    font-size: 18px;
    color: #555;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .team-member {
    text-align: center;
    margin-bottom: 40px;
  }

  .team-member-img {
    width: 180px;
    height: 180px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 20px;
    border: 5px solid #f0f0f0;
    transition: all 0.3s ease;
  }

  .team-member:hover .team-member-img {
    border-color: #2563eb;
    transform: scale(1.05);
  }

  .team-member-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .team-member-name {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
  }

  .team-member-title {
    color: #2563eb;
    font-weight: 500;
    font-size: 16px;
    margin-bottom: 15px;
  }

  .team-member-bio {
    color: #666;
    line-height: 1.6;
    max-width: 300px;
    margin: 0 auto;
  }

  .testimonial {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    position: relative;
    transition: all 0.3s ease;
  }

  .testimonial:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
  }

  .testimonial:before {
    content: '\201C';
    font-size: 80px;
    position: absolute;
    top: -20px;
    left: 20px;
    color: #2563eb;
    opacity: 0.1;
    font-family: Georgia, serif;
  }

  .testimonial-content {
    font-style: italic;
    color: #555;
    margin-bottom: 20px;
    line-height: 1.7;
  }

  .testimonial-name {
    font-weight: 600;
    color: #333;
    font-size: 18px;
    margin-bottom: 5px;
  }

  .testimonial-title {
    color: #777;
    font-size: 14px;
  }

  .testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
    border: 2px solid #2563eb;
  }

  .testimonial-footer {
    display: flex;
    align-items: center;
  }

  .cta-section {
    background: linear-gradient(90deg, #2563eb 0%, #1d4ed8 100%);
    color: white;
    padding: 80px 0;
    text-align: center;
    border-radius: 10px;
    margin: 40px 0;
  }

  .cta-title {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 20px;
  }

  .cta-text {
    font-size: 18px;
    max-width: 700px;
    margin: 0 auto 30px;
    line-height: 1.6;
  }

  .cta-btn {
    display: inline-block;
    background-color: white;
    color: #2563eb;
    padding: 15px 35px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  }

  .cta-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    background-color: #f8f9fa;
  }

  @media (max-width: 992px) {
    .timeline:before {
      left: 60px;
    }

    .timeline-year {
      left: 60px;
      transform: translateX(-50%);
    }

    .timeline-content {
      width: 80%;
      float: right;
      margin-left: 100px;
    }

    .timeline-item:nth-child(even) .timeline-content {
      float: right;
    }

    .timeline-item:nth-child(odd) .timeline-content:before,
    .timeline-item:nth-child(even) .timeline-content:before {
      left: -50px;
      right: auto;
    }
  }

  @media (max-width: 767px) {
    .about-hero h1 {
      font-size: 32px;
    }

    .section-title h2 {
      font-size: 28px;
    }
  }
</style>

<div class="about-hero">
  <div class="container">
    <h1>Trường Đại học Trà Vinh</h1>
    <p>Mang đến cơ hội học tập chất lượng cho cộng đồng</p>
    <p>Tận tâm - Minh bạch - Sáng tạo - Thân thiện</p>
  </div>
</div>

<section class="about-section">
  <div class="container">
    <div class="section-title">
      <h2>Giới thiệu chung</h2>
      <p>Trường Đại học Trà Vinh là cơ sở giáo dục đào tạo đa ngành, đa lĩnh vực, với chất lượng và môi trường học tập hiện đại, đáp ứng nhu cầu phát triển kinh tế - xã hội của vùng Đồng bằng sông Cửu Long và cả nước.</p>
    </div>
    
    <div class="row">
      <div class="col-lg-6">
        <p>Trường Đại học Trà Vinh (TVU) được thành lập theo Quyết định số 141/QĐ-TTg ngày 08/07/2006 của Thủ tướng Chính phủ, trên cơ sở nâng cấp Trường Cao đẳng Cộng đồng Trà Vinh.</p>
        
        <p>Qua hơn 15 năm xây dựng và phát triển, Trường Đại học Trà Vinh đã trở thành một trung tâm đào tạo, nghiên cứu khoa học và chuyển giao công nghệ có uy tín tại khu vực Đồng bằng sông Cửu Long. Trường được xây dựng theo mô hình đại học đa ngành, đa lĩnh vực với phương châm học đi đôi với hành, lý thuyết gắn với thực tiễn.</p>
        
        <p>Hiện nay, Trường đang đào tạo 55 ngành bậc đại học thuộc các khối ngành Khoa học Sức khỏe, Kỹ thuật - Công nghệ, Kinh tế - Quản trị, Nông nghiệp, Ngôn ngữ - Văn hóa - Xã hội, và các ngành đào tạo sau đại học. Trường đã và đang không ngừng đổi mới, nâng cao chất lượng đào tạo, mở rộng quan hệ hợp tác quốc tế nhằm mang đến cho người học những kiến thức và kỹ năng cần thiết đáp ứng nhu cầu của xã hội.</p>
      </div>
      
      <div class="col-lg-6">
        <img src="/assets/img/tvu bckgrd 1.jpg" class="img-fluid rounded shadow" alt="Trường Đại học Trà Vinh">
        <div class="row mt-4">
          <div class="col-md-6">
            <img src="/assets/img/tvu bckgrd 1.jpg" class="img-fluid rounded shadow mb-4" alt="Cơ sở vật chất">
          </div>
          <div class="col-md-6">
            <img src="/assets/img/tvu bckgrd 1.jpg" class="img-fluid rounded shadow" alt="Hoạt động sinh viên">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section bg-light">
  <div class="container">
    <div class="section-title">
      <h2>Sứ mệnh - Tầm nhìn - Giá trị cốt lõi</h2>
    </div>
    
    <div class="row">
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-globe"></i>
          </div>
          <h3>Sứ mệnh</h3>
          <p>Trường Đại học Trà Vinh có sứ mệnh đào tạo nguồn nhân lực chất lượng cao, phát triển khoa học công nghệ, chuyển giao tri thức và cung cấp các dịch vụ phục vụ sự phát triển kinh tế - xã hội bền vững cho khu vực Đồng bằng sông Cửu Long và cả nước.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-eye"></i>
          </div>
          <h3>Tầm nhìn</h3>
          <p>Đến năm 2030, Trường Đại học Trà Vinh trở thành trường đại học thông minh, xanh, sạch, đẹp, thân thiện với môi trường; là trung tâm đào tạo, nghiên cứu khoa học, ứng dụng và chuyển giao công nghệ có uy tín trong nước và quốc tế.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-heart"></i>
          </div>
          <h3>Giá trị cốt lõi</h3>
          <p>Chất lượng - Phát triển - Hội nhập<br>
          Đoàn kết - Tận tâm - Sáng tạo<br>
          Trách nhiệm - Chia sẻ - Cộng đồng</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section">
  <div class="container">
    <div class="section-title">
      <h2>Lịch sử phát triển</h2>
      <p>Hành trình xây dựng và phát triển của Trường Đại học Trà Vinh</p>
    </div>
    
    <div class="timeline">
      <div class="timeline-item">
        <div class="timeline-year">1992</div>
        <div class="timeline-content">
          <h3>Trung tâm Dạy nghề - Dịch vụ giải quyết việc làm Trà Vinh 21/10/1992</h3>
          
        </div>
      </div>

      <div class="timeline-item">
        <div class="timeline-year">2001</div>
        <div class="timeline-content">
          <h3>Thành lập Trường Cao đẳng Cộng đồng Trà Vinh</h3>
          <p>Tiền thân của Trường Đại học Trà Vinh là Trường Cao đẳng Cộng đồng Trà Vinh, được thành lập theo Quyết định số 301/QĐ-BGD&ĐT-TCCB ngày 24/01/2001.</p>
          <br><p>Tiền thân của Trường Đại học Trà Vinh là Trường Cao đẳng Cộng đồng Trà Vinh.</p>
        </div>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2006</div>
        <div class="timeline-content">
          <h3>Thành lập Trường Đại học Trà Vinh</h3>
          <p>Ngày 08/07/2006, Thủ tướng Chính phủ đã ký Quyết định số 141/QĐ-TTg thành lập Trường Đại học Trà Vinh trên cơ sở nâng cấp Trường Cao đẳng Cộng đồng Trà Vinh.</p>
        </div>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2010</div>
        <div class="timeline-content">
          <h3>Thành lập Bệnh viện Đại học Trà Vinh</h3>
          <p>Bệnh viện Trường Đại học Trà Vinh được thành lập, trở thành cơ sở thực hành cho sinh viên khối ngành sức khỏe và phục vụ chăm sóc sức khỏe cho cộng đồng.</p>
        </div>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2015</div>
        <div class="timeline-content">
          <h3>Mở rộng quy mô đào tạo</h3>
          <p>Trường đạt chuẩn kiểm định chất lượng giáo dục quốc gia và mở rộng quy mô đào tạo với hơn 40 ngành bậc đại học và các ngành sau đại học.</p>
        </div>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2020</div>
        <div class="timeline-content">
          <h3>Chuyển đổi số và phát triển bền vững</h3>
          <p>Triển khai chiến lược chuyển đổi số toàn diện, phát triển mô hình đại học thông minh, ứng dụng công nghệ trong quản lý và đào tạo.</p>
        </div>
      </div>
      
      <div class="timeline-item">
        <div class="timeline-year">2025</div>
        <div class="timeline-content">
          <h3>Hướng tới đại học quốc tế</h3>
          <p>Củng cố và nâng cao chất lượng đào tạo, tiếp tục mở rộng quan hệ hợp tác quốc tế, hướng đến các chuẩn mực quốc tế trong giáo dục đại học.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section bg-light">
  <div class="container">
    <div class="section-title">
      <h2>Trường Đại học Trà Vinh bằng con số</h2>
    </div>
    
    <div class="row">
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-graduation-cap"></i>
          </div>
          <div class="stat-number">55+</div>
          <div class="stat-text">Ngành đào tạo đại học</div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-users"></i>
          </div>
          <div class="stat-number">20,000+</div>
          <div class="stat-text">Sinh viên đang theo học</div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-book"></i>
          </div>
          <div class="stat-number">1,200+</div>
          <div class="stat-text">Cán bộ, giảng viên</div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-globe"></i>
          </div>
          <div class="stat-number">50+</div>
          <div class="stat-text">Đối tác quốc tế</div>
        </div>
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-flask"></i>
          </div>
          <div class="stat-number">100+</div>
          <div class="stat-text">Đề tài nghiên cứu khoa học</div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-building"></i>
          </div>
          <div class="stat-number">12</div>
          <div class="stat-text">Khoa đào tạo</div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-certificate"></i>
          </div>
          <div class="stat-number">85%</div>
          <div class="stat-text">Tỷ lệ sinh viên có việc làm</div>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="stat-box">
          <div class="stat-icon">
            <i class="fa fa-trophy"></i>
          </div>
          <div class="stat-number">19</div>
          <div class="stat-text">Năm phát triển</div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section">
  <div class="container">
    <div class="section-title">
      <h2>Cơ sở vật chất</h2>
      <p>Trường Đại học Trà Vinh đầu tư cơ sở vật chất hiện đại, đáp ứng nhu cầu học tập, nghiên cứu và sinh hoạt của sinh viên</p>
    </div>
    
    <div class="row">
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-building"></i>
          </div>
          <h3>Khu giảng đường</h3>
          <p>Trường có 4 cơ sở đào tạo chính với hơn 200 phòng học được trang bị hiện đại, đầy đủ thiết bị hỗ trợ giảng dạy như máy chiếu, âm thanh, ánh sáng, điều hòa nhiệt độ, đảm bảo môi trường học tập thoải mái cho sinh viên.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-flask"></i>
          </div>
          <h3>Phòng thí nghiệm</h3>
          <p>Hệ thống phòng thí nghiệm, xưởng thực hành được trang bị hiện đại, đáp ứng yêu cầu đào tạo và nghiên cứu của tất cả các ngành học. Các phòng thí nghiệm đều được đầu tư các trang thiết bị tiên tiến, phục vụ tốt cho việc thực hành của sinh viên.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-book"></i>
          </div>
          <h3>Thư viện</h3>
          <p>Thư viện Trường với diện tích hơn 11.000 m², được trang bị hệ thống tra cứu hiện đại, kho tài liệu phong phú với hơn 50.000 đầu sách và tài liệu điện tử, kết nối với các cơ sở dữ liệu học thuật quốc tế, tạo điều kiện học tập và nghiên cứu tốt nhất cho sinh viên.</p>
        </div>
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-home"></i>
          </div>
          <h3>Ký túc xá</h3>
          <p>Hệ thống ký túc xá khép kín với sức chứa 5.000 chỗ ở, đầy đủ tiện nghi sinh hoạt như điều hòa, nóng lạnh, internet, khu vực nấu ăn, khu vực giặt giũ, phòng sinh hoạt chung, đảm bảo an ninh và an toàn cho sinh viên nội trú.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-futbol-o"></i>
          </div>
          <h3>Khu thể thao</h3>
          <p>Khu thể thao rộng lớn với sân vận động, nhà thi đấu đa năng, sân bóng đá mini, sân tennis, cầu lông, bóng chuyền... phục vụ nhu cầu rèn luyện thể chất và hoạt động ngoại khóa của sinh viên.</p>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="about-card">
          <div class="about-card-icon">
            <i class="fa fa-plus-square"></i>
          </div>
          <h3>Bệnh viện Đại học</h3>
          <p>Bệnh viện Trường Đại học Trà Vinh là cơ sở thực hành cho sinh viên khối ngành sức khỏe, đồng thời phục vụ chăm sóc sức khỏe cho cộng đồng với trang thiết bị y tế hiện đại và đội ngũ y, bác sĩ chuyên nghiệp.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section bg-light">
  <div class="container">
    <div class="section-title">
      <h2>Ban lãnh đạo trường</h2>
    </div>
    
    <div class="row">
      <div class="col-md-3">
        <div class="team-member">
          <div class="team-member-img">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVeFtdrtygs7VpTn0n3Np2L777n9KcC6uA2w&s" alt="Hiệu trưởng">
          </div>
          <h4 class="team-member-name">PGS.TS. Nguyễn Minh Hòa</h4>
          <div class="team-member-title">Phó bí thư Đảng ủy</div>
          <div class="team-member-title">Hiệu trưởng</div>
          <p class="team-member-bio">Tiến sĩ Quản lý Giáo dục, 25 năm kinh nghiệm trong lĩnh vực giáo dục đại học.</p>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="team-member">
          <div class="team-member-img">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSKPUEtXYSMrNQ-jTW5RvN9uq7qER_Qcn9_C5b__DD6z5G4NdrnocQEyOSsNr3sGhLBYPg&usqp=CAU" alt="Phó Hiệu trưởng">
          </div>
          <h4 class="team-member-name">PGS.TS. Diệp Thanh Tùng</h4>
          <div class="team-member-title">Đảng ủy viên</div>
          <div class="team-member-title">Phó Hiệu trưởng</div>
          <p class="team-member-bio">Phụ trách đào tạo và công tác sinh viên, chuyên gia về phát triển chương trình đào tạo theo chuẩn quốc tế.</p>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="team-member">
          <div class="team-member-img">
            <img src="https://www.tvu.edu.vn/wp-content/uploads/2023/01/IMG_1127-scaled.jpg" alt="Phó Hiệu trưởng">
          </div>
          <h4 class="team-member-name">TS. Thạch Thị Dân</h4>
          <div class="team-member-title">Thường vụ Đảng ủy</div>
          <div class="team-member-title">Phó Hiệu trưởng</div>
          <p class="team-member-bio">Phụ trách nghiên cứu khoa học và hợp tác quốc tế, chuyên gia về khoa học công nghệ.</p>
        </div>
      </div>
      
      <div class="col-md-3">
        <div class="team-member">
          <div class="team-member-img">
            <img src="https://www.tvu.edu.vn/wp-content/uploads/2023/06/IMG_5412.jpg" alt="Phó Hiệu trưởng">
          </div>
          <h4 class="team-member-name">TS. Phan Quốc Nghĩa</h4>
          <div class="team-member-title">Đảng ủy viên</div>
          <div class="team-member-title">Phó Hiệu trưởng</div>
          <p class="team-member-bio">Phụ trách cơ sở vật chất và tài chính, chuyên gia về quản lý tài chính trong giáo dục.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="about-section">
  <div class="container">
    <div class="section-title">
      <h2>Cảm nhận của sinh viên và cựu sinh viên</h2>
    </div>
    
    <div class="row">
      <div class="col-md-6">
        <div class="testimonial">
          <p class="testimonial-content">"Tôi đã tốt nghiệp khoa Kinh tế của Trường Đại học Trà Vinh năm 2022. Kiến thức và kỹ năng tôi học được từ trường đã giúp tôi có được việc làm tốt và thăng tiến trong sự nghiệp. Trường có môi trường học tập thân thiện, giảng viên tận tâm và nhiều cơ hội thực tập tại các doanh nghiệp lớn."</p>
          <div class="testimonial-footer">
            <img src="https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar" class="testimonial-avatar">
            <div>
              <div class="testimonial-name">Nguyễn Thanh Tùng</div>
              <div class="testimonial-title">Cựu sinh viên khoa Kinh tế - Khóa 2018-2022</div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="testimonial">
          <p class="testimonial-content">"Tôi đang là sinh viên năm 3 khoa Công nghệ Thông tin. Điều tôi ấn tượng nhất về Trường Đại học Trà Vinh là cơ sở vật chất hiện đại và các chương trình thực tập thực tế. Trường thường xuyên tổ chức các khóa đào tạo kỹ năng mềm, hội thảo chuyên ngành và cuộc thi học thuật giúp sinh viên phát triển toàn diện."</p>
          <div class="testimonial-footer">
            <img src="https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar" class="testimonial-avatar">
            <div>
              <div class="testimonial-name">Trần Minh Anh</div>
              <div class="testimonial-title">Sinh viên khoa CNTT - Khóa 2021-2025</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="row mt-4">
      <div class="col-md-6">
        <div class="testimonial">
          <p class="testimonial-content">"Học tại Khoa Y - Dược của Trường Đại học Trà Vinh là quyết định đúng đắn của tôi. Trường có Bệnh viện thực hành hiện đại giúp sinh viên được tiếp xúc với môi trường y tế thực tế. Giảng viên giàu kinh nghiệm và các chuyên gia y tế là những người truyền cảm hứng và định hướng nghề nghiệp cho tôi."</p>
          <div class="testimonial-footer">
            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=464&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar" class="testimonial-avatar">
            <div>
              <div class="testimonial-name">Lê Thị Hồng</div>
              <div class="testimonial-title">Sinh viên khoa Y - Khóa 2022-2028</div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-md-6">
        <div class="testimonial">
          <p class="testimonial-content">"Tôi là sinh viên quốc tế đến từ Campuchia. Tôi chọn học tại Trường Đại học Trà Vinh vì chương trình đào tạo chất lượng và học phí hợp lý. Môi trường học tập thân thiện, đa văn hóa và có nhiều hoạt động ngoại khóa giúp tôi nhanh chóng hòa nhập và phát triển các kỹ năng cần thiết."</p>
          <div class="testimonial-footer">
            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=387&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Avatar" class="testimonial-avatar">
            <div>
              <div class="testimonial-name">Sothea Kimhour</div>
              <div class="testimonial-title">Sinh viên quốc tế - Khóa 2023-2027</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="cta-section">
  <div class="container">
    <h2 class="cta-title">Bạn đã sẵn sàng cho tương lai?</h2>
    <p class="cta-text">Hãy cùng Trường Đại học Trà Vinh khám phá tiềm năng và xây dựng tương lai thành công của bạn. Đăng ký tư vấn tuyển sinh ngay hôm nay!</p>
    <a href="{{ route('user.admissionInfo') }}" class="cta-btn">Xem thông tin tuyển sinh</a>
    <a href="{{ route('user.home') }}#mu-regis" class="cta-btn ml-3" style="margin-left: 15px;">Đăng ký tư vấn</a>
  </div>
</div>

<script>
  // Hiệu ứng đếm số
  document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 200;
    
    const observerOptions = {
      threshold: 0.5
    };
    
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const counter = entry.target;
          const target = parseInt(counter.innerText.replace(/[^\d]/g, ''));
          let count = 0;
          const updateCount = () => {
            const increment = target / speed;
            if (count < target) {
              count += increment;
              counter.innerText = Math.ceil(count) + (counter.innerText.includes('+') ? '+' : '');
              setTimeout(updateCount, 1);
            } else {
              counter.innerText = target + (counter.innerText.includes('+') ? '+' : '');
            }
          };
          updateCount();
          observer.unobserve(counter);
        }
      });
    }, observerOptions);
    
    counters.forEach(counter => {
      observer.observe(counter);
    });
    
    // Hiệu ứng hiện timeline khi scroll
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    const timelineObserver = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = 1;
          entry.target.style.transform = 'translateX(0)';
          timelineObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.2 });
    
    timelineItems.forEach(item => {
      item.style.opacity = 0;
      item.style.transform = item.querySelector('.timeline-content').classList.contains('right') ? 'translateX(-50px)' : 'translateX(50px)';
      item.style.transition = 'all 0.5s ease';
      timelineObserver.observe(item);
    });
  });
</script>


@endsection
