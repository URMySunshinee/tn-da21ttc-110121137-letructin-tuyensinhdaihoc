@extends('admin.layout')
@section('title', "Cập nhật tổ hợp môn {$subjectCombination->code}")
@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center">
              <h6 class="mb-0">Cập nhật tổ hợp môn: {{ $subjectCombination->code }}</h6>
              
            </div>
          </div>
          <div class="card-body">
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('admin.subjectCombination.update', $subjectCombination->id) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="code" class="form-label">Mã tổ hợp *</label>
                    <input type="text" class="form-control" id="code" name="code" required 
                           value="{{ old('code', $subjectCombination->code) }}"
                           placeholder="VD: A00, D01" style="text-transform: uppercase;">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="priority_order" class="form-label">Thứ tự ưu tiên</label>
                    <input type="number" class="form-control" id="priority_order" name="priority_order" 
                           min="0" value="{{ old('priority_order', $subjectCombination->priority_order) }}">
                  </div>
                </div>
              </div>
              
              <div class="mb-3">
                <label for="name" class="form-label">Tên tổ hợp môn *</label>
                <input type="text" class="form-control" id="name" name="name" required 
                       value="{{ old('name', $subjectCombination->name) }}"
                       placeholder="VD: Toán - Lý - Hóa">
              </div>
              
              <div class="mb-3">
                <label for="subjects" class="form-label">Các môn học *</label>
                <input type="text" class="form-control" id="subjects" name="subjects" required 
                       value="{{ old('subjects', $subjectCombination->subjects) }}"
                       placeholder="VD: Toán học, Vật lý, Hóa học">
              </div>
              
              <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" rows="3" 
                          placeholder="Mô tả về tổ hợp môn này...">{{ old('description', $subjectCombination->description) }}</textarea>
              </div>
              
              <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                       {{ old('is_active', $subjectCombination->is_active) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                  Kích hoạt tổ hợp môn
                </label>
              </div>

              <div class="d-flex justify-content-end">
                <a href="{{ route('admin.subjectCombination') }}" class="btn btn-secondary me-2">Hủy</a>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
// Tự động chuyển mã tổ hợp thành chữ hoa
document.getElementById('code').addEventListener('input', function() {
  this.value = this.value.toUpperCase();
});
</script>

@endsection
