@extends('user.layout')
@section('title', 'Danh sách bài viết')
@section('content')

<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  /* Category Filter Styles */
  .blog-category-filter {
    margin: 40px 0;
    padding: 0;
  }

  .category-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
    margin-bottom: 40px;
  }

  .category-tab {
    background: #fff;
    border: 2px solid #e0e0e0;
    border-radius: 25px;
    padding: 12px 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
    color: #666;
    text-decoration: none;
    display: inline-block;
    position: relative;
    overflow: hidden;
  }

  .category-tab:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-color: #007bff;
    color: #007bff;
    text-decoration: none;
  }

  .category-tab.active {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-color: #007bff;
    color: white;
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
  }

  .category-tab.active:hover {
    color: white;
    transform: translateY(-2px);
  }

  /* Blog Cards Enhancement */
  .mu-blog-single-item {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 480px; /* Fixed height for all cards */
    display: flex;
    flex-direction: column;
  }

  .mu-blog-single-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
  }

  .mu-blog-single-img {
    position: relative;
    overflow: hidden;
    margin: 0;
    height: 250px; /* Fixed image height */
    flex-shrink: 0;
  }

  .mu-blog-single-img img {
    transition: transform 0.3s ease;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 1px solid rgb(199, 199, 199);
    border-radius: 15px 15px 15px 15px;
  }

  .mu-blog-single-item:hover .mu-blog-single-img img {
    transform: scale(1.05);
  }

  .mu-blog-title {
    padding: 10px 2px 20px 15px;
    flex-shrink: 0;
  }

  .mu-blog-title h3 {
    margin: 0;
    font-size: 18px;
    line-height: 1.5;
    font-weight: 600;
    height: 50px; /* Fixed height for title */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* Limit to 2 lines */
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
  }

  .mu-blog-title h3 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .mu-blog-title h3 a:hover {
    color: #007bff;
  }

  .mu-blog-meta {
    padding: 0px 0px 0px 15px;
    font-size: 12px;
    color: #666;
    flex-shrink: 0;
  }

  

  .mu-blog-meta a {
    color:rgb(80, 80, 80);
    text-decoration: none;
    margin-right: 10px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
  }

  .mu-blog-meta span {
    color:rgb(80, 80, 80);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 3px;
  }

  .mu-blog-description {
    
    padding-top: 0px;
    padding-right: 15px;
    padding-bottom: 25px;
    padding-left: 15px;
    flex-grow: 1;
    overflow: hidden;
  }

  .mu-blog-description p {
    color: grey;
    line-height: 1.5;
    margin: 0;
    font-size: 13px;
    height: 60px; /* Fixed height for description */
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Limit to 3 lines */
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
  }

  /* Pagination Styles */
  .blog-pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 40px 0;
    gap: 10px;
  }

  .pagination-btn {
    background: #fff;
    border: 2px solid #e0e0e0;
    color: #666;
    padding: 8px 12px;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
    min-width: 40px;
    text-align: center;
  }

  .pagination-btn:hover {
    border-color: #007bff;
    color: #007bff;
    text-decoration: none;
  }

  .pagination-btn.active {
    background: #007bff;
    border-color: #007bff;
    color: white;
  }

  .pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }

  .pagination-info {
    color: #666;
    font-size: 14px;
    margin: 0 15px;
  }

  /* Loading Animation */
  .loading-spinner {
    display: none;
    text-align: center;
    padding: 40px;
  }

  .spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    margin: 0 auto 20px;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    .category-tabs {
      justify-content: flex-start;
      overflow-x: auto;
      padding-bottom: 10px;
    }

    .category-tab {
      white-space: nowrap;
      flex-shrink: 0;
    }

    .mu-blog-single-item {
      height: 450px; /* Slightly smaller height on mobile */
    }

    .mu-blog-title h3 {
      font-size: 16px;
      height: 45px; /* Adjust height for smaller font */
    }

    .mu-blog-description p {
      height: 55px; /* Adjust description height on mobile */
    }
  }
</style>
<section id="mu-from-blog">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="mu-from-blog-area">
            <!-- start title -->
            <div class="mu-title">
              <h2> <b>Danh sách bài viết</b></h2>
              <p>Khám phá những bài viết, sáng tác và cảm nhận từ sinh viên, giảng viên và cộng đồng TVU. Các bài viết này phản ánh những khoảnh khắc đáng nhớ, tình cảm gắn bó với mái trường, cũng như những đóng góp tích cực của TVU trong giáo dục, nghiên cứu và phục vụ cộng đồng. Đây là nơi lưu giữ những câu chuyện truyền cảm hứng, kỷ niệm đáng nhớ và những sáng tác nghệ thuật đặc sắc, góp phần khẳng định giá trị văn hóa và sứ mệnh của trường</p>
            </div>
            <!-- end title -->  
            <!-- start from blog content   -->
            <div class="mu-from-blog-content">
              <!-- Category Filter Section -->
              <div class="blog-category-filter">
                <div class="category-tabs">
                  <div class="category-tab {{ (!isset($categoryId) || $categoryId == '0') ? 'active' : '' }}" data-category="0" onclick="showAllBlogs()">
                    <i class="fa fa-th-large"></i> Tất cả danh mục
                  </div>
                  @foreach ($dataBlogCategory as $item)
                  <div class="category-tab {{ (isset($categoryId) && $categoryId == $item->id) ? 'active' : '' }}" data-category="{{$item->id}}">
                    @php
                      $categoryIcons = [
                        'Hướng dẫn đăng ký' => 'fa-edit',
                        'Câu hỏi thường gặp' => 'fa-question-circle',
                        'Kinh nghiệm xét tuyển' => 'fa-lightbulb',
                        'Tin tức' => 'fa-newspaper',
                        'Thông báo' => 'fa-bullhorn',
                        'Sự kiện' => 'fa-calendar-alt',
                        'Tuyển sinh' => 'fa-graduation-cap',
                        'Học bổng' => 'fa-award',
                        'Đào tạo' => 'fa-book',
                        'Nghiên cứu' => 'fa-flask',
                        'Hoạt động sinh viên' => 'fa-users',
                        'Thông tin chung' => 'fa-info-circle'
                      ];
                      $iconClass = $categoryIcons[$item->name_category_blog] ?? 'fa-folder';
                    @endphp
                    <i class="fa {{$iconClass}}"></i> {{$item->name_category_blog}}
                  </div>
                  @endforeach
                </div>
              </div>

              <!-- Loading Spinner -->
              <div class="loading-spinner" id="loadingSpinner">
                <div class="spinner"></div>
                <p>Đang tải bài viết...</p>
              </div>
              <!-- Blog Posts Grid -->
              <div class="row" id="blogList">
                @foreach ( $dataBlog as $item )
                <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 30px; ">
                  <article class="mu-blog-single-item">
                    <figure class="mu-blog-single-img">
                      <a href="{{ route('user.blogDetail', ['id' => $item->id]) }}">
                        <img src="{{$item->image_blog}}" alt="{{$item->name_blog}}">
                      </a>
                    </figure>
                    <div class="mu-blog-title">
                      <h3><a href="{{ route('user.blogDetail', ['id' => $item->id]) }}">{{$item->name_blog}}</a></h3>
                    </div>
                    <div class="mu-blog-meta">
                      <a href="#"><i class="fa fa-user"></i> {{$item->author_name}}</a>
                      <a href="#"><i class="fa fa-calendar"></i> {{date('d/m/Y', strtotime($item->date_blog))}}</a>
                      <span><i class="fa fa-eye"></i> {{$item->view_blog}} lượt xem</span>
                    </div>
                    <div class="mu-blog-meta">
                      @php
                        $categoryIcons = [
                          'Hướng dẫn đăng ký' => 'fa-edit',
                          'Câu hỏi thường gặp' => 'fa-question-circle',
                          'Kinh nghiệm xét tuyển' => 'fa-lightbulb',
                          'Tin tức' => 'fa-newspaper',
                          'Thông báo' => 'fa-bullhorn',
                          'Sự kiện' => 'fa-calendar-alt',
                          'Tuyển sinh' => 'fa-graduation-cap',
                          'Học bổng' => 'fa-award',
                          'Đào tạo' => 'fa-book',
                          'Nghiên cứu' => 'fa-flask',
                          'Hoạt động sinh viên' => 'fa-users',
                          'Thông tin chung' => 'fa-info-circle'
                        ];
                        $iconClass = $categoryIcons[$item->name_category_blog] ?? 'fa-tag';
                      @endphp
                      <a href="#" style="color:rgb(40, 85, 167);"><i class="fa {{$iconClass}}"></i> {{$item->name_category_blog}}</a>
                    </div>
                    <div class="mu-blog-description">
                      <p>{{Str::limit($item->description_blog, 80)}}</p>
                    </div>
                  </article>
                </div>
                @endforeach
              </div>

              <!-- Pagination -->
              @if($dataBlog->hasPages())
              <div class="blog-pagination">
                {{-- Previous Page Link --}}
                @if ($dataBlog->onFirstPage())
                  <span class="pagination-btn disabled">
                    <i class="fa fa-chevron-left"></i>
                  </span>
                @else
                  <a href="{{ $dataBlog->previousPageUrl() }}" class="pagination-btn">
                    <i class="fa fa-chevron-left"></i>
                  </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($dataBlog->getUrlRange(1, $dataBlog->lastPage()) as $page => $url)
                  @if ($page == $dataBlog->currentPage())
                    <span class="pagination-btn active">{{ $page }}</span>
                  @else
                    <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                  @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($dataBlog->hasMorePages())
                  <a href="{{ $dataBlog->nextPageUrl() }}" class="pagination-btn">
                    <i class="fa fa-chevron-right"></i>
                  </a>
                @else
                  <span class="pagination-btn disabled">
                    <i class="fa fa-chevron-right"></i>
                  </span>
                @endif

                {{-- Pagination Info --}}
                <div class="pagination-info">
                  Hiển thị {{ $dataBlog->firstItem() }}-{{ $dataBlog->lastItem() }}
                  trong tổng số {{ $dataBlog->total() }} bài viết
                </div>
              </div>
              @endif
            </div>
            <!-- end from blog content   -->
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    // Category Filter Functionality
    document.addEventListener('DOMContentLoaded', function() {
      const categoryTabs = document.querySelectorAll('.category-tab');
      const blogList = document.getElementById('blogList');
      const loadingSpinner = document.getElementById('loadingSpinner');

      categoryTabs.forEach(tab => {
        tab.addEventListener('click', function() {
          const categoryId = this.getAttribute('data-category');

          // Update active tab
          categoryTabs.forEach(t => t.classList.remove('active'));
          this.classList.add('active');

          // Show loading spinner
          loadingSpinner.style.display = 'block';
          blogList.style.opacity = '0.5';

          // Fetch filtered blogs
          filterBlogsByCategory(categoryId);
        });
      });
    });

    function filterBlogsByCategory(categoryId) {
      let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

      fetch('/blog-category/' + categoryId, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
        },
      })
      .then(response => response.json())
      .then(data => {
        // Hide loading spinner
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('blogList').style.opacity = '1';

        // Hide pagination when filtering
        const pagination = document.querySelector('.blog-pagination');
        if (pagination) {
          pagination.style.display = 'none';
        }

        // Clear current blog list
        document.querySelector('#blogList').innerHTML = '';

        // Check if there are blogs
        if (data.dataBlog && data.dataBlog.length > 0) {
          data.dataBlog.forEach(element => {
            // Format date
            const date = new Date(element.date_blog);
            const formattedDate = date.toLocaleDateString('vi-VN');

            // Limit description
            const description = element.description_blog.length > 80
              ? element.description_blog.substring(0, 80) + '...'
              : element.description_blog;

            // Dynamic icon mapping
            const categoryIcons = {
              'Hướng dẫn đăng ký': 'fa-edit',
              'Câu hỏi thường gặp': 'fa-question-circle',
              'Kinh nghiệm xét tuyển': 'fa-lightbulb',
              'Tin tức': 'fa-newspaper',
              'Thông báo': 'fa-bullhorn',
              'Sự kiện': 'fa-calendar-alt',
              'Tuyển sinh': 'fa-graduation-cap',
              'Học bổng': 'fa-award',
              'Đào tạo': 'fa-book',
              'Nghiên cứu': 'fa-flask',
              'Hoạt động sinh viên': 'fa-users',
              'Thông tin chung': 'fa-info-circle'
            };
            const iconClass = categoryIcons[element.name_category_blog] || 'fa-tag';

            document.querySelector('#blogList').innerHTML += `
              <div class="col-lg-4 col-md-6 col-sm-12" style="margin-bottom: 30px;">
                <article class="mu-blog-single-item">
                  <figure class="mu-blog-single-img">
                    <a href="/blog-detail/${element.id}">
                      <img src="${element.image_blog}" alt="${element.name_blog}">
                    </a>
                  </figure>
                  <div class="mu-blog-title">
                    <h3><a href="/blog-detail/${element.id}">${element.name_blog}</a></h3>
                  </div>
                  <div class="mu-blog-meta">
                    <a href="#"><i class="fa fa-user"></i> ${element.author_name || 'Admin'}</a>
                    <a href="#"><i class="fa fa-calendar"></i> ${formattedDate}</a>
                    <span><i class="fa fa-eye"></i> ${element.view_blog} lượt xem</span>
                  </div>
                  <div class="mu-blog-meta">
                    <a href="#" style="color: #28a745;"><i class="fa ${iconClass}"></i> ${element.name_category_blog || 'Chưa phân loại'}</a>
                  </div>
                  <div class="mu-blog-description">
                    <p>${description}</p>
                  </div>
                </article>
              </div>
            `;
          });
        } else {
          // Show no results message
          document.querySelector('#blogList').innerHTML = `
            <div class="col-12 text-center" style="padding: 60px 20px;">
              <div style="color: #666; font-size: 18px;">
                <i class="fa fa-search" style="font-size: 48px; margin-bottom: 20px; color: #ddd;"></i>
                <h4>Không tìm thấy bài viết nào</h4>
                <p>Hiện tại chưa có bài viết nào trong danh mục này.</p>
              </div>
            </div>
          `;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        document.getElementById('loadingSpinner').style.display = 'none';
        document.getElementById('blogList').style.opacity = '1';

        // Show error message
        document.querySelector('#blogList').innerHTML = `
          <div class="col-12 text-center" style="padding: 60px 20px;">
            <div style="color: #dc3545; font-size: 18px;">
              <i class="fa fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 20px;"></i>
              <h4>Có lỗi xảy ra</h4>
              <p>Không thể tải danh sách bài viết. Vui lòng thử lại sau.</p>
            </div>
          </div>
        `;
      });
    }

    // Function to show all blogs with pagination
    function showAllBlogs() {
      // Show pagination again
      const pagination = document.querySelector('.blog-pagination');
      if (pagination) {
        pagination.style.display = 'flex';
      }

      // Reload the page to show all blogs with pagination
      window.location.href = '{{ route("user.blogList") }}';
    }
  </script>
@endsection
