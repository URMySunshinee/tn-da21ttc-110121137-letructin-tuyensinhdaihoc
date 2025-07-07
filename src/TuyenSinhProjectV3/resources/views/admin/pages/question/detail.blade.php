@extends('admin.layout')
@section('title', "Yêu cầu tư vấn của {$question->name_request}")
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    {{-- Hiển thị thông báo flash message --}}
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{ route('admin.question') }}">Tư vấn chưa xử lý</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Chi tiết yêu cầu tư vấn</li>
          </ol>
        </nav>
      </div>
    </nav>
    <div class="container-fluid py-2">
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9"> <!-- Tăng độ rộng lên 10/12 hoặc 9/12 -->
          <div class="card my-4">
            <div class="card-header bg-gradient-dark text-white">
              <h5 style="color: white;" class="mb-0">Thông tin chi tiết yêu cầu tư vấn</h5>
            </div>
            <div class="card-body">
              <dl class="row">
                <dt class="col-sm-4">Tên người gửi</dt>
                <dd class="col-sm-8">{{ $question->name_request }}</dd>
                <dt class="col-sm-4">Email</dt>
                <dd class="col-sm-8">{{ $question->email_request }}</dd>
                <dt class="col-sm-4">Số điện thoại</dt>
                <dd class="col-sm-8">{{ $question->phone_request }}</dd>
                <dt class="col-sm-4">Thành phố</dt>
                <dd class="col-sm-8">{{ $question->name_city }}</dd>
                <dt class="col-sm-4">Ngày sinh</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($question->birth)->format('d-m-Y') }}</dd>
                <dt class="col-sm-4">Trường học</dt>
                <dd class="col-sm-8">{{ $question->school }}</dd>
                <dt class="col-sm-4">Ngành học quan tâm</dt>
                <dd class="col-sm-8"><b>{{ $question->name_major }}</b></dd>
                <dt class="col-sm-4">Ngày gửi yêu cầu</dt>
                <dd class="col-sm-8">{{ \Carbon\Carbon::parse($question->date_request)->format('d-m-Y H:i:s') }}</dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container-fluid py-2">
      <div  class="row justify-content-center">
        <div  class="col-lg-10 col-xl-12"> <!-- Tăng độ rộng lên 10/12 hoặc 9/12 -->
          <div class="card my-4">
            <div class="card-header bg-gradient-dark text-white">
              <h5 style="color: white;" class="mb-0">Trả lời tư vấn</h5>
            </div>              
              {{-- Form trả lời tư vấn qua email --}}
              <form action="{{ route('admin.question.reply', ['id' => $question->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="email_request" value="{{ $question->email_request }}">
                <input type="hidden" name="name_request" value="{{ $question->name_request }}">
                <input type="hidden" name="id" value="{{ $question->id }}">
                <div style="padding-top: 10px; padding-left: 10px;" class="mb-3">
                  <label for="subject" class="form-label">Tiêu đề email</label>
                  <input style="border: 1px solid #ced4da; padding-left: 10px;" type="text" class="form-control" id="subject" name="subject" required value="Chào bạn {{ $question->name_request }}! Đây là phản hồi yêu cầu tư vấn ngành {{ $question->name_major }} từ Đại học Trà Vinh.">
                </div>
                <div class="mb-3">
                  <label style="padding-left: 10px;" for="content" class="form-label">Nội dung email</label>
                  <textarea class="form-control" id="editor" name="content" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Gửi email</button>
                <a href="{{ route('admin.question') }}" class="btn btn-secondary ms-2">Quay lại</a>
              </form>
              {{-- End form trả lời tư vấn --}}
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
            height: 200,
            placeholder: 'Nhập nội dung để trả lời tư vấn...'
        });
    });
</script>
@endsection