@extends('admin.layout')
@section('title', 'Thêm danh mục bài viết')
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
    <div class="container-fluid py-2">
        <div class="row mb-3">
            <div class="col-12">
                <h4>Thêm danh mục bài viết</h4>
                <form action="{{ route('admin.blogCategory.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name_category_blog" class="form-label">Tên danh mục *</label>
                        <input type="text" class="form-control" id="name_category_blog" name="name_category_blog" required>
                    </div>
                    <button type="submit" class="btn btn-success">Thêm danh mục</button>
                    <a href="{{ route('admin.blogCategory') }}" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
