@extends('user.layout')
@section('title', "Ngành {$dataMajor->name_major}")
@section('content')


<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f8f9fa;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    .mu-main-content,
    .main-content,
    section {
        padding-left: 0 !important;
        padding-right: 0 !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
    }

    .container-detail {
        background: #fff;
        padding: 40px 20px;
        margin: 0;
        max-width: 100%;
        width: 100vw;
        min-height: calc(100vh - 200px);
        box-shadow: none;
    }

    .major-header {
        text-align: center;
        margin-bottom: 40px;
        padding: 30px 20px;
        background: transparent;
        color: #2c3e50;
    }

    .major-header h1 {
        font-size: 3.2em;
        margin: 0 0 12px 0;
        font-weight: 700;
        color: #2c3e50;
    }

    .major-header .update-date {
        font-size: 1.1em;
        opacity: 0.7;
        margin: 0;
        color: #6c757d;
    }

    .major-info-container {
        background: #e3f2fd;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 35px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.08);
    }

    .major-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin: 0;
    }

    .info-item {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-color: #007bff;
    }

    .info-item .label {
        font-size: 1.1em;
        color: #495057;
        font-weight: 600;
        white-space: nowrap;
        min-width: fit-content;
    }

    .info-item .value {
        font-size: 1.3em;
        font-weight: 700;
        color: #212529;
        flex: 1;
    }

    .info-item.primary .value {
        color: #0056b3;
    }

    .info-item.success .value {
        color: #155724;
    }

    .admission-methods-section {
        margin: 40px 0;
        background: #fff;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .section-title {
        font-size: 1.8em;
        color: #2c3e50;
        margin-bottom: 25px;
        font-weight: 700;
        border-left: 4px solid #007bff;
        padding-left: 15px;
    }

    .admission-method {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .admission-method::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 4px;
        background: linear-gradient(45deg, #007bff, #0056b3);
    }

    .method-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .method-name {
        font-size: 1.3em;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
    }

    .score-display {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .current-score {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-weight: 700;
        font-size: 1.1em;
    }

    .chart-btn {
        background: linear-gradient(45deg, #007bff, #0056b3);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.4);
    }

    .method-description {
        color: #6c757d;
        margin: 10px 0;
        line-height: 1.6;
    }

    .subject-combinations {
        margin-top: 15px;
    }

    .combinations-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
    }

    .combination-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .combination-tag {
        background: linear-gradient(45deg, #e9ecef, #f8f9fa);
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.9em;
        color: #495057;
    }

    .combination-tag .code {
        font-weight: 700;
        color: #007bff;
    }

    .stats-section {
        display: flex;
        justify-content: center;
        gap: 60px;
        margin: 30px 0;
        flex-wrap: wrap;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 1.5em;
        font-weight: 700;
        color: #dc3545;
        display: block;
    }

    .stat-label {
        color: #6c757d;
        font-size: 0.3em;
        margin-top: 5px;
    }

    .content-section {
        background: #fff;
        border-radius: 15px;
        padding: 35px;
        margin: 35px 0;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    }

    .content-section h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        font-weight: 700;
        font-size: 1.6em;
        border-left: 4px solid #28a745;
        padding-left: 18px;
    }

    .content-section p,
    .content-section div {
        line-height: 1.8;
        color: #495057;
        font-size: 1.17em;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: #fff;
        margin: 2% auto;
        padding: 0;
        border-radius: 15px;
        width: 95%;
        max-width: 900px;
        max-height: 90vh;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        animation: modalSlideIn 0.3s ease;
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    @keyframes modalSlideIn {
        from { transform: translateY(-50px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        border-radius: 15px 15px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.4em;
        font-weight: 700;
    }

    .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    .close:hover {
        opacity: 0.7;
    }

    .modal-body {
        padding: 30px;
        flex: 1;
        overflow-y: auto;
        max-height: calc(90vh - 120px);
    }

    .chart-container {
        width: 100%;
        height: 450px;
        margin-bottom: 20px;
        position: relative;
    }

    .chart-info {
        background: #f8f9fa;
        border-left: 4px solid #007bff;
        padding: 20px;
        border-radius: 8px;
    }

    .chart-info h4 {
        color: #007bff;
        margin: 0 0 10px 0;
        font-weight: 700;
    }

    .chart-info p {
        margin: 0;
        line-height: 1.6;
        color: #495057;
    }

    /* Admission Methods Styles - Theo mẫu thiết kế */
    .admission-methods-wrapper {
        background: white;
        border-radius: 8px;
        padding: 25px;
        margin: 25px 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #e0e0e0;
    }

    .admission-methods-header {
        margin-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
    }

    .admission-title {
        color: #333;
        font-size: 1.6em;
        font-weight: 600;
        margin: 0;
    }

    .admission-method-box {
        border-radius: 8px;
        padding: 25px;
        margin-bottom: 20px;
        border: 1px solid #e0e0e0;
    }

    .method-indicator {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
    }

    .method-bullet {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
    }

    .method-name {
        color: #333;
        font-size: 1.2em;
        font-weight: 500;
    }

    .method-score-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 18px;
    }

    .score-display {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .score-label {
        color: #666;
        font-size: 1.1em;
        font-weight: 500;
    }

    .score-number {
        font-size: 1.6em;
        font-weight: 700;
        padding: 6px 14px;
        border: 2px solid currentColor;
        border-radius: 6px;
        background: white;
    }

    .chart-button {
        background: #2196f3;
        color: white;
        border: none;
        padding: 10px 18px;
        border-radius: 6px;
        font-size: 1em;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .chart-button:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    .chart-button i {
        font-size: 1em;
    }

    .subject-combinations-wrapper {
        border-top: 1px solid #e0e0e0;
        padding-top: 18px;
    }

    .combinations-title {
        color: #333;
        font-weight: 500;
        margin-bottom: 15px;
        font-size: 1.1em;
    }

    .combinations-container {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 12px;
    }

    .combination-box {
        background: #17a2b8;
        color: white;
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 2px 8px rgba(23, 162, 184, 0.2);
        font-size: 1em;
        min-width: 220px;
    }

    .combination-code {
        background: rgba(255, 255, 255, 0.2);
        padding: 6px 10px;
        border-radius: 5px;
        font-weight: 700;
        font-size: 1.1em;
        margin: 0;
        flex-shrink: 0;
    }

    .combination-subjects {
        text-align: center;
        font-size: 1.1em;
        line-height: 1.3;
        margin: 0;
        flex: 1;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .container-detail {
            padding: 20px 15px;
        }

        .major-header h1 {
            font-size: 2.5em;
        }

        .major-info-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .method-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-section {
            gap: 30px;
        }

        .modal-content {
            width: 98%;
            margin: 1% auto;
            max-height: 95vh;
        }

        .modal-body {
            padding: 20px;
            max-height: calc(95vh - 100px);
        }

        .chart-container {
            height: 350px;
        }
    }

    @media (max-width: 480px) {
        .major-header {
            padding: 20px 15px;
        }

        .major-header h1 {
            font-size: 2.2em;
        }

        .major-header {
            padding: 20px 15px;
        }

        .major-info-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .major-info-container {
            padding: 20px;
        }

        .major-info-grid {
            gap: 15px;
        }

        .info-item {
            padding: 12px 15px;
        }

        .modal-content {
            width: 100%;
            margin: 0;
            height: 100vh;
            border-radius: 0;
            max-height: 100vh;
        }

        .modal-body {
            padding: 15px;
            max-height: calc(100vh - 80px);
        }

        .chart-container {
            height: 300px;
        }

        .admission-methods-wrapper,
        .content-section {
            padding: 15px;
            margin: 15px 0;
        }

        .admission-method-box {
            padding: 15px;
        }

        .method-score-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .score-number {
            font-size: 1.2em;
            padding: 3px 8px;
        }

        .chart-button {
            font-size: 0.85em;
            padding: 6px 12px;
        }

        .combinations-container {
            gap: 10px;
        }

        

        .combination-code {
            font-size: 1em;
            padding: 4px 8px;
        }

    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-detail">
    <div class="container">
        <br><br><br><br><br><br>
        <!-- Header Section -->
        <div class="major-header">
            <h1>Ngành {{$dataMajor->name_major}}</h1>
            <p style="color: #6c757d; font-size: 1.2em;" class="update-date"><i>Cập nhật lần cuối vào lúc {{ \Carbon\Carbon::parse($dataMajor->date_updated)->format('H:i:s \n\g\à\y d/m/Y') }}</i></p>
        </div>

        <!-- Major Info Container -->
        <div class="major-info-container">
            <div class="major-info-grid">
                @if($dataMajor->major_code)
                <div class="info-item primary">
                    <span class="label">Mã ngành:</span>
                    <span class="value">{{$dataMajor->major_code}}</span>
                </div>
                @endif

                @if($dataMajor->admission_quota)
                <div class="info-item success">
                    <span class="label">Chỉ tiêu:</span>
                    <span class="value">{{$dataMajor->admission_quota}} sinh viên</span>
                </div>
                @endif

                @if($dataMajor->training_duration)
                <div class="info-item">
                    <span class="label">Thời gian đào tạo:</span>
                    <span class="value">{{$dataMajor->training_duration}} năm</span>
                </div>
                @endif

                @if($dataMajor->degree_level)
                <div class="info-item">
                    <span class="label">Danh hiệu cấp bằng:</span>
                    <span class="value">{{$dataMajor->degree_level}}</span>
                </div>
                @endif
            </div>
        </div>

        <!-- Description Section -->
        @if($dataMajor->description_major)
        <div class="content-section">
            <h2>📖 Mô tả ngành học</h2>
            <p>{{$dataMajor->description_major}}</p>

            <!-- Like and View Stats -->
            <div class="stats-section">
                <div class="stat-item">
                    <span class="stat-number">{{$dataMajor->like_major}}</span>
                    <div class="stat-label">Lượt yêu thích</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number" style="color: #007bff;">{{$dataMajor->view_major}}</span>
                    <div class="stat-label">Lượt truy cập</div>
                </div>
            </div>

            <!-- Like Button -->
            <div style="text-align: center; margin-top: 20px;">
                @if (Auth::check())
                <button id="btn-like" onclick="toggleLike(this)" style="background: linear-gradient(45deg, #e74c3c, #c0392b); color: white; border: none; padding: 12px 24px; border-radius: 25px; cursor: pointer; font-weight: 600; transition: all 0.3s ease;">
                    <i class="fa-regular fa-heart" style="margin-right: 8px;"></i>
                    Yêu thích ngành học
                </button>
                @else
                <button disabled style="background: #6c757d; color: white; border: none; padding: 12px 24px; border-radius: 25px; cursor: not-allowed; font-weight: 600;">
                    <i class="fa-regular fa-heart" style="margin-right: 8px;"></i>
                    Yêu thích ngành học
                </button>
                <p style="margin-top: 10px;"><a href="{{route('user.auth')}}" style="color: #007bff;">Đăng nhập để tương tác!</a></p>
                @endif
            </div>
        </div>
        @endif
        <!-- Admission Methods Section -->
        @if(isset($admissionMethods) && count($admissionMethods) > 0)
        <div class="admission-methods-wrapper">
            <div class="admission-methods-header">
                <h2 class="admission-title" style="font-size: 1.6em; color: #2c3e50"><b>📝Phương thức xét tuyển</b></h2>
            </div>

            @foreach($admissionMethods as $index => $method)
            @php
                $methodColors = [
                    ['bg' => '#e3f2fd', 'border' => '#2196f3', 'score' => '#f44336', 'chart' => '#2196f3'],
                    ['bg' => '#e8f5e8', 'border' => '#4caf50', 'score' => '#4caf50', 'chart' => '#4caf50'],
                    ['bg' => '#fff3e0', 'border' => '#ff9800', 'score' => '#ff9800', 'chart' => '#ff9800'],
                    ['bg' => '#f3e5f5', 'border' => '#9c27b0', 'score' => '#9c27b0', 'chart' => '#9c27b0']
                ];
                $color = $methodColors[$index % 4];
            @endphp

            <div class="admission-method-box" style="background: {{ $color['bg'] }}; border-left: 4px solid {{ $color['border'] }};">
                <div class="method-indicator">
                    <span class="method-bullet" style="background: {{ $color['border'] }};"></span>
                    <span class="method-name">{{ $method->name }}</span> 
                    <span class="method-description">{{ $method->description }}</span>
                </div>

                <div class="method-score-section">
                    @if(isset($admissionScores[$method->id]))
                    <div class="score-display">
                        <span class="score-label">Điểm chuẩn 2025:</span>
                        <span class="score-number" style="color: {{ $color['score'] }};">{{ $admissionScores[$method->id] }}</span>
                    </div>
                    <button class="chart-button" style="background: {{ $color['chart'] }};" onclick="showChart('{{ $method->name }}', {{ $method->id }})">
                        <i class="fas fa-chart-line"></i>
                        Biểu đồ so sánh điểm chuẩn
                    </button>
                    @endif
                </div>

                @if($method->requires_subject_combinations && isset($subjectCombinationsByMethod[$method->id]) && count($subjectCombinationsByMethod[$method->id]) > 0)
                <div class="subject-combinations-wrapper">
                    <div class="combinations-title">Tổ hợp môn xét tuyển:</div>
                    <div class="combinations-container">
                        @foreach($subjectCombinationsByMethod[$method->id] as $combination)
                        <div class="combination-box">
                            <div class="combination-code">{{ $combination->code }}</div>
                            <div class="combination-subjects">{{ $combination->name }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Content Sections -->
        @if($dataMajor->content_major)
        <div class="content-section">
            <h2>📖 Giới thiệu ngành học</h2>
            <div>{!! $dataMajor->content_major !!}</div>
        </div>
        @endif

        @if($dataMajor->job_opportunities)
        <div class="content-section">
            <h2>💼 Cơ hội việc làm</h2>
            <div>{!! $dataMajor->job_opportunities !!}</div>
        </div>
        @endif

        @if($dataMajor->post_graduation_opportunities)
        <div class="content-section">
            <h2>🎓 Cơ hội sau đại học</h2>
            <div>{!! $dataMajor->post_graduation_opportunities !!}</div>
        </div>
        @endif

        @if($dataMajor->contact_info)
        <div class="content-section">
            <h2>� Thông tin liên hệ</h2>
            <div>{!! $dataMajor->contact_info !!}</div>
        </div>
        @endif

    </div>
</div>

<!-- Chart Modal -->
<div id="chartModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Biểu đồ điểm chuẩn qua 5 năm (2021-2025)</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="chart-container">
                <canvas id="admissionChart"></canvas>
            </div>
            <div class="chart-info">
                <h4>Thông tin biểu đồ:</h4>
                <p id="chartDescription">Biểu đồ thể hiện xu hướng điểm chuẩn của ngành <strong>{{$dataMajor->name_major}}</strong> qua 5 năm gần đây.</p>
            </div>
        </div>
    </div>
</div>
<script>
    let admissionChart = null;

    // Check like status
    function checkLike(){
        const button = document.querySelector("#btn-like");
        if (!button) return;

        const icon = button.querySelector('i');
        fetch('/check-like/'+{{$dataMajor->id}}, {
            method: 'GET',
        })
        .then(response => response.json())
        .then(data => {
            if(data.check){
                icon.classList.remove('fa-regular');
                icon.classList.add('fa-solid');
                button.innerHTML = '<i class="fa-solid fa-heart" style="margin-right: 8px;"></i>Đã yêu thích';
            } else {
                icon.classList.remove('fa-solid');
                icon.classList.add('fa-regular');
                button.innerHTML = '<i class="fa-regular fa-heart" style="margin-right: 8px;"></i>Yêu thích ngành học';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    // Toggle like
    function toggleLike(button) {
        const statNumbers = document.querySelectorAll('.stat-number');
        const likeStatNumber = statNumbers[0]; // First stat is like count
        const icon = button.querySelector('i');
        const isLiked = icon.classList.contains('fa-solid');

        if (isLiked) {
            icon.classList.remove('fa-solid');
            icon.classList.add('fa-regular');
            button.innerHTML = '<i class="fa-regular fa-heart" style="margin-right: 8px;"></i>Yêu thích ngành học';

            fetch('/unreact-major/'+{{$dataMajor->id}}, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                likeStatNumber.textContent = data.like_major;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            icon.classList.remove('fa-regular');
            icon.classList.add('fa-solid');
            button.innerHTML = '<i class="fa-solid fa-heart" style="margin-right: 8px;"></i>Đã yêu thích';

            fetch('/react-major/'+{{$dataMajor->id}}, {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                likeStatNumber.textContent = data.like_major;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }

    // Show chart modal
    function showChart(methodName, methodId) {
        const modal = document.getElementById('chartModal');
        const modalTitle = document.getElementById('modalTitle');
        const chartDescription = document.getElementById('chartDescription');

        modalTitle.textContent = `Biểu đồ điểm chuẩn qua 5 năm (2021-2025)`;
        chartDescription.innerHTML = `Biểu đồ thể hiện xu hướng điểm chuẩn của ngành <strong>{{$dataMajor->name_major}}</strong> qua 5 năm gần đây. Điểm chuẩn được tính theo thang điểm 30 (tổng điểm 3 môn thi). Xu hướng tăng dần cho thấy sự cạnh tranh ngày càng cao của thí sinh đối với ngành này.`;

        modal.style.display = 'block';

        // Fetch admission scores data
        fetch(`/api/major/{{$dataMajor->id}}/admission-scores`)
            .then(response => response.json())
            .then(data => {
                const methodScores = data.filter(score => score.admission_method_id == methodId);
                const years = [];
                const scores = [];

                // Sort by year and extract data
                methodScores.sort((a, b) => a.year - b.year).forEach(score => {
                    years.push(score.year);
                    scores.push(parseFloat(score.score));
                });

                // If no data, use sample data
                if (years.length === 0) {
                    years.push(2021, 2022, 2023, 2024, 2025);
                    scores.push(22.5, 23.0, 23.5, 24.0, 24.5);
                }

                createChart(years, scores);
            })
            .catch(error => {
                console.error('Error fetching scores:', error);
                // Use sample data on error
                createChart([2021, 2022, 2023, 2024, 2025], [22.5, 23.0, 23.5, 24.0, 24.5]);
            });
    }

    // Create chart
    function createChart(years, scores) {
        const ctx = document.getElementById('admissionChart').getContext('2d');

        // Destroy existing chart if exists
        if (admissionChart) {
            admissionChart.destroy();
        }

        admissionChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'Điểm chuẩn theo năm',
                    data: scores,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#007bff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        min: Math.min(...scores) - 1,
                        max: Math.max(...scores) + 1,
                        title: {
                            display: true,
                            text: 'Điểm chuẩn (thang 30)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Năm'
                        }
                    }
                }
            }
        });
    }

    // Close modal
    function closeModal() {
        document.getElementById('chartModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('chartModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        checkLike();
    });
</script>
@endsection