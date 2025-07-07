@extends('user.layout')
@section('title', 'Danh sách ngành học')
@section('content')

<style>
  .faculty-accordion-container {
    max-width: 1250px; /* Tăng độ rộng container cha */
    margin: 0 auto;
    padding: 20px;
    animation: fadeIn 0.6s ease-in-out;
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Hiệu ứng stagger cho các accordion items */
  .faculty-accordion:nth-child(1) { animation-delay: 0.1s; }
  .faculty-accordion:nth-child(2) { animation-delay: 0.2s; }
  .faculty-accordion:nth-child(3) { animation-delay: 0.3s; }
  .faculty-accordion:nth-child(4) { animation-delay: 0.4s; }
  .faculty-accordion:nth-child(5) { animation-delay: 0.5s; }
  .faculty-accordion:nth-child(6) { animation-delay: 0.6s; }

  @keyframes slideInUp {
    from {
      opacity: 0;
      transform: translateY(50px) scale(0.95);
    }
    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  .faculty-accordion {
    animation: slideInUp 0.6s ease-out both;
    margin-bottom: 30px; /* Tăng khoảng cách giữa các khoa */
    border-radius: 15px; /* Tăng bo góc */
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0,0,0,0.12); /* Tăng shadow */
    transition: all 0.3s ease;
    border: 1px solid rgba(102, 126, 234, 0.1);
    max-width: 1250px;
    margin-left: auto;
    margin-right: auto;
  }

  .faculty-accordion:hover {
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.15);
    transform: translateY(-2px);
  }

  .faculty-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 22px 30px; /* Tăng padding để header to hơn */
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.4s ease;
    margin: 0;
    position: relative;
    overflow: hidden;
  }

  .faculty-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s ease;
  }

  .faculty-header:hover::before {
    left: 100%;
  }

  .faculty-header:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    transform: scale(1.02);
  }

  .faculty-header.active {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
    box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
  }

  .faculty-title-container {
    display: flex;
    align-items: center;
  }

  .faculty-title {
    margin: 0;
    font-size: 1.25em; /* Tăng kích thước font */
    font-weight: 600;
    text-transform: uppercase;
    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
    position: relative;
    z-index: 1;
  }

  .faculty-count {
    background: rgba(255,255,255,0.25);
    padding: 8px 16px; /* Tăng padding */
    border-radius: 25px; /* Tăng bo góc */
    font-size: 0.9em; /* Tăng kích thước font */
    margin-left: 15px; /* Tăng margin */
    font-weight: 500;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 0.3s ease;
  }

  .faculty-header:hover .faculty-count {
    background: rgba(255,255,255,0.3);
    transform: scale(1.05);
  }

  .faculty-toggle {
    font-size: 1.4em; /* Tăng kích thước icon */
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.1));
    position: relative;
    z-index: 1;
  }

  .faculty-toggle.active {
    transform: rotate(180deg) scale(1.1);
  }

  .faculty-header:hover .faculty-toggle {
    transform: scale(1.1);
  }

  .faculty-header:hover .faculty-toggle.active {
    transform: rotate(180deg) scale(1.2);
  }

  .faculty-content {
    max-height: 0;
    overflow: hidden;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border-top: 1px solid rgba(102, 126, 234, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: translateY(-10px);
    padding: 0 35px; /* Tăng padding để phù hợp với active state */
  }

  .faculty-content.active {
    max-height: 900px; /* Tăng chiều cao tối đa */
    opacity: 1;
    transform: translateY(0);
    box-shadow: inset 0 2px 4px rgba(102, 126, 234, 0.05);
    padding: 30px 35px; /* Tăng padding để cân đối hơn */
  }

  /* Hiệu ứng loading spinner */
  .major-loading {
    text-align: center;
    padding: 25px;
    color: #667eea;
    font-weight: 500;
  }

  .major-loading i {
    font-size: 1.3em;
    margin-right: 10px;
    animation: spin 1s linear infinite;
    color: #667eea;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Hiệu ứng fade in cho danh sách ngành */
  .major-list {
    animation: fadeInUp 0.5s ease forwards;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .major-list {
    list-style: none;
    padding: 0 15px !important; /* Giảm padding thêm để thẻ ngành rộng hơn */
    margin: 0;
  }

  .major-item {
    padding: 0;
    margin-bottom: 12px; /* Tăng khoảng cách giữa các items */
    margin-left: auto;
    margin-right: auto;
    border: 1px solid #e9ecef;
    border-radius: 8px; /* Tăng bo góc */
    transition: all 0.3s ease;
    position: relative;
    overflow: visible; /* Thay đổi từ hidden sang visible để hiệu ứng dịch chuyển không bị cắt */
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08); /* Tăng shadow */
    max-width: calc(100% - 20px) !important; /* Force áp dụng chiều rộng mới */
    width: calc(100% - 20px) !important; /* Tăng chiều rộng thêm nữa */
  }

  .major-item:last-child {
    margin-bottom: 0; /* Loại bỏ margin cho item cuối */
  }

  /* Force override cho chiều rộng thẻ ngành */
  .faculty-accordion .major-list .major-item {
    max-width: calc(100% - 20px) !important;
    width: calc(100% - 20px) !important;
    margin-left: auto !important;
    margin-right: auto !important;
  }

  /* Trạng thái active cho major item */
  .major-item.active {
    background: linear-gradient(135deg, #e8f4fd 0%, #f0f8ff 100%);
    border-left: 4px solid #2196f3;
    border-color: #2196f3;
    box-shadow: 0 3px 12px rgba(33, 150, 243, 0.2);
    position: relative;
  }

  .major-item.active .major-link {
    color: #1976d2;
    font-weight: 600;
    padding-left: 16px; /* Giảm padding vì đã có border trái */
  }

  .major-item:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #e8f4fd 100%);
    transform: translateX(15px); /* Giảm dịch chuyển để phù hợp với căn giữa */
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
    border-color: #667eea;
  }

  .major-item.active:hover {
    background: linear-gradient(135deg, #e1f5fe 0%, #e8f5e8 100%);
    transform: translateX(6px); /* Giảm dịch chuyển để phù hợp với căn giữa */
    box-shadow: 0 6px 20px rgba(33, 150, 243, 0.25);
  }

  .major-item::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transform: scaleY(0);
    transition: transform 0.3s ease;
    transform-origin: bottom;
  }

  .major-item:hover::before {
    transform: scaleY(1);
    transform-origin: top;
  }

  /* Ẩn border trái khi hover nếu item đã active */
  .major-item.active::before {
    display: none;
  }

  .major-link {
    color: #495057;
    text-decoration: none;
    font-weight: 500;
    display: block;
    padding: 18px 25px; /* Tăng padding */
    position: relative;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 17px; /* Tăng kích thước font */
  }

  .major-link:hover {
    color: #667eea;
    text-decoration: none;
    /* Loại bỏ padding-left thay đổi vì đã có hiệu ứng translateY */
  }

  /* Cải thiện style cho major item khi được click */
  .major-item {
    cursor: pointer;
    user-select: none;
  }

  .major-item.active .major-link:hover {
    color: #1565c0;
    /* Không thay đổi padding khi hover item active */
  }

  .major-link::after {
    content: '→';
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%) translateX(10px);
    opacity: 0;
    transition: all 0.3s ease;
    color: #667eea;
    font-weight: bold;
  }

  .major-link:hover::after {
    opacity: 1;
    transform: translateY(-50%) translateX(0);
  }

  /* Hiệu ứng ripple khi click */
  .major-item {
    position: relative;
    overflow: hidden;
  }

  .major-item::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(102, 126, 234, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
  }

  .major-item:active::after {
    width: 300px;
    height: 300px;
  }

  .no-majors {
    text-align: center;
    padding: 30px 20px;
    color: #8e9aaf;
    font-style: italic;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border-radius: 8px;
    margin: 10px;
    border: 2px dashed #e1e8f0;
    position: relative;
    overflow: hidden;
  }

  .no-majors::before {
    content: '📚';
    display: block;
    font-size: 2em;
    margin-bottom: 10px;
    opacity: 0.5;
  }

  .no-majors::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
    animation: shimmer 2s infinite;
  }

  @keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
  }

  /* Hiệu ứng cho title section */
  .mu-title {
    animation: titleFadeIn 0.8s ease-out;
  }

  @keyframes titleFadeIn {
    from {
      opacity: 0;
      transform: translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .mu-title h2 {
    background: black;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    position: relative;
  }

  .mu-title h2::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    border-radius: 2px;
  }
</style>
  <section id="mu-features">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="mu-features-area">
            <!-- Start Title -->
            <div class="mu-title">
              <h2> <b>Danh sách ngành học theo khối ngành </b></h2>
              <p style="font-size: 1.4em; line-height: 1.6;">Trường Đại học Trà Vinh (TVU) hiện đào tạo đa dạng các ngành học thuộc các lĩnh vực như: Kinh tế, Luật, Ngôn ngữ, Văn hóa, Y Dược, Kỹ thuật, Công nghệ, Nông nghiệp, Thủy sản, và nhiều ngành khác. Nhấp vào từng khối ngành để xem danh sách các ngành học.</p>
            </div>
            <!-- End Title -->
            <!-- Start features content -->
            <div class="mu-features-content">
              <!-- Faculty Accordion List -->
              <div class="faculty-accordion-container">
                @foreach ($dataMajorCategory as $category)
                <div class="faculty-accordion">
                  <div class="faculty-header" onclick="toggleFaculty({{ $category->id }}, this)">
                    <div class="faculty-title-container">
                      <h4 class="faculty-title">{{ $category->name_category_major }}</h4>
                      <span class="faculty-count" id="count-{{ $category->id }}">{{ $category->major_count ?? 0 }} ngành</span>
                    </div>
                    <span class="faculty-toggle">
                      <i class="fa fa-chevron-down"></i>
                    </span>
                  </div>
                  <div class="faculty-content" id="faculty-content-{{ $category->id }}">
                    <div class="major-loading">
                      <i class="fa fa-spinner"></i>
                      Đang tải danh sách ngành học...
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            </div>
            <!-- End features content -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    // Lưu trữ trạng thái các khoa đã được mở
    const openedFaculties = new Set();

    function toggleFaculty(categoryId, headerElement) {
      const contentElement = document.getElementById(`faculty-content-${categoryId}`);
      const toggleSpan = headerElement.querySelector('.faculty-toggle');

      // Nếu khoa đang đóng, mở nó
      if (!contentElement.classList.contains('active')) {
        contentElement.classList.add('active');
        toggleSpan.classList.add('active');

        // Nếu chưa load dữ liệu cho khoa này
        if (!openedFaculties.has(categoryId)) {
          loadMajorsByCategory(categoryId);
          openedFaculties.add(categoryId);
        }
      } else {
        // Nếu khoa đang mở, đóng nó
        contentElement.classList.remove('active');
        toggleSpan.classList.remove('active');
      }
    }

    function loadMajorsByCategory(categoryId) {
      const contentElement = document.getElementById(`faculty-content-${categoryId}`);
      const countElement = document.getElementById(`count-${categoryId}`);
      let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      fetch(`/major-category/${categoryId}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
      })
      .then(response => response.json())
      .then(data => {
        let majorHtml = '';

        if (data.dataMajor && data.dataMajor.length > 0) {
          majorHtml = '<ul class="major-list">';
          data.dataMajor.forEach((element, index) => {
            // Loại bỏ active mặc định cho item đầu tiên
            majorHtml += `
              <li class="major-item" onclick="setActiveMajor(this, ${element.id})">
                <a href="/major-detail/${element.id}" class="major-link" onclick="event.stopPropagation();">
                 <b> ${element.name_major} </b>
                </a> 
              </li>
            `;
          });
          majorHtml += '</ul>';

          // Cập nhật số lượng ngành
          countElement.textContent = `${data.dataMajor.length} ngành`;
        } else {
          majorHtml = '<div class="no-majors">Hiện chưa có ngành học nào trong khối ngành này.</div>';
          countElement.textContent = '0 ngành';
        }

        contentElement.innerHTML = majorHtml;
      })
      .catch(error => {
        console.error('Error:', error);
        contentElement.innerHTML = '<div class="no-majors">Có lỗi xảy ra khi tải dữ liệu. Vui lòng thử lại.</div>';
        countElement.textContent = 'Lỗi';
      });
    }

    // Function để set active major item
    function setActiveMajor(clickedElement, majorId) {
      // Xóa active class từ tất cả major items trong tất cả các khoa
      document.querySelectorAll('.major-item').forEach(item => {
        item.classList.remove('active');
      });

      // Thêm active class cho item được click
      clickedElement.classList.add('active');

      // Có thể thêm logic khác ở đây nếu cần (ví dụ: load thông tin chi tiết ngành)
      console.log('Selected major ID:', majorId);
    }
  </script>
@endsection
