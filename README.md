# Employee Monitor

Employee Monitor adalah aplikasi web untuk memantau dan mengelola aktivitas karyawan dalam perusahaan. Sistem ini memungkinkan manajemen untuk memantau absensi, log aktivitas karyawan, serta mengelola pengguna dalam organisasi.

## 📋 Deskripsi Project

Employee Monitor adalah sistem manajemen karyawan berbasis web yang dikembangkan menggunakan Laravel framework. Aplikasi ini dirancang untuk membantu perusahaan dalam:

-   **Monitoring Absensi**: Memantau waktu masuk dan keluar karyawan
-   **Tracking Aktivitas**: Mencatat dan memantau aktivitas harian karyawan
-   **Manajemen User**: Mengelola pengguna dan role dalam sistem
-   **Dashboard Analytics**: Menyediakan ringkasan dan analitik data karyawan

## ✨ Fitur Utama

### 🔐 **Multi-Role System**

-   **Admin**: Mengelola semua pengguna dan memiliki akses penuh ke sistem
-   **Manajemen**: Memantau absensi dan aktivitas karyawan
-   **Karyawan**: Melakukan absensi dan mencatat aktivitas harian

### 👤 **Fitur untuk Admin**

-   Manajemen pengguna (CRUD operations)
-   Assign role kepada pengguna
-   Dashboard overview semua aktivitas
-   Statistik keseluruhan sistem

### 🏢 **Fitur untuk Manajemen**

-   Monitoring absensi karyawan real-time
-   Melihat detail log aktivitas per karyawan
-   Export data log aktivitas ke CSV
-   Dashboard analytics per karyawan
-   Filter data berdasarkan tanggal dan rentang waktu

### 👩‍💼 **Fitur untuk Karyawan**

-   **Sistem Absensi:**
    -   Check-in dan Check-out
    -   Absensi dengan status (Masuk, Sakit, Izin)
    -   Upload bukti untuk absensi sakit/izin
    -   History absensi pribadi
-   **Log Aktivitas:**
    -   Mencatat aktivitas harian
    -   Upload link bukti pekerjaan
    -   Edit dan update aktivitas
    -   Filter berdasarkan tanggal
-   **Dashboard Personal:**
    -   Status absensi hari ini
    -   History absensi
    -   Statistik kehadiran bulanan

### 📊 **Dashboard & Analytics**

-   Grafik kehadiran karyawan
-   Total users aktif
-   Status absensi real-time
-   Statistik per bulan (Masuk, Sakit, Izin)

### 📱 **Fitur Tambahan**

-   Responsive design untuk desktop dan mobile
-   Dark mode support
-   Real-time notifications
-   Export data ke CSV
-   Filter dan pencarian advanced
-   Profile management

## 🛠 Teknologi yang Digunakan

### **Backend:**

-   **Laravel 11.x** - PHP Framework
-   **PHP 8.2+** - Programming Language
-   **SQLite** - Database
-   **Eloquent ORM** - Database relationships
-   **Laravel Breeze** - Authentication starter kit
-   **Laravel UI** - Frontend scaffolding

### **Frontend:**

-   **Blade Templates** - Laravel templating engine
-   **Tailwind CSS** - CSS Framework
-   **Alpine.js** - JavaScript Framework
-   **Vue.js 3** - Progressive JavaScript Framework
-   **Bootstrap 5** - Additional UI components
-   **Preline UI** - UI component library
-   **Vite** - Frontend build tool

### **Development Tools:**

-   **Composer** - PHP dependency management
-   **NPM** - Node package management
-   **Sass** - CSS preprocessor
-   **PHPUnit** - Testing framework
-   **Laravel Pint** - Code style fixer
-   **Laravel Sail** - Docker development environment

### **Additional Libraries:**

-   **Carbon** - Date manipulation library
-   **Faker** - Generate fake data for testing
-   **Guzzle** - HTTP client
-   **Monolog** - Logging library

## 📁 Struktur Database

### **Tables:**

-   `users` - Data pengguna
-   `roles` - Master role (admin, manajemen, karyawan)
-   `role_user` - Pivot table untuk many-to-many relationship
-   `absensis` - Data absensi karyawan
-   `log_aktivitas` - Log aktivitas harian karyawan

### **Key Relationships:**

-   User belongsToMany Roles
-   User hasMany Absensi
-   User hasMany LogAktivitas
-   LogAktivitas belongsTo User
-   Absensi belongsTo User

## ⚡ Requirements

-   **PHP**: >= 8.2
-   **Composer**: Latest version
-   **Node.js**: >= 16.x
-   **NPM**: Latest version
-   **SQLite**: 3.x (atau MySQL/PostgreSQL)

## 🚀 Instalasi

1. **Clone repository:**

```bash
git clone <repository-url>
cd EmployeeMonitor
```

2. **Install dependencies:**

```bash
composer install
npm install
```

3. **Setup environment:**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Database setup:**

```bash
touch database/database.sqlite
php artisan migrate
php artisan db:seed
```

5. **Build frontend assets:**

```bash
npm run build
# atau untuk development
npm run dev
```

6. **Run application:**

```bash
php artisan serve
```

## 👥 Default Users

Setelah seeding, tersedia default users:

-   **Admin**: admin@example.com / password
-   **Manajemen**: manajemen@example.com / password
-   **Karyawan**: karyawan@example.com / password

## 📖 Penggunaan

### **Login sebagai Admin:**

1. Login menggunakan kredensial admin
2. Kelola pengguna di menu "User Management"
3. Assign role sesuai kebutuhan
4. Monitor dashboard untuk overview sistem

### **Login sebagai Manajemen:**

1. Login menggunakan kredensial manajemen
2. Cek absensi karyawan di "Cek Absensi"
3. Monitor aktivitas di "Cek Log Aktivitas"
4. Export data sesuai kebutuhan

### **Login sebagai Karyawan:**

1. Login menggunakan kredensial karyawan
2. Lakukan absensi masuk/keluar
3. Catat aktivitas harian
4. Update log aktivitas dengan bukti pekerjaan

## 🔧 Development

### **Running Tests:**

```bash
php artisan test
```

### **Code Formatting:**

```bash
./vendor/bin/pint
```

### **Watch for changes:**

```bash
npm run dev
```

## 📄 **Lisensi**

© 2024 Fadhad Wahyu Aji. All rights reserved.

This project is developed by Fadhad Wahyu Aji as part of an internship challenge program. The code is provided for educational and demonstration purposes.

**Permissions:**

-   ✅ Private use
-   ✅ Study and learning
-   ✅ Modification for educational purposes

**Limitations:**

-   ❌ Commercial use without permission
-   ❌ Distribution without attribution
-   ❌ Patent use

**Conditions:**

-   📝 License and copyright notice must be included
-   📝 Attribution to original author required

For commercial use or other licensing arrangements, please contact the author.

---

**Developer Information:**

-   **Name**: Fadhad Wahyu Aji
-   **Year**: 2024
-   **Project Type**: Internship Challenge - Employee Monitoring System
-   **Framework**: Laravel 11.x
-   **Contact**: [Add your contact information here]

---

_Made with ❤️ during internship program_

## 👨‍💻 Developer

Dikembangkan sebagai project magang/challenge untuk sistem monitoring karyawan.

---

**Note**: Pastikan untuk mengubah kredensial default sebelum deployment ke production environment.
