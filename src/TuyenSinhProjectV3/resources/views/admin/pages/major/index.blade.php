@extends('admin.layout')
@section('title', 'Quản lý ngành học')
@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style>
    .select2-container--default .select2-selection--multiple {
      min-height: 38px;
      border: 1px solid #ced4da;
      border-radius: 0.375rem;
      padding: 0.25rem 0.5rem;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #1976d2;
      color: #fff;
      border: none;
      border-radius: 0.25rem;
      margin-top: 0.25rem;
    }
  </style>
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Majors</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Quản lý Ngành học</li>
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
            <label for="category" class="me-2">Lọc theo khối ngành:</label>
            <select name="category" id="category" class="form-control me-2" onchange="this.form.submit()">
              <option value="">Tất cả</option>
              @foreach ($dataMajorCategory as $item)
                <option value="{{$item->id}}" {{ request('category') == $item->id ? 'selected' : '' }}>{{$item->name_category_major}}</option>
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
                <h6 class="text-white text-capitalize ps-3">Danh sách ngành học</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã ngành</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lượt thích</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lượt truy cập</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày cập nhật</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($dataMajor as $item)
                        <tr>
                      <td>
                            <h6 class="text-xs text-secondary mb-0"> {{ Str::limit($item->name_major, 50) }}</h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">
                              @if($item->major_code)
                                {{$item->major_code}}
                              @else
                                <span class="text-muted">Chưa cập nhật</span>
                              @endif
                            </h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->like_major}}</h6>
                      </td>
                      <td>
                            <h6 class="text-xs text-secondary mb-0">{{$item->view_major}}</h6>
                      </td>
                      <td class="align-middle text-center">
                       <h6 class="text-xs text-secondary mb-0">{{$item->date_updated}}</h6>
                      </td>
                      <td class="align-middle text-center">
                        <a href="{{ route('admin.major.updateView',['id' => $item->id])}}" class="text-white font-weight-bold text-xs btn btn-secondary" data-toggle="tooltip" data-original-title="Edit user">
                          Sửa
                        </a>
                        @if ($item->status_major==0)
                        <form action="/admin/major/{{$item->id}}" method="POST">
                          @method('delete')
                          @csrf
                             <button type="submit" class="text-white font-weight-bold text-xs btn btn-danger" data-toggle="tooltip" data-original-title="Edit user">
                          Vô hiệu hóa
                        </button>
                        </form>
                        @else
                        <form action="/admin/major/restore/{{$item->id}}" method="POST">
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
                      @if ($dataMajor->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                      @else
                        <li class="page-item"><a class="page-link" href="{{ $dataMajor->previousPageUrl() }}">&laquo;</a></li>
                      @endif
                      @for ($i = 1; $i <= $dataMajor->lastPage(); $i++)
                        <li class="page-item {{ $i == $dataMajor->currentPage() ? 'active' : '' }}">
                          <a class="page-link" href="{{ $dataMajor->url($i) }}">{{ $i }}</a>
                        </li>
                      @endfor
                      @if ($dataMajor->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $dataMajor->nextPageUrl() }}">&raquo;</a></li>
                      @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                      @endif
                    </ul>
                  </nav>
                  <div>
                    <span class="text-sm text-secondary">
                      Hiển thị {{ $dataMajor->firstItem() }} đến {{ $dataMajor->lastItem() }} trong tổng số {{ $dataMajor->total() }} ngành học
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
                <h6 class="text-white text-capitalize ps-3">Thêm ngành học</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <form action="" method="POST"  class="container mt-4">
  @csrf

  <!-- Thông tin cơ bản -->
  <div class="row mb-4">
    <div class="col-md-8">
      <div class="mb-3">
        <label for="name_major" class="form-label">Tên ngành <p style="display: inline; color: red;">*</p></label>
        <input type="text" class="form-control border p-2" id="name_major" name="name_major" required placeholder="VD: Công nghệ thông tin">
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="major_code" class="form-label">Mã ngành <p style="display: inline; color: red;">*</p></label>
        <input type="text" class="form-control border p-2" id="major_code" name="major_code" required placeholder="VD: CNTT01">
      </div>
    </div>
  </div>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="mb-3">
        <label for="admission_quota" class="form-label">Chỉ tiêu <p style="display: inline; color: red;">*</p></label>
        <input type="number" min="1" class="form-control border p-2" id="admission_quota" name="admission_quota" required placeholder="VD: 100">
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="training_duration" class="form-label">Thời gian đào tạo <p style="display: inline; color: red;">*</p></label>
        <input type="number" step="0.5" min="1" max="10" class="form-control border p-2" id="training_duration" name="training_duration" required placeholder="VD: 4.0">
        <small class="text-muted">Đơn vị: năm (VD: 4.0, 3.5, 5.0)</small>
      </div>
    </div>
    <div class="col-md-4">
      <div class="mb-3">
        <label for="degree_level" class="form-label">Danh hiệu cấp bằng <p style="display: inline; color: red;">*</p></label>
        <input type="text" class="form-control border p-2" id="degree_level" name="degree_level" required placeholder="VD: Cử nhân Công nghệ thông tin">
      </div>
    </div>
  </div>

  <div class="mb-3">
    <label for="description_major" class="form-label">Mô tả ngắn <p style="display: inline; color: red;">*</p></label>
    <textarea class="form-control border p-2" id="description_major" name="description_major" rows="3" required placeholder="Mô tả ngắn gọn về ngành học..."></textarea>
  </div>

  <div class="mb-3">
    <label for="category_major_id" class="form-label">Thuộc về khối ngành <p style="display: inline; color: red;">*</p></label>
    <select class="form-control border p-2" name="category_major_id" required id="category_major_id">
      <option value="">-- Chọn khối ngành --</option>
      @foreach ($dataMajorCategory as $item)
      <option value="{{$item->id}}">{{$item->name_category_major}}</option>
      @endforeach
    </select>
  </div>

  <!-- Phương thức xét tuyển -->
  <div class="mb-4">
    <h6 class="text-primary">📋 Phương thức xét tuyển</h6>
    <div id="admission-methods-container">
      <!-- Sẽ được load bằng JavaScript -->
    </div>
  </div>

  <!-- Điểm chuẩn 5 năm -->
  <div class="mb-4" id="admission-scores-section" style="display: none;">
    <h6 class="text-primary">📊 Điểm chuẩn 5 năm gần nhất</h6>
    <div id="admission-scores-container">
      <!-- Sẽ được load bằng JavaScript -->
    </div>
  </div>

  <!-- Nội dung ngành học -->
  <div class="mb-4">
    <h6 class="text-primary">📖 Thông tin chi tiết</h6>

    <!-- <div class="mb-3">
      <label for="introduction" class="form-label">Giới thiệu ngành học</label>
      <textarea class="form-control border p-2" id="introduction" name="introduction" rows="4"
        placeholder="Giới thiệu tổng quan về ngành học..."></textarea>
    </div> -->

    <div class="mb-3">
      <label for="content_major" class="form-label">Giới thiệu ngành học <p style="display: inline; color: red;">*</p></label>
      <textarea class="form-control border p-2" id="editor" name="content_major" rows="5"
        placeholder="Nội dung giới thiệu về ngành học, chương trình đào tạo,..."></textarea>
    </div>

    <div class="mb-3">
      <label for="job_opportunities" class="form-label">Cơ hội việc làm <p style="display: inline; color: red;">*</p></label>
      <textarea class="form-control border p-2" id="editor1" name="job_opportunities" rows="4"
        placeholder="Mô tả các cơ hội việc làm sau khi tốt nghiệp..."></textarea>
    </div>

    <div class="mb-3">
      <label for="post_graduation_opportunities" class="form-label">Cơ hội sau đại học <p style="display: inline; color: red;">*</p></label>
      <textarea class="form-control border p-2" id="editor2" name="post_graduation_opportunities" rows="4"
        placeholder="Mô tả các cơ hội học tập, nghiên cứu sau đại học..."></textarea>
    </div>

    <div class="mb-3">
      <label for="contact_info" class="form-label">Thông tin liên hệ <p style="display: inline; color: red;">*</p></label>
      <textarea class="form-control border p-2" id="editor3" name="contact_info" rows="3"
        placeholder="Thông tin liên hệ của khoa/ngành..."></textarea>
    </div>

  </div>

  <div class="d-flex justify-content-end">
    <button type="reset" class="btn btn-secondary me-2">Làm mới</button>
    <button type="submit" class="btn btn-success">Thêm ngành học</button>
  </div>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script>
    let admissionMethods = [];
    let subjectCombinations = [];
    let selectedAdmissionMethods = [];

    $(document).ready(function () {
      $('#editor').summernote({
        height: 200,
        placeholder: 'Nhập nội dung giới thiệu về ngành học, chương trình đào tạo,...'
      });

      $('#editor1').summernote({
        height: 200,
        placeholder: 'Mô tả các cơ hội việc làm sau khi tốt nghiệp...'
      });

      $('#editor2').summernote({
        height: 200,
        placeholder: 'Mô tả các cơ hội học tập, nghiên cứu sau đại học...'
      });

      $('#editor3').summernote({
        height: 200,
        placeholder: 'Nhập thông tin liên hệ...'
      });

      // Load dữ liệu theo thứ tự
      loadSubjectCombinations();
      loadAdmissionMethods();
    });

    // Load phương thức xét tuyển
    function loadAdmissionMethods() {
      fetch('/api/admission-methods/active')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          admissionMethods = data;
          renderAdmissionMethods();
        })
        .catch(error => {
          console.error('Error loading admission methods:', error);
          // Fallback với dữ liệu trống
          admissionMethods = [];
          renderAdmissionMethods();
        });
    }

    // Load tổ hợp môn
    function loadSubjectCombinations() {
      fetch('/api/subject-combinations/active')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          subjectCombinations = data;
        })
        .catch(error => {
          console.error('Error loading subject combinations:', error);
          subjectCombinations = [];
        });
    }

    // Render phương thức xét tuyển
    function renderAdmissionMethods() {
      const container = document.getElementById('admission-methods-container');
      let html = '<div class="row">';

      admissionMethods.forEach(method => {
        html += `
          <div class="col-md-6 mb-3">
            <div class="card border">
              <div class="card-body p-3">
                <div class="form-check">
                  <input class="form-check-input admission-method-checkbox" type="checkbox"
                         name="admission_methods[]"
                         value="${method.id}"
                         id="method_${method.id}"
                         onchange="handleAdmissionMethodChange(${method.id}, ${method.requires_subject_combinations})">
                  <label class="form-check-label" for="method_${method.id}">
                    <strong>${method.name}</strong>
                  </label>
                </div>
                <small class="text-muted d-block mt-1">${method.description}</small>

                ${method.requires_subject_combinations ? `
                  <div class="mt-3 subject-combinations-section" id="subject_combinations_${method.id}"
                       style="display: none;">
                    <label class="form-label text-sm">Tổ hợp môn xét tuyển:</label>
                    <div id="combinations_for_method_${method.id}">
                      <!-- Sẽ được render bằng JS -->
                    </div>
                  </div>
                ` : ''}
              </div>
            </div>
          </div>
        `;
      });

      html += '</div>';
      container.innerHTML = html;

      updateAdmissionScoresVisibility();
    }

    // Xử lý khi thay đổi phương thức xét tuyển
    function handleAdmissionMethodChange(methodId, requiresSubjectCombinations) {
      const checkbox = document.getElementById(`method_${methodId}`);
      const subjectCombinationsSection = document.getElementById(`subject_combinations_${methodId}`);

      if (checkbox.checked) {
        if (!selectedAdmissionMethods.includes(methodId)) {
          selectedAdmissionMethods.push(methodId);
        }

        // Hiển thị tổ hợp môn cho cả THPT và Học bạ
        if (requiresSubjectCombinations && subjectCombinationsSection) {
          subjectCombinationsSection.style.display = 'block';
          renderSubjectCombinationsForMethod(methodId);
        }
      } else {
        selectedAdmissionMethods = selectedAdmissionMethods.filter(id => id !== methodId);

        if (subjectCombinationsSection) {
          subjectCombinationsSection.style.display = 'none';
        }
      }

      updateAdmissionScoresVisibility();
    }

    // Render tổ hợp môn cho phương thức cụ thể (dùng select2)
    function renderSubjectCombinationsForMethod(methodId) {
      const container = document.getElementById(`combinations_for_method_${methodId}`);
      if (!container) return;
      let html = `<select class="form-control subject-combinations-select" name="subject_combinations[${methodId}][]" multiple="multiple" style="width:100%">`;
      subjectCombinations.forEach(combination => {
        html += `<option value="${combination.id}"><strong>${combination.code}</strong> - ${combination.name} (${combination.subjects})</option>`;
      });
      html += '</select>';
      container.innerHTML = html;
      // Khởi tạo select2
      $(`#combinations_for_method_${methodId} .subject-combinations-select`).select2({
        placeholder: 'Chọn tổ hợp môn...',
        allowClear: true,
        width: 'resolve',
        dropdownParent: $(`#combinations_for_method_${methodId}`)
      });
    }

    // Cập nhật hiển thị section điểm chuẩn
    function updateAdmissionScoresVisibility() {
      const scoresSection = document.getElementById('admission-scores-section');
      if (selectedAdmissionMethods.length > 0) {
        scoresSection.style.display = 'block';
        renderAdmissionScores();
      } else {
        scoresSection.style.display = 'none';
      }
    }

    // Render điểm chuẩn 5 năm
    function renderAdmissionScores() {
      const container = document.getElementById('admission-scores-container');
      const currentYear = new Date().getFullYear();
      const years = [];
      for (let i = 0; i < 5; i++) {
        years.push(currentYear - i);
      }

      let html = '<div class="table-responsive"><table class="table table-bordered">';
      html += '<thead><tr><th>Phương thức xét tuyển</th>';
      years.forEach(year => {
        html += `<th class="text-center">${year}</th>`;
      });
      html += '</tr></thead><tbody>';

      selectedAdmissionMethods.forEach(methodId => {
        const method = admissionMethods.find(m => m.id === methodId);
        if (!method) return;

        // Chỉ hiển thị một dòng cho mỗi phương thức, không phân chia theo tổ hợp môn
        html += `<tr><td><strong>${method.name}</strong></td>`;
        years.forEach(year => {
          html += `<td><input type="number" step="0.01" min="0" max="1000" class="form-control form-control-sm"
                   name="scores[${methodId}][${year}]"
                   value=""
                   placeholder="0.00"></td>`;
        });
        html += '</tr>';
      });

      html += '</tbody></table></div>';
      container.innerHTML = html;
    }
  </script>
@endsection
