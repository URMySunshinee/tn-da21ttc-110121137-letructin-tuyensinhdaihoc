@extends('user.layout')
@section('title', isset($dataBlog) ? $dataBlog->name_blog : 'Blog không tồn tại')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endpush

@section('content')



<style>
  .blog-wrapper {
    max-width: 100%;
    margin: 0;
    padding: 0;
    background: white;
    min-height: 100vh;
    width: 100%;
  }

  .blog-main {
    display: flex;
    gap: 20px;
    margin-bottom: 0;
    width: 100%;
    padding: 40px 20px;
  }

  .blog-content {
    flex: 0 0 70%;
    background: transparent;
    padding: 40px;
    border-radius: 15px;
    box-shadow: none;
    border: none;
  }

  .blog-sidebar {
    flex: 0 0 28%;
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid #e9ecef;
    height: fit-content;
    position: sticky;
    top: 20px;
  }

  .blog-title {
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 30px;
    font-weight: 600;
    line-height: 1.4;
    text-align: center;
    padding: 0 20px;
  }

  .blog-image-container {
    margin-bottom: 20px;
    text-align: center;
  }

  .blog-main-image {
    width: 100%;
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  }

  .blog-meta {
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 20px;
    margin-bottom: 25px;
    padding: 15px 0;
    border-bottom: 1px solid #e2e8f0;
    font-size: 14px;
    color: #666;
  }

  .meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .meta-item i {
    color: #3498db;
    font-size: 14px;
  }

  .blog-description {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 25px;
    border-left: 4px solid #3498db;
  }

  .blog-description h3 {
    color: #2c3e50;
    font-size: 16px;
    margin-bottom: 12px;
    font-weight: 600;
  }

  .blog-description p {
    color: #555;
    line-height: 1.6;
    margin: 0;
    font-size: 15px;
  }
  
  .blog-content-text {
    background: white;
    padding: 0;
    line-height: 1.7;
    color: #333;
    font-size: 18px;
    width: 100%;
    max-width: 100%;
    overflow-wrap: break-word;
    word-wrap: break-word;
  }

  /* Override Summernote generated styles */
  .blog-content-text * {
    max-width: 100% !important;
    width: auto !important;
    text-align: inherit !important;
  }

  .blog-content-text p,
  .blog-content-text div {
    width: 100% !important;
    max-width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    text-align: justify !important;
  }

  .blog-content-text img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }

  .blog-content-text h1,
  .blog-content-text h2,
  .blog-content-text h3,
  .blog-content-text h4 {
    color: #2c3e50;
    margin-top: 25px;
    margin-bottom: 15px;
    font-weight: 600;
  }

  .blog-content-text h2 {
    font-size: 22px;
    color: #34495e;
    border-bottom: 2px solid #3498db;
    padding-bottom: 8px;
    margin-bottom: 20px;
  }

  .blog-content-text p {
    margin-bottom: 16px;
    text-align: justify;
    line-height: 1.7;
    width: 100%;
    max-width: 100%;
    font-size: 18px;
  }

  .blog-content-text ul,
  .blog-content-text ol {
    margin: 15px 0;
    padding-left: 25px;
  }

  .blog-content-text li {
    margin-bottom: 8px;
    line-height: 1.6;
  }

  .blog-content-text blockquote {
    border-left: 4px solid #3498db;
    padding-left: 20px;
    margin: 20px 0;
    font-style: italic;
    color: #555;
    background: #f8f9fa;
    padding: 15px 20px;
    border-radius: 0 8px 8px 0;
  }
  
  .sidebar-box {
    background: #f8f9fa;
    padding: 25px;
    border-radius: 12px;
    margin-bottom: 25px;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
  }

  .sidebar-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  }

  .sidebar-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 3px solid #667eea;
    position: relative;
    display: flex;
    align-items: center;
  }

  .sidebar-title::before {
    content: "";
    width: 6px;
    height: 6px;
    background: #667eea;
    border-radius: 50%;
    margin-right: 10px;
  }
  
  .category-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 18px;
    margin-bottom: 10px;
    background: white;
    color: #4a5568;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s ease;
    border: 1px solid #e2e8f0;
    font-weight: 500;
    position: relative;
    overflow: hidden;
  }

  .category-item::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transition: width 0.3s ease;
    z-index: 1;
  }

  .category-item:hover::before {
    width: 100%;
  }

  .category-item:hover {
    color: white;
    text-decoration: none;
    transform: translateX(8px);
    border-color: #667eea;
  }

  .category-item span,
  .category-item i {
    position: relative;
    z-index: 2;
  }

  .category-item i {
    font-size: 14px;
    opacity: 0.7;
    transition: all 0.3s ease;
  }

  .category-item:hover i {
    opacity: 1;
    transform: translateX(3px);
  }
  
  .popular-item {
    display: flex;
    gap: 12px;
    padding: 15px 0;
    border-bottom: 1px solid #e9ecef;
  }
  
  .popular-item:last-child {
    border-bottom: none;
  }
  
  .popular-image {
    width: 110px;
    height: 73px; /* Tỷ lệ 275x183 = 1.5, nên 110/1.5 = 73px */
    border-radius: 6px;
    overflow: hidden;
    flex-shrink: 0; /* Không cho co lại */
    background: #f8f9fa; /* Background fallback */
  }
  
  .popular-image img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Cắt ảnh để fit khung hình */
    object-position: center; /* Giữ ảnh ở giữa */
    transition: transform 0.3s ease;
    display: block;
  }

  .popular-image:hover img {
    transform: scale(1.05);
  }
  
  .popular-content h5 {
    font-size: 14px;
    margin: 0 0 8px 0;
    line-height: 1.4;
  }
  
  .popular-content h5 a {
    color: #2c3e50;
    text-decoration: none;
  }
  
  .popular-content h5 a:hover {
    color: #007bff;
  }
  
  .popular-meta {
    font-size: 12px;
    color: #6c757d;
  }
  
  .latest-section {
    background: white;
    padding: 50px 20px;
    border-radius: 0;
    position: relative;
    box-shadow: none;
    border: none;
    border-top: 1px solid #e9ecef;
    margin: 0;
  }

  .latest-title {
    text-align: center;
    font-size: 28px;
    color: #2c3e50;
    margin-bottom: 40px;
    font-weight: 700;
    position: relative;
    padding-bottom: 15px;
  }

  .latest-title::after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
  }

  .latest-slider {
    position: relative;
    overflow: hidden;
    margin: 0;
  }

  .slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
  }

  .slider-wrapper {
    display: flex;
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    width: 100%;
  }

  .slide-item {
    flex: 0 0 33.333%;
    padding: 0 15px;
    box-sizing: border-box;
  }

  @media (max-width: 1024px) {
    .slide-item {
      flex: 0 0 50%;
    }
  }

  @media (max-width: 768px) {
    .slide-item {
      flex: 0 0 100%;
    }
  }
  
  .latest-card {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
    border: 1px solid #e9ecef;
    position: relative;
  }

  .latest-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
    border-color: #667eea;
  }

  .latest-card::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
  }

  .latest-card:hover::before {
    transform: scaleX(1);
  }

  /* Custom Navigation */
  .slider-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all 0.3s ease;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .slider-nav:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
  }

  .slider-nav.prev {
    left: -22px;
  }

  .slider-nav.next {
    right: -22px;
  }

  .slider-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
  }

  .slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #667eea;
    opacity: 0.3;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .slider-dot.active {
    opacity: 1;
    transform: scale(1.2);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }


  
  .latest-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    position: relative;
  }

  .latest-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
  }

  .latest-card:hover .latest-image img {
    transform: scale(1.05);
  }

  .latest-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
    background: white;
  }

  .latest-content h4 {
    font-size: 18px;
    margin: 0 0 12px 0;
    color: #2c3e50;
    font-weight: 600;
    line-height: 1.4;
    min-height: 50px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .latest-content h4 a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
  }

  .latest-content h4 a:hover {
    color: #667eea;
  }

  .latest-excerpt {
    color: #6c757d;
    font-size: 15px;
    margin-bottom: 20px;
    line-height: 1.6;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .latest-meta {
    font-size: 13px;
    color: #8e9aaf;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid #e9ecef;
    display: flex;
    align-items: center;
    gap: 15px;
  }

  .latest-meta i {
    color: #667eea;
  }
  
  @media (max-width: 768px) {
    .blog-main {
      flex-direction: column;
      padding: 20px 15px;
    }

    .blog-wrapper {
      padding: 0;
    }

    .blog-content, .blog-sidebar {
      padding: 20px;
    }

    .blog-title {
      font-size: 22px;
    }

    .latest-section {
      padding: 30px 15px;
    }

    .latest-title {
      font-size: 22px;
      margin-bottom: 25px;
    }

    .latest-slider {
      margin: 0;
    }

    .slide-item {
      padding: 0 10px;
    }

    .slider-nav {
      width: 35px;
      height: 35px;
      font-size: 14px;
    }

    .slider-nav.prev {
      left: -17px;
    }

    .slider-nav.next {
      right: -17px;
    }

    .latest-content {
      padding: 20px;
    }

    .latest-content h4 {
      font-size: 16px;
      min-height: 45px;
    }

    .latest-excerpt {
      font-size: 14px;
    }

    .latest-meta {
      font-size: 12px;
    }
  }

  @media (max-width: 480px) {
    .slider-nav {
      display: none;
    }

    .latest-image {
      height: 160px;
    }

    .slide-item {
      padding: 0 5px;
    }
  }
</style>

<div class="blog-wrapper">
  @if($dataBlog)
  <!-- Main Content -->
  <div class="blog-main">
    <!-- Left Content -->
    <div class="blog-content">
      <h1 class="blog-title">{{ $dataBlog->name_blog }}</h1>

      @if($dataBlog->image_blog)
      <div class="blog-image-container">
        <img src="{{ $dataBlog->image_blog }}" alt="{{ $dataBlog->name_blog }}" class="blog-main-image">
      </div>
      @endif

      <div class="blog-meta">
        <div class="meta-item">
          <i class="fas fa-user"></i>
          <span>{{ $dataBlog->author_name ?? 'Tác giả không xác định' }}</span>
        </div>
        <div class="meta-item">
          <i class="fas fa-calendar"></i>
          <span>{{ date('d/m/Y', strtotime($dataBlog->date_blog)) }}</span>
        </div>
        <div class="meta-item">
          <i class="fas fa-eye"></i>
          <span>{{ number_format($dataBlog->view_blog) }} lượt xem</span>
        </div>
        <div class="meta-item" id="likeBtnWrapper">
          <button id="likeBtn" class="btn btn-link p-0" style=" color: #666666; text-decoration: none; font-size: 16px; outline: none; border: none; background: transparent;">
            <i id="likeIcon" class="fa-regular fa-bookmark"></i> <span  id="likeText">Lưu</span>
          </button>
        </div>
      </div>

      @if($dataBlog->description_blog)
      <div class="blog-description">
        <h3><i>Mô tả bài viết</i></h3>
        <p><i>{!! $dataBlog->description_blog !!}</i></p>
      </div>
      @endif

      <div class="blog-content-text">
        {!! $dataBlog->content_blog !!}
      </div>
    </div>
    
    <!-- Right Sidebar -->
    <div class="blog-sidebar">
      <!-- Categories -->
      <div class="sidebar-box">
        <h3 class="sidebar-title">Danh mục bài viết</h3>
        @if(isset($dataBlogCategory) && $dataBlogCategory->count() > 0)
        @foreach($dataBlogCategory as $category)
        <a href="{{ route('user.blogList') }}?category={{ $category->id }}" class="category-item">
          <span>{{ $category->name_category_blog }}</span>
          <i>→</i>
        </a>
        @endforeach
        @endif
        <a href="{{ route('user.blogList') }}" class="category-item" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-color: #667eea;">
          <span>Xem tất cả bài viết</span>
          <i>→</i>
        </a>
      </div>
      
      <!-- Popular Posts -->
      @if(isset($popularBlogs) && $popularBlogs->count() > 0)
      <div class="sidebar-box">
        <h3 class="sidebar-title">Bài viết phổ biến</h3>
        @foreach($popularBlogs as $blog)
        <div class="popular-item">
          <div class="popular-image">
            <a href="{{ route('user.blogDetail', $blog->id) }}"><img src="{{ $blog->image_blog }}" alt="{{ $blog->name_blog }}"></a>
          </div>
          <div class="popular-content">
            <h5><a href="{{ route('user.blogDetail', $blog->id) }}">{{ Str::limit($blog->name_blog, 50) }}</a></h5>
            <div class="popular-meta">
              <i class="fas fa-eye"></i> {{ number_format($blog->view_blog) }} | <i class="fas fa-calendar"></i> {{ date('d/m/Y', strtotime($blog->date_blog)) }}
            </div>
          </div>
        </div>
        @endforeach
      </div>
      @endif
    </div>
  </div>
  @else
  <div style="background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; text-align: center;">
    <strong>❌ Không tìm thấy bài viết!</strong>
  </div>
  @endif
  
  <!-- Latest Posts -->
  @if(isset($latestBlogs) && $latestBlogs->count() > 0)
  <div class="latest-section">
    <h2 class="latest-title">Các bài viết mới nhất</h2>
    <div class="latest-slider">
      <div class="slider-container">
        <div class="slider-wrapper" id="sliderWrapper">
          @foreach($latestBlogs as $blog)
          <div class="slide-item">
            <div class="latest-card">
              <div class="latest-image">
                <a href="{{ route('user.blogDetail', $blog->id) }}"><img src="{{ $blog->image_blog }}" alt="{{ $blog->name_blog }}"></a>
              </div>
              <div class="latest-content">
                <h4><a href="{{ route('user.blogDetail', $blog->id) }}">{{ $blog->name_blog }}</a></h4>
                <p class="latest-excerpt">{{ Str::limit($blog->description_blog, 80) }}</p> 
                <div class="latest-meta">
                  <i class="fas fa-user"></i> {{ $blog->author_name ?? 'Tác giả không xác định' }} | <i class="fas fa-calendar"></i> {{ date('d/m/Y', strtotime($blog->date_blog)) }} | <i class="fas fa-eye"></i> {{ ($blog->view_blog) }}
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        <!-- Navigation buttons -->
        <button class="slider-nav next" id="prevBtn">></button>
        <button class="slider-nav prev" id="nextBtn"><</button>
      </div>
      <!-- Pagination dots -->
      <div class="slider-dots" id="sliderDots"></div>
    </div>
  </div>
  @endif
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const sliderWrapper = document.getElementById('sliderWrapper');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotsContainer = document.getElementById('sliderDots');

  if (!sliderWrapper) {
    console.log('Slider not found');
    return;
  }

  const slides = sliderWrapper.querySelectorAll('.slide-item');
  const totalSlides = slides.length;

  if (totalSlides === 0) {
    console.log('No slides found');
    return;
  }

  let currentIndex = 0;
  let slidesToShow = getSlidesToShow();
  let maxIndex = Math.max(0, totalSlides - slidesToShow);
  let autoSlideInterval;

  // Get number of slides to show based on screen size
  function getSlidesToShow() {
    if (window.innerWidth >= 1024) return 3;
    if (window.innerWidth >= 768) return 2;
    return 1;
  }

  // Create dots
  function createDots() {
    dotsContainer.innerHTML = '';
    const dotsCount = Math.ceil(totalSlides / slidesToShow);

    for (let i = 0; i < dotsCount; i++) {
      const dot = document.createElement('div');
      dot.className = 'slider-dot';
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => goToSlide(i * slidesToShow));
      dotsContainer.appendChild(dot);
    }
  }

  // Update slider position
  function updateSlider() {
    const translateX = -(currentIndex * (100 / slidesToShow));
    sliderWrapper.style.transform = `translateX(${translateX}%)`;

    // Update dots
    const dots = dotsContainer.querySelectorAll('.slider-dot');
    dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === Math.floor(currentIndex / slidesToShow));
    });
  }

  // Go to specific slide
  function goToSlide(index) {
    currentIndex = Math.max(0, Math.min(index, maxIndex));
    updateSlider();
  }

  // Next slide - auto advance one by one
  function nextSlide() {
    currentIndex++;
    if (currentIndex > maxIndex) {
      currentIndex = 0; // Loop back to start smoothly
    }
    updateSlider();
  }

  // Previous slide - manual control
  function prevSlide() {
    currentIndex--;
    if (currentIndex < 0) {
      currentIndex = maxIndex; // Loop to end
    }
    updateSlider();
  }

  // Manual next slide - jump by slidesToShow
  function manualNext() {
    currentIndex += slidesToShow;
    if (currentIndex > maxIndex) {
      currentIndex = 0;
    }
    updateSlider();
  }

  // Manual previous slide - jump by slidesToShow
  function manualPrev() {
    currentIndex -= slidesToShow;
    if (currentIndex < 0) {
      currentIndex = maxIndex;
    }
    updateSlider();
  }

  // Auto slide - continuous movement from left to right
  function startAutoSlide() {
    autoSlideInterval = setInterval(nextSlide, 3000); // Smooth continuous movement
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  // Event listeners - use manual functions for button clicks
  if (nextBtn) nextBtn.addEventListener('click', manualNext);
  if (prevBtn) prevBtn.addEventListener('click', manualPrev);

  // Pause auto-slide on hover
  sliderWrapper.addEventListener('mouseenter', stopAutoSlide);
  sliderWrapper.addEventListener('mouseleave', startAutoSlide);

  // Handle window resize
  window.addEventListener('resize', function() {
    slidesToShow = getSlidesToShow();
    maxIndex = Math.max(0, totalSlides - slidesToShow);
    currentIndex = Math.min(currentIndex, maxIndex);
    createDots();
    updateSlider();
  });

  // Initialize
  createDots();
  updateSlider();
  startAutoSlide();

  console.log('✅ Custom slider initialized successfully!');
  console.log(`Total slides: ${totalSlides}, Slides to show: ${slidesToShow}`);
});

// AJAX Like/Unlike
const likeBtn = document.getElementById('likeBtn');
const likeIcon = document.getElementById('likeIcon');
const likeText = document.getElementById('likeText');
@if(isset($dataBlog) && $dataBlog)
const blogId = {{ $dataBlog->id }};
@else
const blogId = null;
@endif

function updateLikeUI(liked) {
  if (liked) {
    likeIcon.classList.remove('fa-regular');
    likeIcon.classList.add('fa-solid');
    likeText.textContent = 'Đã lưu';
  } else {
    likeIcon.classList.remove('fa-solid');
    likeIcon.classList.add('fa-regular');
    likeText.textContent = 'Lưu';
  }
}

function checkLikeStatus() {
  @if(isset($dataBlog) && $dataBlog)
  fetch(`{{ url('/blog/'.$dataBlog->id.'/is-liked') }}`, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}',
    },
    body: JSON.stringify({ blog_id: blogId })
  })
  .then(res => res.json())
  .then(data => updateLikeUI(data.liked));
  @endif
}

if (likeBtn) {
  likeBtn.addEventListener('click', function(e) {
    e.preventDefault();
    @if(isset($dataBlog) && $dataBlog)
    fetch(`{{ url('/blog/'.$dataBlog->id.'/like') }}`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: JSON.stringify({ blog_id: blogId })
    })
    .then(async res => {
      if (res.status === 401) {
        // Hiển thị thông báo rõ ràng trên giao diện
        alert('Bạn cần đăng nhập để thích bài viết!');
        return null;
      }
      // Nếu không phải JSON, báo lỗi
      let data;
      try {
        data = await res.json();
      } catch (e) {
        alert('Có lỗi xảy ra, vui lòng thử lại!');
        return;
      }
      if (data && typeof data.liked !== 'undefined') updateLikeUI(data.liked);
    })
    .catch(() => {
      alert('Không thể kết nối máy chủ!');
    });
    @else
    alert('Blog không tồn tại!');
    @endif
  });
  checkLikeStatus();
}
</script>
@endpush
