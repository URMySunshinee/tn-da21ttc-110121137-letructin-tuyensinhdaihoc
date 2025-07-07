# 🎓 Website hỗ trợ tuyển sinh đại học và tư vấn chọn ngành

## 📋 Mục tiêu của đồ án

Xây dựng một hệ thống quản lý thông tin tuyển sinh đại học toàn diện, cung cấp nền tảng trực tuyến hiện đại để:

### 🎯 Cho học sinh và phụ huynh:
- **Tra cứu thông tin ngành học**: Xem chi tiết các ngành đào tạo, điểm chuẩn, phương thức xét tuyển
- **Phân tích điểm chuẩn**: Biểu đồ so sánh điểm chuẩn qua các năm, xu hướng tuyển sinh
- **Tư vấn AI thông minh**: Chatbot AI hỗ trợ tư vấn chọn ngành phù hợp
- **Quản lý ngành yêu thích**: Lưu và theo dõi các ngành học quan tâm
- **Đọc tin tức giáo dục**: Cập nhật thông tin tuyển sinh mới nhất

### 🛠️ Cho quản trị viên:
- **Quản lý ngành học**: CRUD ngành học, phương thức xét tuyển, tổ hợp môn
- **Quản lý điểm chuẩn**: Cập nhật điểm chuẩn theo năm và phương thức
- **Quản lý nội dung**: Tạo và chỉnh sửa bài viết, tin tức tuyển sinh
- **Thống kê và báo cáo**: Theo dõi lượt truy cập, tương tác người dùng
- **Quản lý người dùng**: Xem và quản lý tài khoản học sinh

## 🏗️ Kiến trúc hệ thống

### **Backend Architecture**
```
┌─────────────────────────────────────────────────────────────┐
│                        Frontend (Blade Templates)           │
├─────────────────────────────────────────────────────────────┤
│                     Laravel Framework (PHP)                 │
├─────────────────────────────────────────────────────────────┤
│  Controllers  │  Models  │  Middleware  │  Services  │ APIs │
├─────────────────────────────────────────────────────────────┤
│                      Database (MySQL)                       │
└─────────────────────────────────────────────────────────────┘
```

### **Cấu trúc MVC:**
- **Models**: Major, User, Blog, AdmissionMethod, SubjectCombination, etc.
- **Views**: Blade templates cho user interface và admin dashboard
- **Controllers**: Xử lý logic nghiệp vụ, API endpoints
- **Database**: MySQL với quan hệ chuẩn hóa

### **Các tính năng chính:**
- 🔐 **Authentication**: Đăng ký/đăng nhập người dùng
- 📊 **Data Visualization**: Chart.js cho biểu đồ điểm chuẩn
- 🤖 **AI Integration**: Chatbot tư vấn ngành học
- 📱 **Responsive Design**: Tương thích mobile và desktop
- 🔍 **Search & Filter**: Tìm kiếm ngành học, lọc theo danh mục

## 💻 Yêu cầu hệ thống

### **Phần mềm cần thiết:**

#### 1. **Web Server Environment:**
- **XAMPP** (Windows) hoặc **MAMP** (macOS) hoặc **LAMP** (Linux)
- Hoặc **Laragon** (Recommended cho Windows)

#### 2. **PHP Requirements:**
- **PHP >= 8.1**
- Extensions: mbstring, openssl, pdo, tokenizer, xml, ctype, json, bcmath

#### 3. **Database:**
- **MySQL >= 5.7** hoặc **MariaDB >= 10.3**

#### 4. **Composer:**
- **Composer >= 2.0** (PHP Dependency Manager)

#### 5. **Node.js (Optional):**
- **Node.js >= 16** (cho Vite build tools)
- **NPM** hoặc **Yarn**

## 🚀 Cách cài đặt và chạy

### **Bước 1: Clone dự án**
```bash
git clone <repository-url>
cd TuyenSinhProjectV3
```

### **Bước 2: Cài đặt dependencies**
```bash
# Cài đặt PHP dependencies
composer install

# Cài đặt Node.js dependencies (nếu cần)
npm install
```

### **Bước 3: Cấu hình môi trường**
```bash
# Sao chép file môi trường
cp .env.example .env

# Tạo application key
php artisan key:generate
```

### **Bước 4: Cấu hình database**
Chỉnh sửa file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tuyensinhdb
DB_USERNAME=root
DB_PASSWORD=
```

### **Bước 5: Tạo và import database**
```bash
# Tạo database
mysql -u root -p -e "CREATE DATABASE tuyensinhdb"

# Import dữ liệu mẫu
mysql -u root -p tuyensinhdb < tuyensinhdb.sql
```

### **Bước 6: Chạy migrations (nếu cần)**
```bash
php artisan migrate
```

### **Bước 7: Khởi động server**
```bash
# Khởi động Laravel development server
php artisan serve

# Hoặc sử dụng web server (Laragon/XAMPP)
# Truy cập: http://localhost/TuyenSinhProjectV3/public
```

## 🌐 Truy cập hệ thống

### **Giao diện người dùng:**
- URL: `http://localhost:8000` (nếu dùng `php artisan serve`)
- URL: `http://localhost/TuyenSinhProjectV3/public` (nếu dùng XAMPP/Laragon)

### **Giao diện admin:**
- URL: `http://localhost:8000/admin`
- Tài khoản admin mặc định: (xem trong database seeder)

## 📁 Cấu trúc thư mục

```
TuyenSinhProjectV3/
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Providers/           # Service Providers
├── database/
│   ├── migrations/          # Database migrations
│   └── seeders/            # Database seeders
├── public/
│   ├── assets/             # CSS, JS, Images
│   └── index.php           # Entry point
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Source CSS
│   └── js/                 # Source JavaScript
├── routes/
│   ├── web.php             # Web routes
│   └── console.php         # Console commands
├── .env                    # Environment configuration
├── composer.json           # PHP dependencies
└── package.json           # Node.js dependencies
```

## 🛠️ Tính năng chính

### **🎓 Quản lý ngành học:**
- Thêm, sửa, xóa thông tin ngành học
- Quản lý phương thức xét tuyển
- Cập nhật điểm chuẩn theo năm

### **📊 Phân tích dữ liệu:**
- Biểu đồ điểm chuẩn qua các năm
- Thống kê lượt xem, lượt yêu thích
- Báo cáo tương tác người dùng

### **🤖 AI Chatbot:**
- Tư vấn chọn ngành học phù hợp
- Trả lời câu hỏi về tuyển sinh
- Hỗ trợ 24/7

### **📱 Responsive Design:**
- Tương thích mobile, tablet, desktop
- UI/UX hiện đại, thân thiện

## 🔧 Troubleshooting

### **Lỗi thường gặp:**

1. **500 Server Error:**
   ```bash
   # Kiểm tra quyền thư mục
   chmod -R 755 storage bootstrap/cache
   
   # Xóa cache
   php artisan cache:clear
   php artisan config:clear
   ```

2. **Database Connection Error:**
   - Kiểm tra thông tin database trong `.env`
   - Đảm bảo MySQL service đang chạy

3. **Composer Dependencies:**
   ```bash
   composer update
   composer dump-autoload
   ```

## 📞 Hỗ trợ

Nếu gặp vấn đề trong quá trình cài đặt hoặc sử dụng, vui lòng:
- Kiểm tra file log: `storage/logs/laravel.log`
- Đảm bảo đáp ứng đủ system requirements
- Liên hệ team phát triển để được hỗ trợ

## 📄 License

Dự án này được phát triển cho mục đích học tập và nghiên cứu.
