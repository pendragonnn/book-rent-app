# 📚 Book Rental Application

A Laravel-based book rental management system with UUID-based primary keys.  
Features include book catalog management, borrowing transactions, user roles (Admin & Member), and payment status tracking.

---

## 🚀 Requirements

Sebelum menjalankan aplikasi ini, pastikan kamu sudah menginstal:

- **PHP** >= 8.1
- **Composer**
- **MySQL / MariaDB**
- **Node.js** & **NPM** (opsional, jika ingin menjalankan frontend dengan Laravel Mix atau Vite)
- **Git**

---

## 📥 Installation

Ikuti langkah-langkah berikut untuk menjalankan project setelah clone dari GitHub.

### 1. Clone Repository
```bash
git clone https://github.com/username/book-rental-app.git
cd book-rental-app
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Konfigurasi Environment
Buat file .env dari template .env.example:
```bash
cp .env.example .env
```

Lalu ubah pengaturan database di .env sesuai format .env.example kebutuhan:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=book_rent_app
DB_USERNAME=root
DB_PASSWORD=
```

💡 Catatan: Pastikan database book_rent_app sudah dibuat di MySQL.
Jika ingin membuatnya otomatis, jalankan command custom php artisan db:create (jika tersedia di project).

### 4. Migrasi Database & Seeding
Jalankan perintah berikut untuk membuat database sebelum melakukan seeding:
```bash
php artisan db:create
```

Jalankan perintah berikut untuk membuat tabel dan mengisi data awal:

```bash
php artisan migrate --seed
```

### 5. Menjalankan Server
```bash
php artisan serve
Akses aplikasi di: http://localhost:8000
```

