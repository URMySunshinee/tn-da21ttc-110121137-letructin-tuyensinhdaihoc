@extends('admin.layout')
@section('title', "Cập nhật ngành {$dataMajor->name_major}")
@section('styles')
  <link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
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
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Majors</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Cập nhật ngành học</li>
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
    <div class="card my-4 has-summernote">
      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Cập nhật ngành học</h6>
        </div>
      </div>
      <div class="card-body px-0 pb-2">
        <form action="{{ route('admin.major.update', $dataMajor->id) }}" method="POST" class="container mt-4">
          @csrf
          @method('PUT')

          <!-- Thông tin cơ bản -->
          <div class="row mb-4">
            <div class="col-md-8">
              <div class="mb-3">
                <label for="name_major" class="form-label">Tên ngành *</label>
                <input type="text" class="form-control border p-2" id="name_major" name="name_major"
                  value="{{ old('name_major', $dataMajor->name_major) }}" required placeholder="VD: Công nghệ thông tin">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="major_code" class="form-label">Mã ngành *</label>
                <input type="text" class="form-control border p-2" id="major_code" name="major_code"
                  value="{{ old('major_code', $dataMajor->major_code) }}" required placeholder="VD: CNTT01">
              </div>
            </div>
          </div>

          <div class="row mb-4">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="admission_quota" class="form-label">Chỉ tiêu *</label>
                <input type="number" min="1" class="form-control border p-2" id="admission_quota" name="admission_quota"
                  value="{{ old('admission_quota', $dataMajor->admission_quota) }}" required placeholder="VD: 100">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="training_duration" class="form-label">Thời gian đào tạo *</label>
                <input type="number" step="0.5" min="1" max="10" class="form-control border p-2" id="training_duration" name="training_duration"
                  value="{{ old('training_duration', $dataMajor->training_duration) }}" required placeholder="VD: 4.0">
                <small class="text-muted">Đơn vị: năm (VD: 4.0, 3.5, 5.0)</small>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label for="degree_level" class="form-label">Danh hiệu cấp bằng *</label>
                <input type="text" class="form-control border p-2" id="degree_level" name="degree_level"
                  value="{{ old('degree_level', $dataMajor->degree_level) }}" required placeholder="VD: Cử nhân Công nghệ thông tin">
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="description_major" class="form-label">Mô tả ngắn *</label>
            <textarea class="form-control border p-2" id="description_major" name="description_major" rows="3" required
              placeholder="Mô tả ngắn gọn về ngành học...">{{ old('description_major', $dataMajor->description_major) }}</textarea>
          </div>

          <div class="mb-3">
            <label for="category_major_id" class="form-label">Thuộc về khối ngành *</label>
            <select class="form-control border p-2" name="category_major_id" required id="category_major_id">
              @foreach ($dataMajorCategory as $item)
                <option value="{{$item->id}}" {{ $item->id == $dataMajor->category_major_id ? 'selected' : '' }}>
                  {{$item->name_category_major}}
                </option>
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
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h6 class="text-primary mb-0">📊 Điểm chuẩn 5 năm gần nhất</h6>
              <button type="button" class="btn btn-sm btn-outline-primary" onclick="reloadAdmissionScores()">
                <i class="fas fa-refresh"></i> Tải lại điểm chuẩn
              </button>
            </div>
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
                placeholder="Giới thiệu tổng quan về ngành học...">{{ old('introduction', $dataMajor->introduction) }}</textarea>
            </div> -->

            <div class="mb-3">
              <label for="content_major" class="form-label">Giới thiệu ngành học</label>
              <textarea class="form-control border p-2" id="editor" name="content_major" rows="5"
                placeholder="Nội dung chi tiết về chương trình đào tạo...">{{ old('content_major', $dataMajor->content_major) }}</textarea>
            </div>

            <div class="mb-3">
              <label for="job_opportunities" class="form-label">Cơ hội việc làm</label>
              <textarea class="form-control border p-2" id="editor1" name="job_opportunities" rows="4"
                placeholder="Mô tả các cơ hội việc làm sau khi tốt nghiệp...">{{ old('job_opportunities', $dataMajor->job_opportunities) }}</textarea>
            </div>

            <div class="mb-3">
              <label for="post_graduation_opportunities" class="form-label">Cơ hội sau đại học</label>
              <textarea class="form-control border p-2" id="editor2" name="post_graduation_opportunities" rows="4"
                placeholder="Mô tả các cơ hội học tập, nghiên cứu sau đại học...">{{ old('post_graduation_opportunities', $dataMajor->post_graduation_opportunities) }}</textarea>
            </div>

            <div class="mb-3">
              <label for="contact_info" class="form-label">Thông tin liên hệ</label>
              <textarea class="form-control border p-2" id="editor3" name="contact_info" rows="3"
                placeholder="Thông tin liên hệ của khoa/ngành...">{{ old('contact_info', $dataMajor->contact_info) }}</textarea>
            </div>

            
          </div>

          <div class="d-flex justify-content-end">
            <a href="{{ route('admin.major') }}" class="btn btn-secondary me-2">Hủy</a>
            <button type="submit" class="btn btn-success">Cập nhật ngành học</button>
          </div>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    let admissionMethods = [];
    let subjectCombinations = [];
    let selectedAdmissionMethods = [];
    let admissionScores = [];
    let selectedSubjectCombinations = {}; // Lưu danh sách ID tổ hợp môn đã chọn theo phương thức {methodId: [combinationIds]}

    $(document).ready(function () {
      $('#editor').summernote({
        height: 200,
        placeholder: 'Nhập nội dung chi tiết...'
      });

      $('#editor1').summernote({
        height: 200,
        placeholder: 'Nhập nội dung chi tiết...'
      });

      $('#editor2').summernote({
        height: 200,
        placeholder: 'Nhập nội dung chi tiết...'
      });

      $('#editor3').summernote({
        height: 200,
        placeholder: 'Nhập nội dung chi tiết...'
      });

      // Load dữ liệu theo thứ tự
      loadSubjectCombinations();
      loadCurrentSubjectCombinations(); // Load tổ hợp môn đã chọn
      loadAdmissionScores(); // Load điểm chuẩn trước
      loadAdmissionMethods(); // Sẽ tự động gọi loadCurrentAdmissionMethods và render điểm chuẩn

      // Load select2 cho các tổ hợp môn khi render lại
      $(document).on('DOMNodeInserted', function(e) {
        if ($(e.target).find('.subject-combinations-select').length > 0) {
          $('.subject-combinations-select').select2({
            placeholder: 'Chọn tổ hợp môn...',
            allowClear: true,
            width: 'resolve'
          });
        }
      });
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
          loadCurrentAdmissionMethods();
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

    // Load tổ hợp môn đã được chọn cho ngành học này
    function loadCurrentSubjectCombinations() {
      fetch('/api/major/{{ $dataMajor->id }}/subject-combinations')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          // Lưu danh sách ID tổ hợp môn đã được chọn
          // Tổ hợp môn áp dụng cho các phương thức có requires_subject_combinations = true (THPT, Học bạ)
          // Nhóm theo admission_method_id
          selectedSubjectCombinations = {};
          data.forEach(item => {
            const methodId = item.admission_method_id;
            if (!selectedSubjectCombinations[methodId]) {
              selectedSubjectCombinations[methodId] = [];
            }
            selectedSubjectCombinations[methodId].push(item.id);
          });
        })
        .catch(error => {
          console.error('Error loading current subject combinations:', error);
          selectedSubjectCombinations = {};
        });
    }

    // Load phương thức xét tuyển hiện tại của ngành
    function loadCurrentAdmissionMethods() {
      fetch('/api/major/{{ $dataMajor->id }}/admission-methods')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          selectedAdmissionMethods = data.map(item => item.id);
          console.log('Selected admission methods:', selectedAdmissionMethods); // Debug log
          renderAdmissionMethods();
          // Render điểm chuẩn sau khi đã có đầy đủ dữ liệu với delay nhỏ
          setTimeout(() => {
            updateAdmissionScoresVisibility();
          }, 100);
        })
        .catch(error => {
          console.error('Error loading current admission methods:', error);
          // Tiếp tục render với dữ liệu trống
          selectedAdmissionMethods = [];
          renderAdmissionMethods();
          updateAdmissionScoresVisibility();
        });
    }

    // Load điểm chuẩn
    function loadAdmissionScores() {
      fetch('/api/major/{{ $dataMajor->id }}/admission-scores')
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok');
          }
          return response.json();
        })
        .then(data => {
          admissionScores = data;
          console.log('Loaded admission scores:', admissionScores); // Debug log
          // Không render ngay, sẽ render sau khi load xong phương thức xét tuyển
        })
        .catch(error => {
          console.error('Error loading admission scores:', error);
          // Tiếp tục với dữ liệu trống
          admissionScores = [];
        });
    }

    // Render phương thức xét tuyển
    function renderAdmissionMethods() {
      const container = document.getElementById('admission-methods-container');
      let html = '<div class="row">';

      admissionMethods.forEach(method => {
        const isChecked = selectedAdmissionMethods.includes(method.id);
        html += `
          <div class="col-md-6 mb-3">
            <div class="card border">
              <div class="card-body p-3">
                <div class="form-check">
                  <input class="form-check-input admission-method-checkbox" type="checkbox"
                         name="admission_methods[]"
                         value="${method.id}"
                         id="method_${method.id}"
                         ${isChecked ? 'checked' : ''}
                         onchange="handleAdmissionMethodChange(${method.id}, ${method.requires_subject_combinations})">
                  <label class="form-check-label" for="method_${method.id}">
                    <strong>${method.name}</strong>
                  </label>
                </div>
                <small class="text-muted d-block mt-1">${method.description}</small>

                ${method.requires_subject_combinations ? `
                  <div class="mt-3 subject-combinations-section" id="subject_combinations_${method.id}"
                       style="display: ${isChecked ? 'block' : 'none'};">
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

      // Render tổ hợp môn cho các phương thức yêu cầu tổ hợp môn nếu được chọn
      admissionMethods.forEach(method => {
        if (method.requires_subject_combinations && selectedAdmissionMethods.includes(method.id)) {
          renderSubjectCombinationsForMethod(method.id);
        }
      });

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
      // Lấy danh sách tổ hợp môn đã chọn cho phương thức này
      const methodCombinations = selectedSubjectCombinations[methodId] || [];
      let html = `<select class="form-control subject-combinations-select" name="subject_combinations[${methodId}][]" multiple="multiple" style="width:100%">`;
      subjectCombinations.forEach(combination => {
        const isSelected = methodCombinations.includes(combination.id);
        html += `<option value="${combination.id}" ${isSelected ? 'selected' : ''}><strong>${combination.code}</strong> - ${combination.name} (${combination.subjects})</option>`;
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

      // Kiểm tra xem có dữ liệu cần thiết không
      if (!container || selectedAdmissionMethods.length === 0 || admissionMethods.length === 0) {
        console.log('Missing data for rendering scores:', {
          container: !!container,
          selectedMethods: selectedAdmissionMethods.length,
          allMethods: admissionMethods.length,
          scores: admissionScores.length
        });
        return;
      }

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
        const method = admissionMethods.find(m => m.id == methodId); // Sử dụng == để so sánh cả string và number
        if (!method) {
          console.log('Method not found for ID:', methodId);
          return;
        }

        // Chỉ hiển thị một dòng cho mỗi phương thức, không phân chia theo tổ hợp môn
        html += `<tr><td><strong>${method.name}</strong></td>`;
        years.forEach(year => {
          const existingScore = admissionScores.find(s =>
            s.admission_method_id == methodId && // Sử dụng == để so sánh
            s.year == year
          );
          const scoreValue = existingScore ? existingScore.score : '';
          console.log(`Score for method ${methodId}, year ${year}:`, scoreValue); // Debug log

          html += `<td><input type="number" step="0.01" min="0" max="1000" class="form-control form-control-sm"
                   name="scores[${methodId}][${year}]"
                   value="${scoreValue}"
                   placeholder="0.00"></td>`;
        });
        html += '</tr>';
      });

      html += '</tbody></table></div>';
      container.innerHTML = html;

      console.log('Rendered admission scores table'); // Debug log
    }

    // Function để reload điểm chuẩn manually
    function reloadAdmissionScores() {
      console.log('Reloading admission scores...');
      loadAdmissionScores();
      // Delay một chút rồi render lại
      setTimeout(() => {
        if (selectedAdmissionMethods.length > 0) {
          renderAdmissionScores();
        }
      }, 200);
    }

    // Function để test API endpoint (có thể gọi từ console)
    function testAdmissionScoresAPI() {
      console.log('Testing API endpoint...');
      fetch('/api/major/{{ $dataMajor->id }}/admission-scores')
        .then(response => response.json())
        .then(data => {
          console.log('API Response:', data);
          return data;
        })
        .catch(error => {
          console.error('API Error:', error);
        });
    }
  </script>
@endsection