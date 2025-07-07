@extends('user.layout')
@section('title', 'Thông tin xét tuyển')
@section('content')
<style>
  /* CSS cho trang thông tin xét tuyển */
  /* Fix whitespace at top */
  body, html {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
  }

  main {
    margin-top: 0 !important;
    padding-top: 0 !important;
    display: block;
  }

  /* Reset spacing for header elements */
  #mu-header, #mu-menu {
    margin-bottom: 0 !important;
  }
  
  /* Eliminate any potential spacing between header and content */
  section {
    margin-top: 0;
    padding-top: 0;
  }
  
  .admission-info-container {
    background-color: #fff;
    padding: 40px 0;
    margin: 0 0 30px 0; /* Remove top margin, keep bottom margin */
  }

  .admission-info-header {
    text-align: center;
    margin-bottom: 40px;
    color: #2563eb;
  }

  .admission-info-content {
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    padding: 30px;
    margin-bottom: 40px;
  }

  .school-code {
    font-size: 1.2rem;
    margin: 10px 0;
    text-align: center;
  }

  .admission-note {
    font-style: italic;
    text-align: center;
    color: #6b7280;
    margin-bottom: 30px;
  }

  .accordion-item {
    border-left: 4px solid #2563eb;
    margin-bottom: 20px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    background-color: #fff;
    transition: all 0.3s ease;
  }
  
  /* Hiệu ứng hover cho accordion item */
  .accordion-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
  }

  .accordion-header {
    background-color: #f8f9fa;
    padding: 15px 20px;
    cursor: pointer;
    border-top-right-radius: 8px;
    position: relative;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.3s ease;
  }
  
  /* Hiệu ứng hover cho header */
  .accordion-header:hover {
    background-color: #edf2fd;
  }

  .accordion-header h3 {
    margin: 0;
    font-size: 18px;
    color: #444;
    display: flex;
    align-items: center;
    transition: color 0.3s ease;
  }
  
  /* Hiệu ứng hover cho tiêu đề */
  .accordion-header:hover h3 {
    color: #2563eb;
  }

  .accordion-header h3:before {
    content: '>';
    margin-right: 10px;
    color: #2563eb;
    font-weight: bold;
    display: inline-block;
    width: 20px;
    text-align: center;
    transition: transform 0.3s ease;
  }
  
  /* Hiệu ứng xoay mũi tên khi hover */
  .accordion-header:hover h3:before {
    transform: translateX(5px);
  }
  
  /* Hiệu ứng xoay mũi tên khi mở accordion */
  .accordion-header.active h3:before {
    transform: rotate(90deg);
  }

  .accordion-content {
    padding: 20px;
    display: none;
    background-color: #fff;
    transition: all 0.5s ease;
    opacity: 0;
    max-height: 0;
    overflow: hidden;
  }

  .accordion-content.show {
    display: block;
    opacity: 1;
    max-height: 2000px; /* Giá trị đủ lớn để hiển thị hết nội dung */
  }

  .accordion-content p {
    margin-bottom: 15px;
    line-height: 1.6;
  }

  .accordion-content ul {
    padding-left: 20px;
    margin-bottom: 15px;
  }

  .accordion-content li {
    margin-bottom: 10px;
  }

  .important-note {
    background-color: #ffedd5;
    border-left: 4px solid #f97316;
    padding: 15px;
    margin: 15px 0;
    border-radius: 4px;
    transition: all 0.3s ease;
  }
  
  /* Hiệu ứng hover cho note */
  .important-note:hover {
    background-color: #fff7ed;
    box-shadow: 0 2px 8px rgba(249, 115, 22, 0.2);
  }

  .timeline {
    margin: 30px 0;
    position: relative;
    padding-left: 30px;
  }

  .timeline:before {
    content: '';
    position: absolute;
    left: 10px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #2563eb;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 30px;
    transition: all 0.3s ease;
  }
  
  /* Hiệu ứng hover cho timeline item */
  .timeline-item:hover {
    transform: translateX(5px);
  }

  .timeline-item:before {
    content: '';
    position: absolute;
    left: -30px;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #2563eb;
    background: #fff;
    transition: all 0.3s ease;
  }
  
  /* Hiệu ứng hover cho timeline dot */
  .timeline-item:hover:before {
    background: #2563eb;
    transform: scale(1.2);
  }

  .timeline-date {
    font-weight: bold;
    margin-bottom: 10px;
    color: #2563eb;
  }
  
  /* Thêm CSS cho nút xem chi tiết */
  .detail-btn {
    text-align: right;
    margin-top: 20px;
  }
  
  .detail-btn a {
    display: inline-block;
    background-color: #2563eb;
    color: #fff;
    padding: 8px 15px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }
  
  .detail-btn a:before {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.5s, height 0.5s;
    z-index: 1;
  }
  
  .detail-btn a:hover {
    background-color: #1d4ed8;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    transform: translateY(-2px);
  }
  
  .detail-btn a:hover:before {
    width: 300%;
    height: 300%;
  }
  
  /* Animation cho tooltip và các phần tử khác */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
  
  .admission-info-header h1 {
    animation: fadeIn 1s ease;
  }
  
  .school-code {
    animation: fadeIn 1s ease 0.3s forwards;
    opacity: 0;
  }
  
  .admission-note {
    animation: fadeIn 1s ease 0.6s forwards;
    opacity: 0;
  }
</style>

<div class="admission-info-container">
  <div class="container">
    <div class="admission-info-header"> &nbsp; &nbsp;
      <h1 style=" font-size: 35px; color: #153f9d;"></h1>
      <div style=" font-size: 26px; color: #153f9d;" class="school-code"></div>
      <div class="admission-note"></div>
    </div>

    <div class="admission-info-content">
      <div class="accordion">
        <h1 style=" text-align: center; font-size: 35px; color: #153f9d;"> <b>THÔNG TIN TUYỂN SINH ĐẠI HỌC CHÍNH QUY </b></h1>
      <div style=" font-size: 26px; color: #153f9d;" class="school-code"><b>Mã trường tuyển sinh: DVT</b></div>
      <div class="admission-note">(Nhấp vào các thông tin bên dưới để xem chi tiết)</div>
        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3>Đối tượng, vùng và chỉ tiêu tuyển sinh</h3>
          </div>
          <div class="accordion-content">
            <h4>1. Đối tượng tuyển sinh</h4>
            <p>Thí sinh đã tốt nghiệp chương trình THPT của Việt Nam (theo hình thức giáo dục chính quy hoặc giáo dục thường xuyên) hoặc đã tốt nghiệp trình độ trung cấp (trong đó, người tốt nghiệp trình độ trung cấp nhưng chưa có bằng tốt nghiệp THPT phải học và thi đạt yêu cầu đủ khối lượng kiến thức văn hóa THPT theo quy định của Luật Giáo dục và các văn bản hướng dẫn thi hành) hoặc đã tốt nghiệp chương trình THPT của nước ngoài (đã được nước sở tại cho phép thực hiện, đạt trình độ tương đương trình độ THPT của Việt Nam) ở nước ngoài hoặc ở Việt Nam (sau đây gọi chung là tốt nghiệp THPT).</p>
            
            <h4>2. Phạm vi tuyển sinh</h4>
            <p>Tuyển sinh trong cả nước.</p>
            
            <h4>3. Chỉ tiêu tuyển sinh</h4>
            <p>Tổng chỉ tiêu năm 2025: <strong>3.500</strong> sinh viên.</p>
            <p>Trong đó:</p>
            <ul>
              <li>Khối ngành sức khỏe: 500 chỉ tiêu</li>
              <li>Khối ngành kỹ thuật công nghệ: 900 chỉ tiêu</li>
              <li>Khối ngành kinh tế, quản lý: 850 chỉ tiêu</li>
              <li>Khối ngành khoa học xã hội, nhân văn: 650 chỉ tiêu</li>
              <li>Khối ngành nông lâm ngư: 600 chỉ tiêu</li>
            </ul>
            
            <div class="important-note">
              <p><strong>Lưu ý:</strong> Chỉ tiêu chi tiết cho từng ngành/chuyên ngành được công bố cụ thể trong Đề án tuyển sinh năm 2025.</p>
            </div>
            <div class="detail-btn">
              <a href="{{ route('user.blogDetail', 14) }}">Xem chi tiết</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3>Danh mục Ngành, tổ hợp và chỉ tiêu tuyển sinh</h3>
          </div>
          <div class="accordion-content">
            <h4>Các ngành đào tạo và tổ hợp xét tuyển</h4>
            <p>Trường Đại học Trà Vinh tuyển sinh đào tạo đại học chính quy với các ngành và tổ hợp môn xét tuyển như sau:</p>
            
            <h5>1. Khối ngành sức khỏe:</h5>
            <ul>
              <li>Y khoa (Mã ngành: 7720101) - Tổ hợp: B00, B03, D07</li>
              <li>Y học cổ truyền (Mã ngành: 7720115) - Tổ hợp: B00, B03, D07</li>
              <li>Răng - Hàm - Mặt (Mã ngành: 7720501) - Tổ hợp: B00, B03, D07</li>
              <li>Dược học (Mã ngành: 7720201) - Tổ hợp: A00, B00, D07</li>
              <li>Điều dưỡng (Mã ngành: 7720301) - Tổ hợp: B00, B03, D07</li>
              <li>Kỹ thuật xét nghiệm y học (Mã ngành: 7720601) - Tổ hợp: B00, B03, D07</li>
            </ul>
            
            <h5>2. Khối ngành kỹ thuật, công nghệ:</h5>
            <ul>
              <li>Công nghệ thông tin (Mã ngành: 7480201) - Tổ hợp: A00, A01, D01</li>
              <li>Kỹ thuật phần mềm (Mã ngành: 7480103) - Tổ hợp: A00, A01, D01</li>
              <li>Trí tuệ nhân tạo (Mã ngành: 7480207) - Tổ hợp: A00, A01, D01</li>
              <li>Kỹ thuật điện (Mã ngành: 7520201) - Tổ hợp: A00, A01, B00</li>
              <li>Công nghệ kỹ thuật cơ khí (Mã ngành: 7510201) - Tổ hợp: A00, A01, C01</li>
              <li>Công nghệ kỹ thuật ô tô (Mã ngành: 7510205) - Tổ hợp: A00, A01, C01</li>
              <li>Kiến trúc (Mã ngành: 7580101) - Tổ hợp: V00, V01, V02</li>
            </ul>
            
            <h5>3. Khối ngành kinh tế, quản lý:</h5>
            <ul>
              <li>Kinh tế (Mã ngành: 7310101) - Tổ hợp: A00, A01, C00, D01</li>
              <li>Quản trị kinh doanh (Mã ngành: 7340101) - Tổ hợp: A00, A01, C00, D01</li>
              <li>Tài chính - Ngân hàng (Mã ngành: 7340201) - Tổ hợp: A00, A01, C00, D01</li>
              <li>Kế toán (Mã ngành: 7340301) - Tổ hợp: A00, A01, C00, D01</li>
              <li>Quản trị dịch vụ du lịch và lữ hành (Mã ngành: 7810103) - Tổ hợp: A00, C00, D01, D15</li>
            </ul>
            
            <div class="important-note">
              <p><strong>Lưu ý:</strong> Danh mục các tổ hợp môn xét tuyển:</p>
              <p>- A00: Toán, Vật lý, Hóa học</p>
              <p>- A01: Toán, Vật lý, Tiếng Anh</p>
              <p>- B00: Toán, Hóa học, Sinh học</p>
              <p>- B03: Toán, Sinh học, Ngữ văn</p>
              <p>- C00: Ngữ văn, Lịch sử, Địa lý</p>
              <p>- C01: Ngữ văn, Toán, Vật lý</p>
              <p>- D01: Toán, Ngữ văn, Tiếng Anh</p>
              <p>- D07: Toán, Hóa học, Tiếng Anh</p>
              <p>- D15: Ngữ văn, Địa lý, Tiếng Anh</p>
              <p>- V00: Toán, Vật lý, Vẽ</p>
              <p>- V01: Toán, Ngữ văn, Vẽ</p>
              <p>- V02: Toán, Tiếng Anh, Vẽ</p>
            </div>
            <div class="detail-btn">
              <a href="https://drive.google.com/file/d/1gxzhVuyPWzLBfM-JlghLIrimOlbu3BbD/view" target="_blank">Xem chi tiết</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3>Phương thức xét tuyển</h3>
          </div>
          <div class="accordion-content">
            <h4>Trường Đại học Trà Vinh thực hiện xét tuyển theo các phương thức sau:</h4>
            
            <h5>1. Xét tuyển theo kết quả thi tốt nghiệp THPT năm 2025:</h5>
            <p>- Đối tượng: Thí sinh tham dự kỳ thi tốt nghiệp THPT năm 2025.</p>
            <p>- Điều kiện xét tuyển: Thí sinh đã tốt nghiệp THPT và có tổng điểm các môn thi của tổ hợp xét tuyển đạt ngưỡng đảm bảo chất lượng đầu vào do Trường quy định.</p>
            
            <h5>2. Xét tuyển theo kết quả học tập THPT (Học bạ):</h5>
            <p>- Đối tượng: Thí sinh đã tốt nghiệp THPT.</p>
            <p>- Điều kiện xét tuyển: Thí sinh có điểm trung bình chung học tập 3 năm học THPT đạt từ 6,0 trở lên và điểm trung bình cộng các môn học trong tổ hợp xét tuyển năm lớp 12 đạt từ 6,0 trở lên.</p>
            
            <h5>3. Xét tuyển thẳng và ưu tiên xét tuyển:</h5>
            <p>- Đối tượng: Theo quy định của Bộ GD&ĐT.</p>
            <p>- Thí sinh đạt giải Nhất, Nhì, Ba trong Kỳ thi chọn học sinh giỏi quốc gia, quốc tế các môn văn hóa.</p>
            <p>- Thí sinh đạt giải Nhất, Nhì, Ba trong Cuộc thi Khoa học kỹ thuật cấp quốc gia, quốc tế.</p>
            
            <h5>4. Xét tuyển dựa trên kết quả đánh giá năng lực:</h5>
            <p>- Đối với các thí sinh tham dự kỳ thi đánh giá năng lực của các trường đại học uy tín như ĐHQG TP.HCM, ĐHQG Hà Nội, Đại học Bách khoa Hà Nội.</p>
            <p>- Điểm sàn xét tuyển theo từng ngành học và theo từng kỳ thi đánh giá năng lực.</p>
            
            <div class="important-note">
              <p><strong>Lưu ý:</strong> Điểm trúng tuyển được xét từ cao xuống thấp cho đến đủ chỉ tiêu. Điểm xét tuyển sẽ được cộng điểm ưu tiên khu vực và đối tượng theo quy định hiện hành.</p>
            </div>
            <div class="detail-btn">
              <a href="{{ route('user.blogDetail', 21) }}">Xem chi tiết</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3>Thời gian tuyển sinh</h3>
          </div>
          <div class="accordion-content">
            <h4>Lịch trình tuyển sinh đại học chính quy năm 2025:</h4>
            
            <div class="timeline">
              <div class="timeline-item">
                <div class="timeline-date">Đợt 1: Tháng 3 - Tháng 5/2025</div>
                <div class="timeline-content">
                  <p>- Xét tuyển sớm theo phương thức xét học bạ THPT</p>
                  <p>- Thời gian nhận hồ sơ: 01/03/2025 - 15/05/2025</p>
                  <p>- Công bố kết quả: 25/05/2025</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">Đợt 2: Tháng 6 - Tháng 7/2025</div>
                <div class="timeline-content">
                  <p>- Xét tuyển theo kết quả thi tốt nghiệp THPT</p>
                  <p>- Thời gian đăng ký: Theo lịch của Bộ GD&ĐT</p>
                  <p>- Công bố kết quả: Theo lịch của Bộ GD&ĐT</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">Đợt 3: Tháng 8 - Tháng 9/2025</div>
                <div class="timeline-content">
                  <p>- Xét tuyển bổ sung (nếu còn chỉ tiêu)</p>
                  <p>- Thời gian nhận hồ sơ: 15/08/2025 - 15/09/2025</p>
                  <p>- Công bố kết quả: 20/09/2025</p>
                </div>
              </div>
            </div>
            
            <div class="important-note">
              <p><strong>Lưu ý:</strong> Thí sinh cần thường xuyên theo dõi website của Trường để cập nhật thông tin tuyển sinh chính xác và đầy đủ nhất.</p>
            </div>
            <div class="detail-btn">
              <a href="{{ route('user.blogDetail', 16) }}">Xem chi tiết</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3>Chính sách ưu tiên</h3>
          </div>
          <div class="accordion-content">
            <h4>1. Chính sách ưu tiên theo khu vực và đối tượng</h4>
            <p>Thực hiện theo Quy chế tuyển sinh hiện hành của Bộ Giáo dục và Đào tạo.</p>
            
            <h4>2. Học bổng và hỗ trợ học tập</h4>
            <p><strong>a) Học bổng khuyến khích học tập:</strong></p>
            <ul>
              <li>Học bổng dành cho tân sinh viên có điểm đầu vào cao (từ 1 - 5 triệu đồng/suất)</li>
              <li>Học bổng khuyến khích học tập theo kết quả học tập mỗi học kỳ (từ 2 - 6 triệu đồng/suất)</li>
              <li>Học bổng tài năng dành cho sinh viên đạt thành tích xuất sắc trong học tập, nghiên cứu khoa học và hoạt động sinh viên (10 triệu đồng/suất)</li>
            </ul>
            
            <p><strong>b) Học bổng xã hội:</strong></p>
            <ul>
              <li>Học bổng dành cho sinh viên có hoàn cảnh khó khăn, vươn lên trong học tập</li>
              <li>Học bổng dành cho sinh viên là con em đồng bào dân tộc thiểu số</li>
              <li>Học bổng dành cho sinh viên mồ côi cả cha lẫn mẹ</li>
            </ul>
            
            <p><strong>c) Các hỗ trợ khác:</strong></p>
            <ul>
              <li>Miễn học phí theo Nghị định 86/2015/NĐ-CP đối với sinh viên thuộc đối tượng quy định</li>
              <li>Giảm học phí cho sinh viên là con em các gia đình có nhiều con học tại trường</li>
              <li>Ưu đãi về ở ký túc xá đối với sinh viên có hoàn cảnh khó khăn</li>
              <li>Hỗ trợ tìm kiếm việc làm thêm trong quá trình học tập</li>
            </ul>
            
            <div class="important-note">
              <p><strong>Lưu ý:</strong> Các chính sách cụ thể có thể thay đổi theo từng năm học. Sinh viên cần liên hệ Phòng Công tác Sinh viên để được tư vấn chi tiết.</p>
            </div>
            <div class="detail-btn">
              <a href="{{ route('user.blogDetail', 17) }}">Xem chi tiết</a>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <h3>Các mốc thời gian xét tuyển đại học 2025 (thí sinh cần lưu ý)</h3>
          </div>
          <div class="accordion-content">
            <h4>Các mốc thời gian quan trọng trong quy trình tuyển sinh năm 2025:</h4>
            
            <div class="timeline">
              <div class="timeline-item">
                <div class="timeline-date">01/03/2025 - 15/05/2025</div>
                <div class="timeline-content">
                  <p>Tiếp nhận hồ sơ xét tuyển sớm theo phương thức xét học bạ</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">25/05/2025</div>
                <div class="timeline-content">
                  <p>Công bố kết quả xét tuyển sớm</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">01/06/2025 - 30/06/2025</div>
                <div class="timeline-content">
                  <p>Thí sinh thi tốt nghiệp THPT 2025</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">15/07/2025</div>
                <div class="timeline-content">
                  <p>Công bố kết quả thi tốt nghiệp THPT</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">15/07/2025 - 30/07/2025</div>
                <div class="timeline-content">
                  <p>Thí sinh đăng ký nguyện vọng xét tuyển trên hệ thống của Bộ GD&ĐT</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">15/08/2025</div>
                <div class="timeline-content">
                  <p>Công bố điểm trúng tuyển đợt 1</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">15/08/2025 - 30/08/2025</div>
                <div class="timeline-content">
                  <p>Thí sinh trúng tuyển xác nhận nhập học trực tuyến</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">01/09/2025 - 15/09/2025</div>
                <div class="timeline-content">
                  <p>Thí sinh làm thủ tục nhập học tại trường</p>
                </div>
              </div>
              
              <div class="timeline-item">
                <div class="timeline-date">15/09/2025 - 30/09/2025</div>
                <div class="timeline-content">
                  <p>Xét tuyển bổ sung (nếu còn chỉ tiêu)</p>
                </div>
              </div>
            </div>
            
            <div class="important-note">
              <p><strong>Lưu ý quan trọng:</strong></p>
              <ul>
                <li>Thí sinh cần theo dõi thường xuyên website tuyển sinh của Trường (tuyensinh.tvu.edu.vn) để cập nhật thông tin mới nhất</li>
                <li>Lịch trình có thể thay đổi theo quy định của Bộ GD&ĐT</li>
                <li>Khi cần tư vấn, thí sinh có thể liên hệ hotline tuyển sinh: 0962.3856.358</li>
              </ul>
            </div>
            <div class="detail-btn">
              <a href="{{ route('user.blogDetail', 18) }}">Xem chi tiết</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function toggleAccordion(header) {
    // Lấy nội dung của accordion
    const content = header.nextElementSibling;
    
    // Toggle class active cho header và show cho content
    header.classList.toggle('active');
    content.classList.toggle('show');
    
    // Hiệu ứng pulse khi mở accordion
    if (content.classList.contains('show')) {
      header.style.animation = 'pulse 0.5s';
      setTimeout(() => {
        header.style.animation = '';
      }, 500);
    }
    
    // Đóng các accordion khác nếu muốn (đã bỏ comment)
    const allHeaders = document.querySelectorAll('.accordion-header');
    const allContents = document.querySelectorAll('.accordion-content');
    
    allHeaders.forEach((item, index) => {
      if (item !== header) {
        item.classList.remove('active');
      }
    });
    
    allContents.forEach(item => {
      if (item !== content) {
        item.classList.remove('show');
      }
    });
  }

  // Tự động mở accordion đầu tiên khi trang được tải
  document.addEventListener('DOMContentLoaded', function() {
    
    
    // Thêm hiệu ứng hover tooltip cho các mục quan trọng
    const importantItems = document.querySelectorAll('.important-note strong');
    importantItems.forEach(item => {
      item.style.position = 'relative';
      item.style.cursor = 'help';
      item.setAttribute('title', 'Thông tin quan trọng');
    });
    
    // Fix cho khoảng trắng phía trên header
    document.querySelector('main').style.margin = '0';
    document.querySelector('main').style.padding = '0';
    
    // Remove any potential whitespace nodes
    const main = document.querySelector('main');
    for (let i = 0; i < main.childNodes.length; i++) {
      if (main.childNodes[i].nodeType === 3) { // Text node
        if (main.childNodes[i].nodeValue.trim() === '') {
          main.removeChild(main.childNodes[i]);
          i--;
        }
      }
    }
  });
</script>

@endsection
