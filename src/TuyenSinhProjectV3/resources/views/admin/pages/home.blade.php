@extends('admin.layout')
@section('title', 'DASHBOARD')
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Trang</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Dashboard</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <span class="text-sm text-muted">Xin chào, {{ Auth::user()->name }}</span>
          </div>
          <ul class="navbar-nav d-flex align-items-center justify-content-end">
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-2">
      <div class="row">
        <div class="ms-3">
          <h3 class="mb-0 h4 font-weight-bolder">📊 Dashboard Hệ Thống Tuyển Sinh</h3>
          <p class="mb-4 mt-3 text-muted">
            Trang quản trị tổng quan cho hệ thống tuyển sinh Đại học Trà Vinh - Cập nhật: {{ date('d/m/Y H:i') }}
          </p>
        </div>
      </div>

      <!-- Thống kê tổng quan -->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Tổng người dùng</p>
                  <h4 class="mb-0">{{ number_format($totalUsers ?? 0) }}</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-primary shadow-primary shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">person</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm">
                <span class="text-success font-weight-bolder">
                  {{ $userGrowthPercent >= 0 ? '+' : '' }}{{ $userGrowthPercent }}%
                </span> so với tháng trước
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Tổng ngành học</p>
                  <h4 class="mb-0">{{ number_format($totalMajors ?? 0) }}</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-info shadow-info shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">school</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm"><span class="text-info font-weight-bolder">{{ $totalMajors ?? 0 }} </span>ngành đang hoạt động</p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Tổng bài viết</p>
                  <h4 class="mb-0">{{ number_format($totalBlogs ?? 0) }}</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">article</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm">
                <span class="text-success font-weight-bolder">
                  {{ $todayStats['blogsThisWeek'] }}
                </span> bài viết tuần này
              </p>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-2 ps-3">
              <div class="d-flex justify-content-between">
                <div>
                  <p class="text-sm mb-0 text-capitalize">Lượt truy cập</p>
                  <h4 class="mb-0">{{ number_format($totalViews ?? rand(15000, 25000)) }}</h4>
                </div>
                <div class="icon icon-md icon-shape bg-gradient-warning shadow-warning shadow text-center border-radius-lg">
                  <i class="material-symbols-rounded opacity-10">visibility</i>
                </div>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
              <p class="mb-0 text-sm">
                <span class="text-warning font-weight-bolder">
                  {{ $visitGrowthPercent >= 0 ? '+' : '' }}{{ $visitGrowthPercent }}%
                </span> so với hôm qua
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Biểu đồ và thống kê chi tiết -->
      <div class="row mt-4">
        <div class="col-lg-8 col-md-12 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>📈 Top 5 Ngành Học Được Quan Tâm Nhất</h6>
                  <p class="text-sm mb-0">
                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                    <span class="font-weight-bold ms-1">Cập nhật</span> hàng ngày
                  </p>
                </div>
                <div class="col-lg-6 col-5 my-auto text-end">
                  <a href="{{ route('admin.report') }}" class="btn btn-sm btn-primary">
                    Xem chi tiết
                  </a>
                </div>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngành học</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Lượt thích</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lượt xem</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Xu hướng</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($topMajors ?? [] as $index => $major)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ Str::limit($major->name_major ?? 'Ngành học ' . ($index + 1), 50) }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $major->category->name_category_major ?? 'Khối ngành' }}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold"> {{ number_format($major->like_major ?? 0) }} </span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{ number_format($major->view_major ?? 0) }} </span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="badge badge-sm bg-gradient-{{ $index < 2 ? 'success' : ($index < 4 ? 'info' : 'secondary') }}">
                          {{ $index < 2 ? 'Rất quan tâm' : ($index < 4 ? 'Quan tâm' : 'Bình thường') }}
                        </span>
                      </td>
                    </tr>
                    @empty
                    @for($i = 1; $i <= 5; $i++)
                    <tr>
                      <td>
                        <div class="d-flex px-2 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">Ngành học mẫu {{ $i }}</h6>
                            <p class="text-xs text-secondary mb-0">Khối ngành mẫu</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <span class="text-xs font-weight-bold"> {{ number_format(rand(50, 500)) }} </span>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <span class="text-xs font-weight-bold"> {{ number_format(rand(1000, 5000)) }} </span>
                      </td>
                      <td class="align-middle text-center">
                        <span class="badge badge-sm bg-gradient-{{ $i < 3 ? 'success' : ($i < 5 ? 'info' : 'secondary') }}">
                          {{ $i < 3 ? 'Rất quan tâm' : ($i < 5 ? 'Quan tâm' : 'Bình thường') }}
                        </span>
                      </td>
                    </tr>
                    @endfor
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="card h-100">
            <div class="card-header pb-0">
              <h6>📊 Hoạt động gần đây</h6>
              <p class="text-sm">
                Theo dõi các hoạt động mới nhất từ người dùng, bài viết và chat AI.
              </p>
            </div>
            <div class="card-body p-3">
              <div class="timeline timeline-one-side">
                @if(count($recentActivities) > 0)
                  @foreach($recentActivities as $activity)
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-symbols-rounded text-{{ $activity->type == 'chat' ? 'warning' : ($activity->type == 'blog' ? 'info' : 'success') }} text-gradient">
                        {{ $activity->type == 'chat' ? 'chat' : ($activity->type == 'blog' ? 'article' : 'person_add') }}
                      </i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">
                        @if($activity->type == 'chat')
                          {{ Str::limit($activity->question, 70) }}
                        @elseif($activity->type == 'blog')
                          Bài viết mới: {{ Str::limit($activity->question, 60) }}
                        @else
                          {{ $activity->question }}
                        @endif
                      </h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                        {{ $activity->created_at_formatted }} 
                        <span class="badge badge-sm bg-gradient-{{ $activity->type == 'chat' ? 'warning' : ($activity->type == 'blog' ? 'info' : 'success') }}">
                          {{ $activity->type == 'chat' ? 'Chat AI' : ($activity->type == 'blog' ? 'Bài viết' : 'Người dùng') }}
                        </span>
                      </p>
                    </div>
                  </div>
                  @endforeach
                @else
                  <!-- Fallback khi không có dữ liệu thật -->
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-symbols-rounded text-success text-gradient">person_add</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $todayStats['newUsersToday'] }} người dùng mới đăng ký hôm nay</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-symbols-rounded text-info text-gradient">article</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $todayStats['blogsThisWeek'] }} bài viết tuần này</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ now()->startOfWeek()->format('d/m/Y') }} - {{ now()->endOfWeek()->format('d/m/Y') }}</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-symbols-rounded text-warning text-gradient">chat</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $todayStats['chatToday'] }} lượt chat với AI hôm nay</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                  </div>
                  <div class="timeline-block mb-3">
                    <span class="timeline-step">
                      <i class="material-symbols-rounded text-primary text-gradient">school</i>
                    </span>
                    <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $totalMajors }} ngành học đang hoạt động</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Cập nhật: {{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Biểu đồ thống kê -->
      <div class="row mt-4">
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0">📊 Lượt truy cập tuần</h6>
              <p class="text-sm">7 ngày gần nhất</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-visits" class="chart-canvas" height="170"></canvas>
                  <div id="chart-visits-loading" class="chart-loading" style="display:none;">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    Đang tải dữ liệu...
                  </div>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex">
                <i class="material-symbols-rounded text-sm my-auto me-1">schedule</i>
                <p class="mb-0 text-sm">Cập nhật {{ now()->format('H:i') }} hôm nay</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0">🎯 Số ngành học</h6>
              <p class="text-sm">Phân bố theo khối ngành</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-majors" class="chart-canvas" height="170"></canvas>
                  <div id="chart-majors-loading" class="chart-loading" style="display:none;">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    Đang tải dữ liệu...
                  </div>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex">
                <i class="material-symbols-rounded text-sm my-auto me-1">school</i>
                <p class="mb-0 text-sm">{{ $totalMajors ?? 0 }} ngành đang hoạt động</p>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-0">💬 Hoạt động Chat AI</h6>
              <p class="text-sm">Số lượng cuộc trò chuyện</p>
              <div class="pe-2">
                <div class="chart">
                  <canvas id="chart-chat" class="chart-canvas" height="170"></canvas>
                  <div id="chart-chat-loading" class="chart-loading" style="display:none;">
                    <div class="spinner-border spinner-border-sm" role="status"></div>
                    Đang tải dữ liệu...
                  </div>
                </div>
              </div>
              <hr class="dark horizontal">
              <div class="d-flex">
                <i class="material-symbols-rounded text-sm my-auto me-1">chat</i>
                <p class="mb-0 text-sm">{{ $todayStats['chatToday'] }} cuộc trò chuyện hôm nay</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Links nhanh -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header pb-0">
              <h6>🚀 Truy cập nhanh</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.major') }}" class="btn btn-outline-primary w-100">
                    <i class="material-symbols-rounded me-1">school</i> Quản lý ngành học
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.blog') }}" class="btn btn-outline-info w-100">
                    <i class="material-symbols-rounded me-1">article</i> Quản lý bài viết
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.user') }}" class="btn btn-outline-success w-100">
                    <i class="material-symbols-rounded me-1">person</i> Quản lý người dùng
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.report') }}" class="btn btn-outline-warning w-100">
                    <i class="material-symbols-rounded me-1">bar_chart</i> Xem thống kê
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.chat') }}" class="btn btn-outline-secondary w-100">
                    <i class="material-symbols-rounded me-1">chat</i> Chat AI
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.question') }}" class="btn btn-outline-primary w-100">
                    <i class="material-symbols-rounded me-1">help</i> Câu hỏi tư vấn
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.majorCategory') }}" class="btn btn-outline-info w-100">
                    <i class="material-symbols-rounded me-1">category</i> Danh mục ngành
                  </a>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                  <a href="{{ route('admin.blogCategory') }}" class="btn btn-outline-success w-100">
                    <i class="material-symbols-rounded me-1">label</i> Danh mục blog
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Thống kê hiệu suất -->
      <div class="row mt-4">
        <div class="col-lg-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <h6>⚡ Hiệu suất hệ thống</h6>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-6">
                  <div class="text-center">
                    <h4 class="font-weight-bolder">{{ number_format($totalViews / max($totalUsers, 1), 1) }}</h4>
                    <p class="mb-0 text-sm">Lượt truy cập/Người dùng</p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-center">
                    <h4 class="font-weight-bolder">{{ $totalBlogs > 0 ? number_format($totalViews / $totalBlogs, 1) : '0' }}</h4>
                    <p class="mb-0 text-sm">Lượt xem/Bài viết</p>
                  </div>
                </div>
              </div>
              <hr class="horizontal gray-light my-3">
              <div class="row">
                <div class="col-6">
                  <div class="text-center">
                    <h4 class="font-weight-bolder text-success">{{ number_format(($totalUsers / max($totalMajors, 1)), 1) }}</h4>
                    <p class="mb-0 text-sm">Người dùng/Ngành</p>
                  </div>
                </div>
                <div class="col-6">
                  <div class="text-center">
                    <h4 class="font-weight-bolder text-info">{{ $totalUsers > 0 ? number_format((\Illuminate\Support\Facades\DB::table('chat_ai')->count() / $totalUsers), 1) : '0' }}</h4>
                    <p class="mb-0 text-sm">Chat/Người dùng</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <h6>📅 Thống kê thời gian</h6>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between">
                <span class="text-sm">Người dùng mới hôm nay:</span>
                <span class="font-weight-bold">{{ $todayStats['newUsersToday'] }}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span class="text-sm">Bài viết tuần này:</span>
                <span class="font-weight-bold">{{ $todayStats['blogsThisWeek'] }}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span class="text-sm">Chat AI hôm nay:</span>
                <span class="font-weight-bold">{{ $todayStats['chatToday'] }}</span>
              </div>
              <div class="d-flex justify-content-between mt-2">
                <span class="text-sm">Lượt truy cập hôm nay:</span>
                <span class="font-weight-bold">{{ $todayStats['visitsToday'] }}</span>
              </div>
              <hr class="horizontal gray-light my-3">
              <div class="text-center">
                <small class="text-muted">Cập nhật lần cuối: {{ now()->format('d/m/Y H:i:s') }}</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  {{-- <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-symbols-rounded py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Material UI Configurator</h5>
          <p>See our dashboard options.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-symbols-rounded">clear</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Sidebar Colors</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark active" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Sidenav Type</h6>
          <p class="text-sm">Choose between different sidenav types.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2  active ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Navbar Fixed</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Free Download</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">View documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Thank you for sharing!</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Share
          </a>
        </div>
      </div>
    </div>
  </div> --}}
  <!--   Core JS Files   -->

  <script>
    // Đợi DOM và Chart.js load hoàn tất
    document.addEventListener('DOMContentLoaded', function() {
      // Kiểm tra Chart.js đã load chưa
      if (typeof Chart === 'undefined') {
        console.error('Chart.js chưa được load');
        return;
      }

      // Dữ liệu từ controller
      var chartData = @json($chartData ?? []);
      
      console.log('Chart data:', chartData); // Debug log
      
      // Biểu đồ lượt truy cập tuần
      var ctxVisits = document.getElementById("chart-visits");
      if (ctxVisits) {
        var visitData = chartData.visits_last_7_days || [];
        var visitLabels = visitData.map(item => new Date(item.date).toLocaleDateString('vi-VN', {weekday: 'short'}));
        var visitCounts = visitData.map(item => item.count);
        
        console.log('Visit data:', visitData); // Debug log
        
        // Nếu không có dữ liệu thật, dùng dữ liệu mẫu
        if (visitLabels.length === 0) {
          visitLabels = ["T2", "T3", "T4", "T5", "T6", "T7", "CN"];
          visitCounts = [120, 150, 180, 220, 300, 280, 200];
        }

        new Chart(ctxVisits, {
          type: "line",
          data: {
            labels: visitLabels,
            datasets: [{
              label: "Lượt truy cập",
              tension: 0.4,
              borderWidth: 3,
              pointRadius: 4,
              pointBackgroundColor: "#43A047",
              pointBorderColor: "transparent",
              borderColor: "#43A047",
              backgroundColor: "rgba(67, 160, 71, 0.1)",
              fill: true,
              data: visitCounts,
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false,
              }
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
                  display: true,
                  color: '#737373',
                  padding: 10,
                  font: {
                    size: 12,
                    lineHeight: 2
                  },
                }
              },
              x: {
                grid: {
                  drawBorder: false,
                  display: false,
                  drawOnChartArea: false,
                  drawTicks: false,
                },
                ticks: {
                  display: true,
                  color: '#737373',
                  padding: 10,
                  font: {
                    size: 12,
                    lineHeight: 2
                  },
                }
              },
            },
          },
        });
      }

      // Biểu đồ ngành học theo danh mục (doughnut)
      var ctxMajors = document.getElementById("chart-majors");
      if (ctxMajors) {
        var majorData = chartData.majors_by_category || [];
        var majorLabels = majorData.map(item => item.category);
        var majorCounts = majorData.map(item => item.count);
        
        // Nếu không có dữ liệu thật, dùng dữ liệu mẫu
        if (majorLabels.length === 0) {
          majorLabels = ["Công nghệ", "Kinh tế", "Y tế", "Giáo dục", "Khác"];
          majorCounts = [15, 12, 8, 10, 5];
        }

        new Chart(ctxMajors, {
          type: "doughnut",
          data: {
            labels: majorLabels,
            datasets: [{
              label: "Số ngành",
              data: majorCounts,
              backgroundColor: [
                '#43A047',
                '#1E88E5', 
                '#FB8C00',
                '#E53935',
                '#8E24AA'
              ],
              borderWidth: 0,
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: true,
                position: 'bottom',
                labels: {
                  padding: 10,
                  usePointStyle: true,
                  font: {
                    size: 11
                  }
                }
              }
            },
          },
        });
      }

      // Biểu đồ hoạt động chat AI
      var ctxChat = document.getElementById("chart-chat");
      if (ctxChat) {
        var chatData = chartData.chat_activity_last_30_days || [];
        var chatLabels = chatData.slice(-7).map(item => new Date(item.date).toLocaleDateString('vi-VN', {day: '2-digit', month: '2-digit'}));
        var chatCounts = chatData.slice(-7).map(item => item.count);
        
        // Nếu không có dữ liệu thật, dùng dữ liệu mẫu
        if (chatLabels.length === 0) {
          chatLabels = ["01/01", "02/01", "03/01", "04/01", "05/01", "06/01", "07/01"];
          chatCounts = [45, 52, 38, 65, 78, 84, 92];
        }

        new Chart(ctxChat, {
          type: "bar",
          data: {
            labels: chatLabels,
            datasets: [{
              label: "Cuộc trò chuyện",
              tension: 0.4,
              borderWidth: 0,
              borderRadius: 4,
              borderSkipped: false,
              backgroundColor: "#FB8C00",
              data: chatCounts,
              barThickness: 'flex'
            }],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false,
              }
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
                  display: true,
                  color: '#737373',
                  padding: 10,
                  font: {
                    size: 12,
                    lineHeight: 2
                  },
                }
              },
              x: {
                grid: {
                  drawBorder: false,
                  display: false,
                  drawOnChartArea: false,
                  drawTicks: false,
                },
                ticks: {
                  display: true,
                  color: '#737373',
                  padding: 10,
                  font: {
                    size: 12,
                    lineHeight: 2
                  },
                }
              },
            },
          },
        });
      }
    });
  </script>
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