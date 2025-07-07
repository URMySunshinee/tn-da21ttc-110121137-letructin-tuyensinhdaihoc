@extends('admin.layout')
@section('title', 'Thống kê')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
<div class="container py-4">
    <h3 id="statistic">📊 Thống kê tổng quan</h3>
    <div class="row mb-4">
        <div class="col-md-2 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center bg-gradient-primary text-white">
                <div class="card-body p-2">
                    <div class="fs-3 fw-bold">{{ number_format($totalUsers) }}</div>
                    <div class="small">Người dùng</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center bg-gradient-info text-white">
                <div class="card-body p-2">
                    <div class="fs-3 fw-bold">{{ number_format($totalMajors) }}</div>
                    <div class="small">Ngành học</div>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center bg-gradient-success text-white">
                <div class="card-body p-2">
                    <div class="fs-3 fw-bold">{{ number_format($totalBlogs) }}</div>
                    <div class="small">Bài viết</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center bg-gradient-warning text-dark">
                <div class="card-body p-2">
                    <div class="fs-3 fw-bold">{{ number_format($totalMajorLikes) }}</div>
                    <div class="small">Lượt thích ngành học</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card shadow-sm border-0 text-center bg-gradient-secondary text-white">
                <div class="card-body p-2">
                    <div class="fs-3 fw-bold">{{ number_format($totalMajorViews) }}</div>
                    <div class="small">Lượt xem ngành học</div>
                </div>
            </div>
        </div>
    </div>

   
<h5 class="mt-4" id="top-major-filtered">🔥 BXH ngành học được quan tâm nhiều nhất theo khối ngành đã lọc</h5>

 <h6>Bộ lọc</h6>
<form method="GET" action="" class="row g-3 align-items-end mb-4" id="majorFilterForm">
    @csrf
  <div class="col-auto">
    <label for="year" class="form-label">Năm</label>
    <select class="form-control border p-2" id="year" name="year">
      @for ($y = date('Y'); $y >= 2020; $y--)
        <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
      @endfor
    </select>
  </div>

  <div class="col-auto">
    <label for="quarter" class="form-label">Quý</label>
    <select class="form-control border p-2" id="quarter" name="quarter">
      <option value="">-- Tất cả --</option>
      <option value="1" {{ request('quarter') == 1 ? 'selected' : '' }}>Quý 1 (1-3)</option>
      <option value="2" {{ request('quarter') == 2 ? 'selected' : '' }}>Quý 2 (4-6)</option>
      <option value="3" {{ request('quarter') == 3 ? 'selected' : '' }}>Quý 3 (7-9)</option>
      <option value="4" {{ request('quarter') == 4 ? 'selected' : '' }}>Quý 4 (10-12)</option>
    </select>
  </div>
  <div class="col-auto">
    <label for="quarter" class="form-label">Khối ngành</label>
    <select class="form-control border p-2" name="category_major_id" id="filter" required>
      @foreach ($dataMajorCategory as $item)
      <option value="{{$item->id}}" {{ request('category_major_id') == $item->id ? 'selected' : '' }}>{{$item->name_category_major}}</option>
      @endforeach
    </select>
  </div>
  
  <div class="">
    <button type="submit" class="btn btn-primary" style="width:5%">Lọc</button>
  </div>
</form>

<div class="row">
        <div class="col-lg-12 col-md-12 mt-4 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0 ">Thứ tự quan tâm theo khối ngành</h6>
              <p class="text-sm "></p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex ">
              </div>
            </div>
          </div>
        </div>
      </div>
     <table class="table ">
        <thead>
            <tr>
                <th>Thứ hạng</th>
                <th>Tên ngành</th>
                <th>Lượt thích</th>
                <th>Lượt câu hỏi</th>
                <th>Lượt xem</th>
                <th>Các thí sinh quan tâm đến từ</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mostPopularMajorsFilter as $index => $item)
                <tr>
                    <td>{{++$index}}</td>
                    <td>{{ Str::limit($item->name_major, 20) }}</td>
                    <td>{{ number_format($item->total_like) }}</td>
                    <td>{{ number_format($item->total_request) }}</td>
                    <td>{{ number_format($item->view_major) }}</td>
                    <td>
                        <button class="btn btn-sm btn-info" onclick="showCityChart({{ $item->id }}, '{{ addslashes($item->name_major) }}')">Xem biểu đồ</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal hiển thị biểu đồ thành phố -->
    <div class="modal fade" id="cityChartModal" tabindex="-1" aria-labelledby="cityChartModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cityChartModalLabel">Biểu đồ thí sinh theo thành phố</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body text-center">
            <canvas id="cityPieChart" style="max-width:100%;height:250px;"></canvas>
          </div>
        </div>
      </div>
    </div>
    <h5 class="mt-4" id="top-blog">📰 Top 5 bài viết được xem nhiều nhất
        <form method="GET" class="d-inline-block ms-3" id="blogFilterForm">
            <select name="category_blog_id" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                <option value="">-- Tất cả danh mục --</option>
                @foreach(DB::table('category_blog')->get() as $cat)
                    <option value="{{$cat->id}}" {{ request('category_blog_id') == $cat->id ? 'selected' : '' }}>{{$cat->name_category_blog}}</option>
                @endforeach
            </select>
            @foreach(request()->except('category_blog_id') as $k => $v)
                <input type="hidden" name="{{$k}}" value="{{$v}}">
            @endforeach
        </form>
    </h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tiêu đề</th>
                <th>Danh mục</th>
                <th>Lượt xem</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topBlogs as $i => $blog)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ Str::limit($blog->name_blog, 70) }}</td> 
                    <td>{{ $blog->name_category_blog }}</td>
                    <td>{{ number_format($blog->view_blog) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h5 class="mt-4" id="visit">📈 Thống kê lượt truy cập
      <form method="GET" class="d-inline-block ms-3 align-middle" id="visitFilterForm">
        <select name="visit_filter" class="form-select d-inline-block w-auto" onchange="toggleVisitDateInputs(); this.form.submit();">
          <option value="14days" {{ $visitFilter=='14days' ? 'selected' : '' }}>14 ngày gần nhất</option>
          <option value="month" {{ $visitFilter=='month' ? 'selected' : '' }}>Tháng này</option>
          <option value="year" {{ $visitFilter=='year' ? 'selected' : '' }}>Năm nay</option>
          <option value="custom" {{ $visitFilter=='custom' ? 'selected' : '' }}>Tùy chọn ngày</option>
        </select>
        <input type="date" name="visit_from" id="visit_from" value="{{ $visitFrom }}" class="form-control d-inline-block w-auto ms-2" style="display:none;" onchange="this.form.submit()">
        <input type="date" name="visit_to" id="visit_to" value="{{ $visitTo }}" class="form-control d-inline-block w-auto ms-2" style="display:none;" onchange="this.form.submit()">
        @foreach(request()->except(['visit_filter','visit_from','visit_to']) as $k => $v)
          <input type="hidden" name="{{$k}}" value="{{$v}}">
        @endforeach
      </form>
    </h5>
    <div class="card mb-4">
      <div class="card-body">
        <canvas id="visitLineChart" height="120"></canvas>
      </div>
    </div>
</div>
</main>
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById("chart-bars").getContext("2d");
 const labels = {!! json_encode($label) !!};
 const view_major = {!! json_encode($view_major) !!};
 
    // Lưu labels gốc để hiển thị trong tooltip
    const originalLabels = [...labels];
    
    // Hàm rút gọn tên ngành cho label
    function truncateLabel(label, maxLength = 20) {
        if (label.length <= maxLength) return label;
        return label.substring(0, maxLength) + '...';
    }
    
    // Rút gọn labels để hiển thị trên trục X
    const shortLabels = labels.map(label => truncateLabel(label));
    
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: shortLabels,
        datasets: [{
          label: "Lượt xem",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#43A047",
          data: view_major,
          barThickness: 'flex'
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            callbacks: {
              title: function(context) {
                const index = context[0].dataIndex;
                return originalLabels[index]; // Hiển thị tên đầy đủ trong tooltip
              },
              label: function(context) {
                return 'Lượt xem: ' + context.parsed.y.toLocaleString();
              }
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5],
              color: '#e5e5e5'
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 10,
              font: {
                size: 14,
                lineHeight: 2
              },
              color: "#737373"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#737373',
              padding: 10,
              font: {
                size: 12,
                lineHeight: 1.5
              },
              maxRotation: 45, // Xoay label 45 độ để tiết kiệm không gian
              minRotation: 0
            }
          },
        },
      },
    });

    // Dữ liệu cityStats từ backend
    const cityStats = @json($cityStats);
    let cityPieChart;
    function showCityChart(majorId, majorName) {
        const stats = cityStats[majorId] || {};
        const labels = Object.keys(stats);
        const data = Object.values(stats);
        // Nếu chưa có dữ liệu thì báo
        if (labels.length === 0) {
            alert('Không có dữ liệu thành phố cho ngành này!');
            return;
        }
        // Hiện modal
        const modal = new bootstrap.Modal(document.getElementById('cityChartModal'));
        modal.show();
        // Vẽ biểu đồ
        setTimeout(function() {
            const ctx = document.getElementById('cityPieChart').getContext('2d');
            if (cityPieChart) cityPieChart.destroy();
            cityPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: [
                            '#43A047', '#1E88E5', '#FDD835', '#E53935', '#8E24AA', '#00ACC1', '#F4511E', '#3949AB', '#6D4C41', '#757575'
                        ],
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' },
                        title: { display: true, text: 'Tỉ lệ thí sinh quan tâm theo thành phố - Ngành ' + majorName }
                    }
                }
            });
        }, 300);
    }

    // Biểu đồ line truy cập 14 ngày gần nhất
    const visitLabels = {!! json_encode($visitChart['labels']) !!};
    const visitData = {!! json_encode($visitChart['data']) !!};
    new Chart(document.getElementById('visitLineChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: visitLabels,
            datasets: [{
                label: 'Lượt truy cập',
                data: visitData,
                borderColor: '#1E88E5',
                backgroundColor: 'rgba(30,136,229,0.1)',
                fill: true,
                tension: 0.3,
                pointRadius: 4,
                pointBackgroundColor: '#1E88E5',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#737373', font: { size: 13 } },
                    grid: { color: '#e5e5e5' }
                },
                x: {
                    ticks: { color: '#737373', font: { size: 13 } },
                    grid: { display: false }
                }
            }
        }
    });

    function toggleVisitDateInputs() {
  var filter = document.querySelector('select[name=visit_filter]').value;
  document.getElementById('visit_from').style.display = (filter==='custom') ? 'inline-block' : 'none';
  document.getElementById('visit_to').style.display = (filter==='custom') ? 'inline-block' : 'none';
}
document.addEventListener('DOMContentLoaded', toggleVisitDateInputs);

// --- TỰ ĐỘNG THÊM HASH VÀ CUỘN ĐẾN VỊ TRÍ THỐNG KÊ ---
function scrollToHashTarget() {
    if (window.location.hash) {
        var el = document.querySelector(window.location.hash);
        if (el) {
            el.scrollIntoView({behavior: 'smooth', block: 'start'});
        }
    }
}
document.addEventListener('DOMContentLoaded', scrollToHashTarget);

// Thêm hash khi submit form lọc ngành
const majorFilterForm = document.getElementById('majorFilterForm');
if (majorFilterForm) {
    majorFilterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        url.hash = '#top-major-filtered';
        window.location.href = url.toString();
        setTimeout(() => majorFilterForm.submit(), 10); // submit lại sau khi set hash
    });
}
// Thêm hash khi submit form lọc truy cập
const visitFilterForm = document.getElementById('visitFilterForm');
if (visitFilterForm) {
    visitFilterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        url.hash = '#visit';
        window.location.href = url.toString();
        setTimeout(() => visitFilterForm.submit(), 10);
    });
}

const blogFilterForm = document.getElementById('blogFilterForm');
if (blogFilterForm) {
    blogFilterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const url = new URL(window.location.href);
        url.hash = '#top-blog';
        window.location.href = url.toString();
        setTimeout(() => blogFilterForm.submit(), 10);
    });
}
// Nếu có các form lọc khác, có thể thêm tương tự với id và hash phù hợp
</script>
@endsection
@endsection
