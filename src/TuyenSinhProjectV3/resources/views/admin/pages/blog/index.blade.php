@extends('admin.layout')
@section('title', 'Quản lý bài viết')
@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    {{-- Hiển thị thông báo flash message --}}
    @if(session('success'))
      <div style="color: white; text-align: center;" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div style="color: white; text-align: center;" class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Blogs</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Quản lý bài viết</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end">
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row mb-3">
        <div class="col-12">
          <form method="GET" action="" class="form-inline">
            <label for="category" class="me-2">Lọc theo danh mục:</label>
            <select name="category" id="category" class="form-control me-2" onchange="this.form.submit()">
              <option value="">Tất cả</option>
              @foreach ($dataCategoryBlog as $item)
                <option value="{{$item->id}}" {{ request('category') == $item->id ? 'selected' : '' }}>{{$item->name_category_blog}}</option>
              @endforeach
            </select>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Danh sách bài viết</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tác giả</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ảnh</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lượt xem</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Danh mục</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày đăng</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dataBlog as $item)
                        <tr>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{ Str::limit($item->name_blog, 50) }}</h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->author_name}}</h6>
                      </td>
                      <td>
                        <img width="20%" src="{{$item->image_blog}}" alt="">
                      </td>
                      <td class="align-middle text-center text-sm">
                        <h6 class="text-xs text-secondary mb-0">{{$item->view_blog}}</h6>
                      </td>
                      <td class="align-middle text-center">
                        <h6 class="text-xs text-secondary mb-0">{{$item->name_category_blog}}</h6>
                      </td>
                      <td class="align-middle text-center">
                       <h6 class="text-xs text-secondary mb-0">{{ Carbon\Carbon::parse($item->date_blog)->format('d/m/Y H:i:s') }}</h6>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ route('admin.blog.updateView',['id' => $item->id])}}" class="text-white font-weight-bold text-xs btn btn-secondary" data-toggle="tooltip" data-original-title="Edit user">
                          Sửa
                        </a>
                        @if ($item->status_blog==0)
                        <form action="/admin/blog/{{$item->id}}" method="POST">
                          @method('delete')
                          @csrf
                             <button type="submit" class="text-white font-weight-bold text-xs btn btn-danger" data-toggle="tooltip" data-original-title="Edit user">
                          Vô hiệu hóa
                        </button>
                        </form>
                        @else
                        <form action="/admin/blog/restore/{{$item->id}}" method="POST">
                          @method('patch')
                          @csrf
                             <button type="submit" class="text-white font-weight-bold text-xs btn btn-success" data-toggle="tooltip" data-original-title="Edit user">
                          Khôi phục
                        </button>
                        </form>
                        @endif
                      
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                <div class="d-flex flex-column align-items-center mt-3">
                  <nav aria-label="Page navigation">
                    <ul class="pagination pagination-lg mb-2">
                      @if ($dataBlog->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                      @else
                        <li class="page-item"><a class="page-link" href="{{ $dataBlog->previousPageUrl() }}">&laquo;</a></li>
                      @endif
                      @for ($i = 1; $i <= $dataBlog->lastPage(); $i++)
                        <li class="page-item {{ $i == $dataBlog->currentPage() ? 'active' : '' }}">
                          <a class="page-link" href="{{ $dataBlog->url($i) }}">{{ $i }}</a>
                        </li>
                      @endfor
                      @if ($dataBlog->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $dataBlog->nextPageUrl() }}">&raquo;</a></li>
                      @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                      @endif
                    </ul>
                  </nav>
                  <div>
                    <span class="text-sm text-secondary">
                      Hiển thị {{ $dataBlog->firstItem() }} đến {{ $dataBlog->lastItem() }} trong tổng số {{ $dataBlog->total() }} bài viết
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card my-4 has-summernote">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Thêm bài viết</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <form action="" method="POST" enctype="multipart/form-data" class="container mt-4">
  @csrf
  <div class="mb-3">
    <label for="title" class="form-label">Tiêu đề bài viết</label>
    <input type="text" class="form-control border p-2" id="title" name="name_blog" required placeholder="Điền tên bài viết">
  </div>

 <div class="mb-3">
    <label for="image" class="form-label">Tải ảnh bìa. Hiển thị tốt nhất (275 x 183)px</label> 
    <input class="form-control border" type="file" id="image_blog1" name="image_blog1">
    <label for="image" class="form-label  mt-3">Tải ảnh bìa bằng link ảnh</label>
    <input class="form-control border p-2" type="text" id="image_blog2" name="image_blog2">
  </div>
<div class="mb-3">
    <label for="content" class="form-label">Mô tả</label>
    <textarea class="form-control border p-2" id="content" name="description_blog" rows="5" required placeholder="Viết mô tả cho bài viết"></textarea>
  </div>
  <div class="mb-3">
    <label for="content"  class="form-label">Nội dung</label>
    <textarea class="form-control border p-2" id="editor" name="content_blog" rows="5" required placeholder="Viết nội dung cho bài viết"></textarea>
  </div>

 <div class="mb-3">
    <label for="content" class="form-label">Danh mục</label>
    <select class="form-control border p-2" name="category_blog_id" id="">
      @foreach ($dataCategoryBlog as $item)
        <option value="{{$item->id}}">{{$item->name_category_blog}}</option>
      @endforeach
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Đăng bài viết</button>
</form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  @endsection
  @section('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.js"></script>
  <script>
    $(document).ready(function () {
      $('#editor').summernote({
        height: 200,
        placeholder: 'Nhập nội dung...',
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ],
        styleTags: [
          'p', 'blockquote', 'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
        ],
        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica Neue', 'Helvetica', 'Impact', 'Lucida Grande', 'Tahoma', 'Times New Roman', 'Verdana'],
        fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
        callbacks: {
          onPaste: function (e) {
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            document.execCommand('insertText', false, bufferText);
          }
        }
      });
    });
    
  </script>
  <script>
  $(document).ready(function () {
    $('#image_blog1').on('change', function () {
      if ($(this).val()) {
        $('#image_blog2').val('');
      }
    });

    $('#image_blog2').on('input', function () {
      if ($(this).val().trim() !== '') {
        $('#image_blog1').val('');
      }
    });
  });
</script>
@endsection
