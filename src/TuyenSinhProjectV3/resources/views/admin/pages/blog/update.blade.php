@extends('admin.layout')
@section('title', "Sửa bài viết {$dataBlog->name_blog}")
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.css" rel="stylesheet">
@endsection
@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur"
            data-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-dataBlog text-sm"><a class="opacity-5 text-dark" href="javascript:;">Blogs</a>
                        </li>
                        <li class="breadcrumb-dataBlog text-sm text-dark active" aria-current="page"> /Cập nhật bài viết
                        </li>
                    </ol>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-dataBlogs-center">
                    </div>
                    <ul class="navbar-nav d-flex align-dataBlogs-center  justify-content-end">
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-2">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4 has-summernote">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Sửa bài viết</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <form action="" method="POST" enctype="multipart/form-data" class="container mt-4">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề bài viết</label>
                                    <input type="text" class="form-control border p-2" id="title" name="name_blog"
                                        value="{{ old('name_blog', $dataBlog->name_blog) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Tải ảnh bìa chọn file (mới nếu muốn thay)</label>

                                    {{-- Ảnh hiện tại --}}
                                    <img src="{{ asset($dataBlog->image_blog) }}" alt="Ảnh hiện tại"
                                        style="max-height: 200px;" class="mb-3 d-block">

                                    {{-- Upload file mới --}}
                                    <input class="form-control border" type="file" id="image_blog1" name="image_blog1">

                                    {{-- Nhập link ảnh nếu ảnh gốc là từ internet --}}
                                    <label class="form-label mt-3">Hoặc nhập link ảnh</label>
                                    <input class="form-control border p-2" type="text" id="image_blog2" name="image_blog2"
                                        value="{{ strpos($dataBlog->image_blog, 'imagesSource') === false ? $dataBlog->image_blog : '' }}">
                                </div>


                                <div class="mb-3">
                                    <label for="description_blog" class="form-label">Mô tả</label>
                                    <textarea class="form-control border p-2" id="description_blog" name="description_blog"
                                        rows="5"
                                        required>{{ old('description_blog', $dataBlog->description_blog) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="content_blog" class="form-label">Nội dung</label>
                                    <textarea class="form-control border p-2" id="editor" name="content_blog" rows="5"
                                        required>{{ old('content_blog', $dataBlog->content_blog) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="category_blog_id" class="form-label">Danh mục</label>
                                    <select class="form-control border p-2" name="category_blog_id">
                                        @foreach ($dataCategoryBlog as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $dataBlog->category_blog_id ? 'selected' : '' }}>
                                                {{ $category->name_category_blog }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-success">Cập nhật bài viết</button>
                                <a href="{{ route('admin.blog') }}" class="btn btn-secondary me-2">Hủy</a>
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