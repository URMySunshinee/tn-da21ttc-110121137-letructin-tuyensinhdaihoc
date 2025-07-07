@extends('admin.layout')
@section('title', 'Yêu cầu tư vấn đã xử lý')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Questions</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Yêu cầu đã xử lý</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center"></div>
          <ul class="navbar-nav d-flex align-items-center  justify-content-end"></ul>
        </div>
      </div>
    </nav>
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
          <div class="col-md-6 text-end">
            <a href="{{ route('admin.question') }}" class="btn btn-danger">Quay lại danh sách chưa xử lý</a>
          </div>
        </div>
      </form>
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Danh sách yêu cầu tư vấn <span class="badge bg-success">Đã xử lý</span></h6>
              </div>
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
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($dataQuestionsDone as $item)
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
                            <h6 class="text-xs text-secondary mb-0">{{$item->date_request}}</h6>
                      </td>
                      <td class="align-middle text-center">
                        <span class="text-white font-weight-bold text-xs btn btn-success">Đã xử lý</span>
                      </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center">Không có yêu cầu tư vấn nào đã xử lý.</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <div class="d-flex flex-column align-items-center mt-3">
                <nav aria-label="Page navigation">
                  <ul class="pagination pagination-lg mb-2">
                    @if ($dataQuestionsDone->onFirstPage())
                      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                      <li class="page-item"><a class="page-link" href="{{ $dataQuestionsDone->previousPageUrl() }}">&laquo;</a></li>
                    @endif
                    @for ($i = 1; $i <= $dataQuestionsDone->lastPage(); $i++)
                      <li class="page-item {{ $i == $dataQuestionsDone->currentPage() ? 'active' : '' }}">
                        <a class="page-link" href="{{ $dataQuestionsDone->url($i) }}">{{ $i }}</a>
                      </li>
                    @endfor
                    @if ($dataQuestionsDone->hasMorePages())
                      <li class="page-item"><a class="page-link" href="{{ $dataQuestionsDone->nextPageUrl() }}">&raquo;</a></li>
                    @else
                      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                  </ul>
                </nav>
                <div>
                  <span class="text-sm text-secondary">
                    Hiển thị {{ $dataQuestionsDone->firstItem() }} đến {{ $dataQuestionsDone->lastItem() }} trong tổng số {{ $dataQuestionsDone->total() }} yêu cầu tư vấn đã xử lý
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection
