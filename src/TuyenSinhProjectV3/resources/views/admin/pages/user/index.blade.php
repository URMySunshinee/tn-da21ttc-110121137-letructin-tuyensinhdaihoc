@extends('admin.layout')
@section('title', 'Quản lý người dùng')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Users</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Quản lý người dùng</li>
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
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                <h6 class="text-white text-capitalize ps-3">Danh sách người dùng</h6>
                <form action="" method="GET" class="d-flex" style="max-width:350px;">
                  <input type="text" name="keyword" class="form-control me-2 bg-transparent text-white" placeholder="Tìm tên hoặc email..." value="{{ request('keyword') }}" autocomplete="off">
                  <button class="btn btn-light" type="submit">Tìm kiếm</button>
                </form>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Địa chỉ</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tuổi</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày đăng ký</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dataUsers as $item)
                        <tr>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->name}}</h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->email}}</h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->address}}</h6>
                      </td>
                       <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->phone}}</h6>
                      </td>
                      <td class="align-middle text-center">
                       <h6 class="text-xs text-secondary mb-0">{{$item->age}}</h6>
                      </td>
                      <td class="align-middle text-center">
                       <h6 class="text-xs text-secondary mb-0">{{ $item->created_at }}</h6>
                      </td>
                      <td class="align-middle text-center">
                        @if ($item->status_user==0)
                        <form action="/admin/users/{{$item->id}}" method="POST">
                          @method('delete')
                          @csrf
                             <button type="submit" class="text-white font-weight-bold text-xs btn btn-danger" data-toggle="tooltip" data-original-title="Edit user">
                          Khóa người dùng
                        </button>
                        </form>
                        @else
                        <form action="/admin/users/restore/{{$item->id}}" method="POST">
                          @method('patch')
                          @csrf
                             <button type="submit" class="text-white font-weight-bold text-xs btn btn-success" data-toggle="tooltip" data-original-title="Edit user">
                          Khôi phục người dùng
                        </button>
                        </form>
                        @endif
                       
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <div class="d-flex flex-column align-items-center justify-content-center mt-3">
                <div>
                  @if ($dataUsers->total() > 0)
                    <span class="text-secondary">Hiển thị {{ $dataUsers->firstItem() }} đến {{ $dataUsers->lastItem() }} trong tổng số {{ $dataUsers->total() }} người dùng</span>
                  @else
                    <span class="text-secondary">Không có dữ liệu</span>
                  @endif
                </div>
                <div class="mt-2">
                  {{ $dataUsers->withQueryString()->links('pagination::bootstrap-4') }}
                </div>
              </div>
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

