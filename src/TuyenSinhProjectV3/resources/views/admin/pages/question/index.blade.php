@extends('admin.layout')
@section('title', 'Xử lý yêu cầu tư vấn')
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Questions</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Quản lý tư vấn</li>
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
      <form method="GET" action="" class="mb-3">
        <div class="row align-items-end">
          <div class="col-md-4">
            <label for="major_id" class="form-label">Lọc theo ngành học quan tâm</label>
            <select name="major_id" id="major_id" class="form-select">
              <option value="">-- Tất cả ngành học --</option>
              @foreach($majors as $major)
                <option value="{{$major->id}}" {{ request('major_id') == $major->id ? 'selected' : '' }}>{{$major->name_major}}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Lọc</button>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 d-flex justify-content-between align-items-center">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3 px-3">
                <h6 class="text-white text-capitalize mb-0">Danh sách yêu cầu tư vấn <span class="badge bg-danger">Chưa xử lý</span></h6>
              </div>
              <a href="{{ route('admin.questions.done') }}" class="btn btn-success me-3">Xem các yêu cầu đã xử lý</a>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Phone</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thành phố</th>     
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngành học quan tâm</th>          
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày đăng ký</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($dataQuestionsPending as $item)
                        <tr>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->name_request}}</h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->email_request}}</h6>
                      </td>
                       <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->phone_request}}</h6>
                      </td>
                       <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->name_city}}</h6>
                      </td>
                       <td>
                            <h6 class="text-xs text-secondary mb-0">{{ Str::limit($item->name_major, 20) }}</h6>
                      </td>
                       <td>
                            <h6 class="text-xs text-secondary mb-0">{{ \Carbon\Carbon::parse($item->date_request)->format('d/m/Y H:i:s') }}</h6>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ route('admin.question.detail', ['id' => $item->id]) }}" class="text-white font-weight-bold text-xs btn btn-info" data-toggle="tooltip" data-original-title="Xem chi tiết">
                          Xem chi tiết
                        </a>
                      </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Không có yêu cầu tư vấn nào chưa xử lý ở ngành này.</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div class="d-flex flex-column align-items-center mt-3">
                <nav aria-label="Page navigation">
                  <ul class="pagination pagination-lg mb-2">
                    @if ($dataQuestionsPending->onFirstPage())
                      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                      <li class="page-item"><a class="page-link" href="{{ $dataQuestionsPending->previousPageUrl() }}">&laquo;</a></li>
                    @endif
                    @for ($i = 1; $i <= $dataQuestionsPending->lastPage(); $i++)
                      <li class="page-item {{ $i == $dataQuestionsPending->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $dataQuestionsPending->url($i) }}">{{ $i }}</a>
                      </li>
                    @endfor
                    @if ($dataQuestionsPending->hasMorePages())
                      <li class="page-item"><a class="page-link" href="{{ $dataQuestionsPending->nextPageUrl() }}">&raquo;</a></li>
                    @else
                      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                  </ul>
                </nav>
                <div>
                  <span class="text-sm text-secondary">
                    Hiển thị {{ $dataQuestionsPending->firstItem() }} đến {{ $dataQuestionsPending->lastItem() }} trong tổng số {{ $dataQuestionsPending->total() }} yêu cầu tư vấn chưa xử lý
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Đã loại bỏ bảng Đã xử lý khỏi trang index, chỉ còn bảng Chưa xử lý và nút chuyển trang -->
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

