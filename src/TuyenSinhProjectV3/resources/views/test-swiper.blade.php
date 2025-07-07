<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Swiper</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .test-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .test-title {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        
        .swiper {
            width: 100%;
            height: 300px;
            margin-bottom: 20px;
        }
        
        .swiper-slide {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: bold;
            border-radius: 10px;
            margin: 0 10px;
        }
        
        .swiper-button-next,
        .swiper-button-prev {
            color: #667eea;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .swiper-pagination-bullet {
            background: #667eea;
        }
        
        .debug-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #667eea;
        }
        
        .debug-info h3 {
            margin-top: 0;
            color: #333;
        }
        
        .status {
            padding: 10px;
            border-radius: 5px;
            margin: 10px 0;
        }
        
        .status.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .status.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1 class="test-title">🧪 Test Swiper Slideshow</h1>
        
        <div class="swiper testSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">Slide 1</div>
                <div class="swiper-slide">Slide 2</div>
                <div class="swiper-slide">Slide 3</div>
                <div class="swiper-slide">Slide 4</div>
                <div class="swiper-slide">Slide 5</div>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
        
        <div class="debug-info">
            <h3>🔍 Debug Information</h3>
            <div id="swiper-status" class="status">Checking Swiper...</div>
            <div id="element-status" class="status">Checking elements...</div>
            <div id="init-status" class="status">Waiting for initialization...</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        function updateStatus(id, message, isSuccess = true) {
            const element = document.getElementById(id);
            element.textContent = message;
            element.className = `status ${isSuccess ? 'success' : 'error'}`;
        }

        // Check if Swiper is loaded
        if (typeof Swiper !== 'undefined') {
            updateStatus('swiper-status', '✅ Swiper library loaded successfully');
        } else {
            updateStatus('swiper-status', '❌ Swiper library not loaded', false);
        }

        // Check if elements exist
        const swiperElement = document.querySelector('.testSwiper');
        if (swiperElement) {
            updateStatus('element-status', '✅ Swiper element found');
        } else {
            updateStatus('element-status', '❌ Swiper element not found', false);
        }

        // Initialize Swiper
        document.addEventListener('DOMContentLoaded', function() {
            try {
                const swiper = new Swiper('.testSwiper', {
                    slidesPerView: 1,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                    },
                    on: {
                        init: function() {
                            updateStatus('init-status', '✅ Swiper initialized successfully!');
                            console.log('Swiper initialized:', this);
                        },
                        slideChange: function() {
                            console.log('Slide changed to:', this.activeIndex);
                        }
                    }
                });
            } catch (error) {
                updateStatus('init-status', `❌ Swiper initialization failed: ${error.message}`, false);
                console.error('Swiper error:', error);
            }
        });
    </script>
</body>
</html>
