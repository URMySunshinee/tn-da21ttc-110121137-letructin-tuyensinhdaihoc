@extends('admin.layout')
@section('title', 'Quản lý tổ hợp môn')
@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
  <div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Quản lý tổ hợp môn xét tuyển</h6>
            <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addModal">
              <i class="fa fa-plus"></i> Thêm tổ hợp môn
            </button>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
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
            
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã tổ hợp</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên tổ hợp</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Các môn học</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thứ tự</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành động</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($subjectCombinations as $item)
                  <tr>
                    <td>
                      <h6 class="text-sm font-weight-bold mb-0">{{ $item->code }}</h6>
                    </td>
                    <td>
                      <h6 class="text-sm mb-0">{{ $item->name }}</h6>
                      @if($item->description)
                        <p class="text-xs text-secondary mb-0">{{ Str::limit($item->description, 50) }}</p>
                      @endif
                    </td>
                    <td>
                      <p class="text-xs mb-0">{{ $item->subjects }}</p>
                    </td>
                    <td class="align-middle text-center">
                      @if($item->is_active)
                        <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                      @else
                        <span class="badge badge-sm bg-gradient-secondary">Vô hiệu</span>
                      @endif
                    </td>
                    <td class="align-middle text-center">
                      <span class="text-secondary text-xs">{{ $item->priority_order }}</span>
                    </td>
                    <td class="align-middle text-center">
                      <a href="{{ route('admin.subjectCombination.updateView', $item->id) }}" 
                         class="btn btn-sm btn-outline-primary btn-action-circle me-1" title="Sửa">
                        <i class="fa fa-edit text-primary" style="font-size: 15px;"></i>
                      </a>
                      <form action="{{ route('admin.subjectCombination.toggleStatus', $item->id) }}" 
                            method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-sm {{ $item->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} btn-action-circle me-1" title="{{ $item->is_active ? 'Vô hiệu' : 'Kích hoạt' }}">
                          <i style="font-size: 15px;" class="fa {{ $item->is_active ? 'fa-eye-slash text-warning' : 'fa-eye text-success' }}"></i>
                        </button>
                      </form>
                      <form action="{{ route('admin.subjectCombination.delete', $item->id) }}" 
                            method="POST" style="display: inline;" 
                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa tổ hợp môn này?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger btn-action-circle" title="Xóa">
                        <i class="fa fa-trash text-danger" style="font-size: 15px;"></i>
                      </button>
                    </form>
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
  </div>

  <!-- Modal thêm tổ hợp môn -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Thêm tổ hợp môn mới</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.subjectCombination.create') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="code" class="form-label">Mã tổ hợp *</label>
                  <input type="text" class="form-control" id="code" name="code" required 
                         placeholder="VD: A00, D01" style="text-transform: uppercase;">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label for="priority_order" class="form-label">Thứ tự ưu tiên</label>
                  <input type="number" class="form-control" id="priority_order" name="priority_order" 
                         min="0" value="0">
                </div>
              </div>
            </div>
            
            <div class="mb-3">
              <label for="name" class="form-label">Tên tổ hợp môn *</label>
              <input type="text" class="form-control" id="name" name="name" required 
                     placeholder="VD: Toán - Lý - Hóa">
            </div>
            
            <div class="mb-3">
              <label for="subjects" class="form-label">Các môn học *</label>
              <input type="text" class="form-control" id="subjects" name="subjects" required 
                     placeholder="VD: Toán học, Vật lý, Hóa học">
            </div>
            
            <div class="mb-3">
              <label for="description" class="form-label">Mô tả</label>
              <textarea class="form-control" id="description" name="description" rows="3" 
                        placeholder="Mô tả về tổ hợp môn này..."></textarea>
            </div>
            
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
              <label class="form-check-label" for="is_active">
                Kích hoạt tổ hợp môn
              </label>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Thêm tổ hợp môn</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
  // Tự động chuyển mã tổ hợp thành chữ hoa
  document.getElementById('code').addEventListener('input', function() {
    this.value = this.value.toUpperCase();
  });
  </script>
</main>

@endsection

@push('styles')
<style>
.btn-action-circle {
  width: 42px;
  height: 42px;
  border-radius: 50%;
  padding: 0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 2px 6px rgba(0,0,0,0.07);
  border-width: 2px;
  margin-right: 4px;
  transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.btn-action-circle i {
  font-size: 1.4rem;
  transition: color 0.2s;
}
.btn-outline-primary.btn-action-circle:hover, .btn-outline-primary.btn-action-circle:focus {
  background: #1976d2;
  color: #fff;
  border-color: #1976d2;
}
.btn-outline-primary.btn-action-circle:hover i {
  color: #fff;
}
.btn-outline-warning.btn-action-circle:hover, .btn-outline-warning.btn-action-circle:focus {
  background: #ff9800;
  color: #fff;
  border-color: #ff9800;
}
.btn-outline-warning.btn-action-circle:hover i {
  color: #fff;
}
.btn-outline-success.btn-action-circle:hover, .btn-outline-success.btn-action-circle:focus {
  background: #43a047;
  color: #fff;
  border-color: #43a047;
}
.btn-outline-success.btn-action-circle:hover i {
  color: #fff;
}
.btn-outline-danger.btn-action-circle:hover, .btn-outline-danger.btn-action-circle:focus {
  background: #e53935;
  color: #fff;
  border-color: #e53935;
}
.btn-outline-danger.btn-action-circle:hover i {
  color: #fff;
}
</style>
@endpush
