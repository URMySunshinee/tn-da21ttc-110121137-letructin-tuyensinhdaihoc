@extends('admin.layout')
@section('title', 'Quản lý khối ngành')
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
    @if(session('info'))
      <div style="color: white; text-align: center;" class="alert alert-info alert-dismissible fade show mt-3" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Department</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Quản lý Khối ngành</li>
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
                <h6 class="text-white text-capitalize ps-3">Danh sách khối ngành</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên khối ngành</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dataMajorCategory as $item)
                        <tr>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->name_category_major}}</h6>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ route('admin.majorCategory.updateView',['id' => $item->id])}}" class="text-white font-weight-bold text-xs btn btn-secondary" data-toggle="tooltip" data-original-title="Edit user">
                          Sửa
                        </a>
                        @if ($item->status_category_major==0)
                        <form action="/admin/major-category/{{$item->id}}" method="POST">
                          @method('delete')
                          @csrf
                             <button type="submit" class="text-white font-weight-bold text-xs btn btn-danger" data-toggle="tooltip" data-original-title="Edit user">
                          Vô hiệu hóa
                        </button>
                        </form>
                        @else
                        <form action="/admin/major-category/restore/{{$item->id}}" method="POST">
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
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Thêm khối ngành</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <form action="" method="POST"  class="container mt-4">
  @csrf
  <div class="mb-3">
    <label for="title" class="form-label">Tên khối ngành</label>
    <input type="text" class="form-control border p-2" id="title" name="name_category_major" required placeholder="Điền tên khối ngành">
  </div>

  <button type="submit" class="btn btn-primary">Thêm</button>
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
        height: 1000,
        placeholder: 'Nhập nội dung...'
      });
    });
  </script>
@endsection
