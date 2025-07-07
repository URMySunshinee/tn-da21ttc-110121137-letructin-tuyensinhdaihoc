@extends('admin.layout')
@section('title', "Chỉnh sửa khối ngành {$dataMajorCategory->name_category_major}")
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Majors Categories</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Cập nhật khối ngành</li>
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
      <div class="row">
  <div class="col-12">
    <div class="card my-4">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Cập nhật khối ngành</h6>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <form action="" method="POST" class="container mt-4">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label for="title" class="form-label">Tên khối ngành</label>
            <input type="text" class="form-control border p-2" id="title" name="name_category_major"
              value="{{ old('name_category_major', $dataMajorCategory->name_category_major ) }}" required placeholder="Điền tên khoa">
          </div>
          <a href="{{ route('admin.majorCategory') }}" class="btn btn-secondary me-2">Hủy</a>
          <button type="submit" class="btn btn-success">Cập nhật</button>
          
        </form>
      </div>
    </div>
  </div>
</div>

    </div>
</main>
  @endsection
  @section('scripts')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.js"></script>
  <script>
    $(document).ready(function () {
      $('#editor').summernote({
        height: 1000,
        placeholder: 'Nhập nội dung...'
      });
    });
  </script>
@endsection