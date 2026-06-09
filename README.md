# 💼 JobConnect - Nền tảng Tuyển dụng & Tìm Việc

## 📋 Mục Lục

- [Giới thiệu](#giới-thiệu)
- [Tính năng nổi bật](#tính-năng-nổi-bật)
- [Công nghệ sử dụng](#công-nghệ-sử-dụng)
- [Kiến trúc hệ thống](#kiến-trúc-hệ-thống)
- [Luồng nghiệp vụ](#luồng-nghiệp-vụ)
- [Cơ sở dữ liệu](#cơ-sở-dữ-liệu)
- [Hướng dẫn cài đặt](#hướng-dẫn-cài-đặt)
- [Cách sử dụng](#cách-sử-dụng)
- [Kỹ năng áp dụng](#kỹ-năng-áp-dụng)

---

## 🎯 Giới Thiệu

**JobConnect** là một nền tảng tuyển dụng và tìm kiếm việc làm hiện đại được xây dựng với **Laravel 12.0** và **PHP 8.2+**. Dự án này cung cấp một giải pháp toàn diện cho:

- 👨‍💼 **Admin**: Quản lý hệ thống, duyệt tin tuyển dụng, quản lý người dùng
- 🏢 **Nhà Tuyển Dụng**: Đăng tin tuyển dụng, xem hồ sơ ứng viên, quản lý công ty
- 👥 **Ứng Viên**: Tìm kiếm việc làm, ứng tuyển, quản lý hồ sơ cá nhân

Hệ thống hỗ trợ **chat realtime**, **thông báo tức thời**, và **quản lý danh mục** đầy đủ, giúp kết nối hiệu quả giữa ứng viên và nhà tuyển dụng.

---

## ✨ Tính Năng Nổi Bật

### 🔐 Xác Thực & Phân Quyền
- ✅ Đăng ký / Đăng nhập (3 vai trò: Admin, Employer, Candidate)
- ✅ Phân quyền (Authorization) dựa trên vai trò
- ✅ Đổi mật khẩu an toàn
- ✅ Session management với database driver

### 👤 Quản Lý Hồ Sơ
- ✅ Hồ sơ cá nhân (thông tin cơ bản, kỹ năng, kinh nghiệm, học vấn)
- ✅ Tải lên CV/Hồ sơ (PDF Parser, Tesseract OCR)
- ✅ Quản lý thông tin công ty (cho Employer)
- ✅ Ảnh đại diện, banner công ty

### 💼 Quản Lý Tin Tuyển Dụng
- ✅ Đăng tin tuyển dụng (Employer)
- ✅ Duyệt tin tuyển dụng (Admin)
- ✅ Tìm kiếm theo danh mục, địa điểm, loại công việc
- ✅ Lưu tin yêu thích
- ✅ Xem chi tiết tin tuyển dụng (mô tả, yêu cầu, kỹ năng cần thiết, mức lương)
- ✅ Theo dõi lượt xem tin

### 📝 Quản Lý Ứng Tuyển
- ✅ Ứng tuyển tin tuyển dụng với CV
- ✅ Theo dõi trạng thái ứng tuyển (Pending, Reviewing, Approved, Rejected)
- ✅ Tải lên lại CV cho từng ứng tuyển
- ✅ Lịch sử ứng tuyển chi tiết
- ✅ Từ chối ứng tuyển (có lý do)

### 💬 Chat & Thông Báo Realtime
- ✅ Chat realtime giữa ứng viên và nhà tuyển dụng
- ✅ Thông báo tức thời (Broadcasting via Pusher/Laravel Echo)
- ✅ Danh sách hội thoại với tin nhắn cuối cùng
- ✅ Hỗ trợ hình ảnh và tệp đính kèm trong chat
- ✅ Đánh dấu tin nhắn đã đọc

### 📊 Dashboard & Thống Kê
- ✅ Dashboard Admin: Tổng quan hệ thống, thống kê người dùng, tin tuyển dụng
- ✅ Dashboard Employer: Số lượng tin đăng, ứng tuyển, lượt xem
- ✅ Dashboard Candidate: Tin đã lưu, ứng tuyển, hồ sơ

### 🏷️ Quản Lý Danh Mục
- ✅ Quản lý danh mục công việc (Admin)
- ✅ Quản lý địa điểm (Admin)
- ✅ Quản lý loại công việc (Admin)
- ✅ Quản lý kỹ năng (Admin)
- ✅ Quản lý người dùng (Admin)
- ✅ Duyệt nhà tuyển dụng (Admin)

---

## 🛠️ Công Nghệ Sử Dụng

| Công Nghệ | Phiên Bản | Mô Tả |
|-----------|-----------|-------|
| **Laravel** | 12.0 | Framework Backend MVC |
| **PHP** | 8.2+ | Ngôn ngữ lập trình |
| **MySQL** | Latest | Cơ sở dữ liệu |
| **Bootstrap** | 5.3 | UI Framework (Frontend) |
| **TailwindCSS** | 4.0 | Utility-first CSS Framework |
| **Vite** | 7.0+ | Build tool & Dev server |
| **Laravel Echo** | 2.3+ | WebSocket client |
| **Pusher** | 7.2 / 8.5 | Realtime Broadcasting |
| **Eloquent ORM** | Latest | Database Query Builder |
| **PDF Parser** | 2.12 | Đọc/phân tích PDF |
| **Tesseract OCR** | 2.13 | Nhận dạng chữ từ hình ảnh |

---

## 🏗️ Kiến Trúc Hệ Thống

### MVC Architecture
```
app/
├── Models/              # Eloquent Models (15 models)
├── Http/Controllers/    # Controllers (Admin, Employer, Candidate)
├── Http/Middleware/     # Custom Middleware (Admin, Employer, Candidate)
├── Events/              # Broadcasting Events
└── Listeners/           # Event Listeners
```

### Các Thành Phần Chính

#### 📌 Models (15 Models)
| Model | Mô Tả |
|-------|-------|
| **User** | User chính (Authenticatable) |
| **Candidate** | Thông tin ứng viên |
| **Employer** | Thông tin nhà tuyển dụng |
| **Job** | Tin tuyển dụng |
| **Application** | Đơn ứng tuyển |
| **Conversation** | Hội thoại (giữa Candidate & Employer) |
| **Message** | Tin nhắn |
| **Notification** | Thông báo |
| **SavedJob** | Tin yêu thích |
| **CV** | Hồ sơ/CV |
| **ApplicationLog** | Lịch sử ứng tuyển |
| **Category** | Danh mục công việc |
| **Location** | Địa điểm |
| **JobType** | Loại công việc |
| **Skill** | Kỹ năng |

#### 🎮 Controllers Chính

**Admin Controllers:**
- `AdminController` - Dashboard thống kê
- `UserController` - CRUD người dùng
- `EmployerController` - Duyệt nhà tuyển dụng
- `JobController` - Duyệt tin tuyển dụng
- `CategoryController`, `LocationController`, `JobTypeController`, `SkillController` - CRUD danh mục

**Employer Controllers:**
- `EmployerController` - Dashboard
- `JobController` - Quản lý tin tuyển dụng
- `CompanyController` - Quản lý công ty

**Candidate Controllers:**
- `CandidateController` - Dashboard
- `ProfileController` - Quản lý hồ sơ cá nhân
- `CVController` - Tải lên/quản lý CV
- `SavedJobController` - Quản lý tin yêu thích

**Shared Controllers:**
- `AuthController` - Xác thực người dùng
- `AdminAuthController` - Xác thực admin
- `ChatController` - Chat realtime
- `ApplicationController` - Quản lý ứng tuyển
- `NotificationController` - Quản lý thông báo

#### 🔒 Middleware
- `AdminMiddleware` - Bảo vệ route admin
- `EmployerMiddleware` - Bảo vệ route employer
- `CandidateMiddleware` - Bảo vệ route candidate

#### 📡 Broadcasting Events
- `MessageSent` - Gửi tin nhắn (ShouldBroadcast)
- `MessageSeen` - Đánh dấu tin nhắn đã đọc
- `NewMessageNotification` - Thông báo tin nhắn mới
- `ChatListUpdated` - Cập nhật danh sách chat

#### 🔄 Queue & Broadcasting
- **Queue Connection**: Database
- **Broadcast Driver**: Log (có thể cấu hình Pusher)
- **Session**: Database driver
- **Cache**: Database

---

## 📊 Cơ Sở Dữ Liệu

### Bảng Chính
- `users` - Người dùng
- `candidates` - Thông tin ứng viên
- `employers` - Thông tin nhà tuyển dụng
- `jobs` - Tin tuyển dụng
- `applications` - Đơn ứng tuyển
- `conversations` - Hội thoại
- `messages` - Tin nhắn
- `notifications` - Thông báo
- `saved_jobs` - Tin yêu thích
- `cvs` - Hồ sơ CV
- `application_logs` - Lịch sử ứng tuyển
- `categories` - Danh mục
- `locations` - Địa điểm
- `job_types` - Loại công việc
- `skills` - Kỹ năng
- `job_skills` - Mối quan hệ Job & Skill (Many-to-Many)

---

## 🔄 Luồng Nghiệp Vụ

### 👥 Luồng Ứng Viên (Candidate)

```
1. Đăng ký tài khoản (vai trò: Candidate)
   ↓
2. Hoàn thiện hồ sơ cá nhân (thông tin, kỹ năng, kinh nghiệm)
   ↓
3. Tải lên CV (hỗ trợ PDF, OCR)
   ↓
4. Tìm kiếm việc làm (theo danh mục, địa điểm, loại công việc)
   ↓
5. Lưu tin yêu thích (SavedJob)
   ↓
6. Ứng tuyển tin tuyển dụng
   ↓
7. Theo dõi trạng thái ứng tuyển (Pending → Reviewing → Approved/Rejected)
   ↓
8. Chat realtime với nhà tuyển dụng
   ↓
9. Nhận thông báo tức thời
```

### 🏢 Luồng Nhà Tuyển Dụng (Employer)

```
1. Đăng ký tài khoản (vai trò: Employer)
   ↓
2. Chờ duyệt từ Admin
   ↓
3. Hoàn thiện thông tin công ty (logo, banner, mô tả)
   ↓
4. Đăng tin tuyển dụng (tiêu đề, mô tả, yêu cầu, kỹ năng, lương)
   ↓
5. Chờ Admin duyệt tin
   ↓
6. Xem hồ sơ ứng viên
   ↓
7. Duyệt/Từ chối ứng tuyển (với lý do)
   ↓
8. Chat realtime với ứng viên
   ↓
9. Quản lý công ty, tin tuyển dụng
```

### 👨‍💼 Luồng Admin

```
1. Đăng nhập admin
   ↓
2. Xem Dashboard (thống kê)
   ↓
3. Quản lý người dùng (CRUD)
   ↓
4. Duyệt/Từ chối Employer
   ↓
5. Duyệt/Từ chối tin tuyển dụng
   ↓
6. Quản lý danh mục (Category, Location, JobType, Skill)
   ↓
7. Xem báo cáo ứng tuyển
```

---

## 📥 Hướng Dẫn Cài Đặt

### Yêu Cầu Hệ Thống
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL

### Bước 1: Clone Repository

```bash
git clone https://github.com/T1-Duc-Nguyen/job-portal-laravel
cd jobconnect
```

### Bước 2: Cài Đặt Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### Bước 3: Cấu Hình Environment

```bash
# Copy file .env
cp .env.example .env


# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=jobconnect
# DB_USERNAME=root
# DB_PASSWORD=
```

### Bước 4: Generate Application Key

```bash
php artisan key:generate
```

### Bước 5: Chạy Database Migration & Seeding

```bash
# Tạo bảng trong database
php artisan migrate

# (Optional) Seeding dữ liệu mẫu
php artisan db:seed
```

### Bước 6: Build Frontend Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### Bước 7: Cấu Hình Pusher (tuỳ chọn, để realtime chat)

Nếu muốn dùng Pusher để chat realtime, cập nhật file `.env`:

```env
BROADCAST_DRIVER=pusher
PUSHER_APP_ID=your_app_id
PUSHER_APP_KEY=your_app_key
PUSHER_APP_SECRET=your_app_secret
PUSHER_APP_CLUSTER=your_cluster
```

Nếu không dùng Pusher, mặc định sử dụng `log` driver:

```env
BROADCAST_CONNECTION=log
```

### Bước 8: Chạy Application

#### Option 1: Sử dụng PHP Built-in Server

```bash
php artisan serve
```

Truy cập: http://localhost:8000

#### Option 2: Sử dụng Script Dev (Recommended)

```bash
composer run dev
```

Script này sẽ chạy đồng thời:
- PHP Server (localhost:8000)
- Queue Listener
- Vite Dev Server
- Pail (Log viewer)



## 🚀 Cách Sử Dụng



### URL Chính

| Tính Năng | URL |
|-----------|-----|
| Home | `/` |
| Job List | `/jobs` |
| Job Detail | `/jobs/{slug}` |
| Login | `/login` |
| Register | `/register` |
| Admin Dashboard | `/admin` |
| Candidate Dashboard | `/candidate/dashboard` |
| Employer Dashboard | `/employer/dashboard` |
| Chat | `/chat` |
| Notifications | `/notifications` |

### Quy Trình Ứng Tuyển Ví Dụ

```
1. Đăng ký → /register → Chọn vai trò "Candidate"
2. Đăng nhập → /login
3. Hoàn thiện hồ sơ → /candidate/profile/edit
4. Tải lên CV → /candidate/profile (CV upload section)
5. Tìm việc → /jobs
6. Ứng tuyển → Nhấn nút "Ứng Tuyển" → Chọn CV
7. Theo dõi → /candidate/applications
8. Chat → /chat (khi nhà tuyển dụng phản hồi)
```

---

## 📚 Kỹ Năng Áp Dụng

### Backend (Laravel/PHP)
- ✅ **MVC Architecture** - Phân chia Controller, Model, View rõ ràng
- ✅ **Eloquent ORM** - Query builder, relationships (HasMany, BelongsTo, BelongsToMany)
- ✅ **Authentication & Authorization** - Laravel Auth, Policy, Middleware
- ✅ **Database Relationships** - One-to-Many, Many-to-Many (via pivot table)
- ✅ **Middleware** - Custom middleware cho phân quyền
- ✅ **Form Validation** - Request validation, Form Request
- ✅ **Event & Broadcasting** - Event listener, ShouldBroadcast
- ✅ **Queue & Jobs** - Database queue driver
- ✅ **RESTful Routing** - Structured routes với prefix
- ✅ **File Upload** - PDF parsing, OCR, file storage
- ✅ **Database Migration** - Versioned schema, seeding
- ✅ **CRUD Operations** - Create, Read, Update, Delete

### Frontend
- ✅ **Bootstrap 5** - Responsive UI components
- ✅ **TailwindCSS** - Utility-first styling
- ✅ **Blade Templates** - Laravel templating engine
- ✅ **JavaScript** - Async operations, AJAX
- ✅ **Vite** - Modern bundler & dev server

### Realtime & WebSocket
- ✅ **Laravel Broadcasting** - Event broadcasting channels
- ✅ **Laravel Echo** - Frontend WebSocket client
- ✅ **Pusher Integration** - Real-time messaging service
- ✅ **Private Channels** - Secure broadcaster communication

### Database Design
- ✅ **Entity Relationship Modeling** - Proper schema design
- ✅ **Indexing** - Performance optimization
- ✅ **Foreign Keys** - Data integrity
- ✅ **Timestamps** - created_at, updated_at tracking

### DevOps & Deployment
- ✅ **Environment Configuration** - .env management
- ✅ **Composer** - PHP dependency management
- ✅ **NPM** - JavaScript package management
- ✅ **Version Control** - Git, GitHub

---

## 📁 Cấu Trúc Thư Mục Dự Án

```
jobconnect/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Tất cả controllers
│   │   ├── Middleware/       # Custom middleware
│   │   └── Requests/         # Form validation
│   ├── Models/               # 15 Eloquent models
│   ├── Events/               # Broadcasting events
│   └── Listeners/            # Event listeners
├── routes/
│   ├── web.php              # Web routes
│   ├── channels.php         # Broadcasting channels
│   └── console.php          # Console commands
├── database/
│   ├── migrations/          # Database migrations
│   ├── factories/           # Model factories
│   └── seeders/             # Database seeders
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # CSS files
│   └── js/                  # JavaScript files
├── public/                  # Static assets
├── storage/                 # Files, logs
├── tests/                   # Test files
├── config/                  # Configuration files
├── bootstrap/               # Framework bootstrap
├── .env.example            # Environment template
├── composer.json           # PHP dependencies
├── package.json            # JavaScript dependencies
└── vite.config.js          # Vite configuration
```

---


## 📝 Ghi Chú Phát Triển

### Các Tính Năng Có Thể Mở Rộng

- 🔔 Email notification khi có ứng tuyển mới
- 📈 Advanced analytics & reporting
- ⭐ Rating & Review system
- 🔍 Advanced job filter & search (Elasticsearch)
- 📱 Mobile app (React Native/Flutter)
- 🌐 Multi-language support
- 🔐 Two-Factor Authentication (2FA)
- 🎯 Job recommendations engine
- 💳 Payment integration (Premium features)



## 👨‍💻 Tác Giả

**Nguyen Duc Nguyen**
- 📧 Email: nguyenducnguyen201811@gmail.com
- 🔗 GitHub: https://github.com/T1-Duc-Nguyen

---


