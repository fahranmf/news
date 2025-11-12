# 📰 Aplikasi Berita (News App)

Aplikasi web sederhana untuk mengelola dan menampilkan berita yang dibuat menggunakan Laravel 12. Aplikasi ini dikembangkan untuk tujuan pembelajaran mahasiswa dalam memahami konsep MVC (Model-View-Controller), ORM (Object-Relational Mapping), dan routing di Laravel.

> 📚 **[Lihat Semua Dokumentasi](docs/README.md)** | 📰 **[NewsResource Docs](docs/NewsResource.md)** | 👤 **[WartawanResource Docs](docs/WartawanResource.md)**

## 📋 Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Instalasi](#instalasi)
- [Arsitektur Aplikasi](#arsitektur-aplikasi)
- [Struktur Database](#struktur-database)
- [Cara Kerja Routing](#cara-kerja-routing)
- [Model dan Relasi](#model-dan-relasi)
- [Controller](#controller)
- [Filament Admin Panel](#-filament-admin-panel)
- [Panduan Pengembangan](#panduan-pengembangan)
- [Referensi Laravel](#referensi-laravel)

## 🎯 Tentang Aplikasi

Aplikasi Berita adalah sistem manajemen konten sederhana yang memungkinkan:
- Menampilkan daftar berita
- Melihat detail berita lengkap dengan informasi wartawan
- Menampilkan komentar pada setiap berita
- Mengelola data wartawan sebagai penulis berita
- **Admin panel dengan Filament untuk manajemen data (CRUD)**

Aplikasi ini dibangun dengan fokus pada pemahaman konsep dasar Laravel dan best practices dalam pengembangan web modern.

## 🛠 Teknologi yang Digunakan

| Teknologi | Versi | Keterangan |
|-----------|-------|------------|
| **PHP** | ^8.2 | Bahasa pemrograman server-side |
| **Laravel Framework** | ^12.0 | Framework PHP MVC |
| **Filament** | ^3.x | Admin Panel & CRUD Generator |
| **Composer** | Latest | Dependency manager untuk PHP |
| **NPM** | Latest | Package manager untuk JavaScript |
| **Vite** | Latest | Build tool untuk frontend assets |
| **MySQL/PostgreSQL** | Latest | Database relasional |

### Package Laravel yang Digunakan:
- **Filament PHP** - Admin panel untuk manajemen data (CRUD)
- **Laravel Tinker** - REPL untuk testing dan debugging
- **Laravel Pint** - Code style fixer
- **Laravel Sail** - Docker development environment
- **Faker PHP** - Generator data dummy untuk testing

## ⚙️ Persyaratan Sistem

Sebelum menjalankan aplikasi, pastikan sistem Anda memiliki:

- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL atau PostgreSQL
- Web Server (Apache/Nginx) atau bisa menggunakan Laravel built-in server

Untuk Windows, disarankan menggunakan:
- **Laragon** (sudah include PHP, MySQL, Apache)
- **XAMPP**
- **Herd**

## 📥 Instalasi

### 1. Clone atau Download Repository

```bash
# Clone repository (jika menggunakan git)
git clone <repository-url>
cd news-app
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies JavaScript

```bash
npm install
```

### 4. Konfigurasi Environment

```bash
# Copy file .env.example menjadi .env
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_app
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migration & Seeder

```bash
# Membuat tabel-tabel di database
php artisan migrate

# (Optional) Generate data dummy untuk testing
php artisan db:seed
```

### 7. Build Assets Frontend

```bash
# Untuk development (dengan hot reload)
npm run dev

# Untuk production
npm run build
```

### 8. Jalankan Aplikasi

```bash
# Menggunakan Laravel built-in server
php artisan serve
```

Akses aplikasi di browser: `http://localhost:8000`

## 🏗 Arsitektur Aplikasi

Aplikasi ini menggunakan arsitektur **MVC (Model-View-Controller)** yang merupakan pola desain standar Laravel:

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ HTTP Request
       ▼
┌─────────────────────────────────────┐
│          ROUTES (web.php)           │
│  - Menerima request dari user       │
│  - Menentukan Controller mana yang  │
│    akan menangani request           │
└──────────────┬──────────────────────┘
               │
               ▼
┌─────────────────────────────────────┐
│         CONTROLLER                  │
│  - Menerima request dari route      │
│  - Memproses business logic         │
│  - Mengambil data dari Model        │
│  - Mengirim data ke View            │
└──────────────┬──────────────────────┘
               │
               ├─────────────────┐
               ▼                 ▼
        ┌────────────┐    ┌───────────┐
        │   MODEL    │    │   VIEW    │
        │  - News    │    │ - Blade   │
        │  - Wartawan│    │ Templates │
        │  - Komentar│    │           │
        └─────┬──────┘    └─────┬─────┘
              │                 │
              ▼                 │
        ┌────────────┐          │
        │  DATABASE  │          │
        └────────────┘          │
                                ▼
                          ┌──────────┐
                          │ Response │
                          │   HTML   │
                          └──────────┘
```

### Penjelasan Alur Request:

1. **User mengakses URL** (misalnya: `http://localhost:8000/`)
2. **Routes** menangkap request dan mencocokkan dengan definisi route di `routes/web.php`
3. **Controller** yang sesuai dipanggil untuk memproses request
4. **Model** berinteraksi dengan database untuk mengambil atau menyimpan data
5. **View** (Blade template) menerima data dari controller dan me-render HTML
6. **Response** dikirim kembali ke browser user

## 🗄 Struktur Database

Aplikasi ini memiliki 3 tabel utama dengan relasi sebagai berikut:

```
┌─────────────────┐
│    wartawan     │
├─────────────────┤
│ id (PK)         │
│ nama            │
│ email           │
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │
         │ 1:N (One to Many)
         │
         ▼
┌─────────────────┐
│      news       │
├─────────────────┤
│ id (PK)         │
│ judul           │
│ ringkasan       │
│ isi             │
│ wartawan_id (FK)│
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │
         │ 1:N (One to Many)
         │
         ▼
┌─────────────────┐
│    komentar     │
├─────────────────┤
│ id (PK)         │
│ nama            │
│ isi             │
│ news_id (FK)    │
│ created_at      │
│ updated_at      │
└─────────────────┘
```

### Penjelasan Tabel:

#### 1. Tabel `wartawan`
Menyimpan data jurnalis/reporter yang menulis berita.

| Field | Type | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Primary key, auto increment |
| nama | VARCHAR | Nama wartawan |
| email | VARCHAR | Email wartawan |
| created_at | TIMESTAMP | Waktu data dibuat |
| updated_at | TIMESTAMP | Waktu data terakhir diupdate |

#### 2. Tabel `news`
Menyimpan data berita.

| Field | Type | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Primary key, auto increment |
| judul | VARCHAR | Judul berita |
| ringkasan | TEXT | Ringkasan/preview berita |
| isi | TEXT | Konten lengkap berita |
| wartawan_id | BIGINT (FK) | Foreign key ke tabel wartawan |
| created_at | TIMESTAMP | Waktu berita dibuat |
| updated_at | TIMESTAMP | Waktu berita terakhir diupdate |

#### 3. Tabel `komentar`
Menyimpan komentar pembaca pada berita.

| Field | Type | Keterangan |
|-------|------|------------|
| id | BIGINT (PK) | Primary key, auto increment |
| nama | VARCHAR | Nama komentator |
| isi | TEXT | Isi komentar |
| news_id | BIGINT (FK) | Foreign key ke tabel news |
| created_at | TIMESTAMP | Waktu komentar dibuat |
| updated_at | TIMESTAMP | Waktu komentar terakhir diupdate |

### Relasi Database:

- **Wartawan → News**: One to Many (1:N)
  - Satu wartawan bisa menulis banyak berita
  
- **News → Komentar**: One to Many (1:N)
  - Satu berita bisa memiliki banyak komentar

## 🛣 Cara Kerja Routing

File routing utama aplikasi ada di `routes/web.php`. Mari kita bahas setiap route:

### Route 1: Halaman Daftar Berita

```php
Route::get('/', [NewsController::class, 'index'])->name('news.index');
```

**Penjelasan:**
- `Route::get('/')` → Menangani HTTP GET request ke URL root (`/`)
- `[NewsController::class, 'index']` → Memanggil method `index()` dari `NewsController`
- `->name('news.index')` → Memberikan nama route (untuk memudahkan referensi di view)

**Alur:**
1. User mengakses `http://localhost:8000/`
2. Laravel mencocokkan dengan route `GET /`
3. Method `index()` di `NewsController` dipanggil
4. Controller mengambil semua data berita dari database
5. Data dikirim ke view `news/index.blade.php`
6. HTML di-render dan ditampilkan ke user

### Route 2: Halaman Detail Berita

```php
Route::get('/news/{news}', [NewsController::class, 'show'])->name('news.show');
```

**Penjelasan:**
- `Route::get('/news/{news}')` → Menangani GET request dengan parameter dinamis
- `{news}` → Parameter dinamis yang akan diisi dengan ID berita
- `[NewsController::class, 'show']` → Memanggil method `show()` dari `NewsController`
- `->name('news.show')` → Nama route untuk referensi

**Route Model Binding:**
Laravel secara otomatis mengambil data dari database berdasarkan ID yang ada di URL. Misalnya:
- URL: `http://localhost:8000/news/5`
- Laravel otomatis query: `SELECT * FROM news WHERE id = 5`
- Hasilnya langsung di-inject ke parameter method `show(News $news)`

**Alur:**
1. User klik berita dengan ID 5
2. Browser mengakses `http://localhost:8000/news/5`
3. Laravel melakukan Route Model Binding
4. Method `show(News $news)` dipanggil dengan object News yang sudah terisi data
5. Controller me-load relasi (wartawan dan komentar)
6. Data dikirim ke view `news/show.blade.php`
7. HTML di-render dan ditampilkan

## 📦 Model dan Relasi

### 1. Model News (`app/Models/News.php`)

```php
class News extends Model
{
    protected $table = 'news';
    protected $fillable = ['judul', 'ringkasan', 'isi', 'wartawan_id'];

    // Relasi: News belongs to Wartawan (Many to One)
    public function wartawan()
    {
        return $this->belongsTo(Wartawan::class, 'wartawan_id');
    }

    // Relasi: News has many Komentar (One to Many)
    public function komentar()
    {
        return $this->hasMany(Komentar::class, 'news_id');
    }
}
```

**Penjelasan:**
- `$table = 'news'` → Menentukan nama tabel di database
- `$fillable` → Kolom yang boleh diisi secara mass assignment
- `belongsTo(Wartawan::class)` → Setiap berita ditulis oleh 1 wartawan
- `hasMany(Komentar::class)` → Setiap berita bisa punya banyak komentar

**Cara Menggunakan Relasi:**

```php
// Mengambil wartawan dari sebuah berita
$berita = News::find(1);
echo $berita->wartawan->nama; // Output: Nama wartawan

// Mengambil semua komentar dari sebuah berita
$komentar_list = $berita->komentar;
foreach($komentar_list as $komentar) {
    echo $komentar->isi;
}
```

### 2. Model Wartawan (`app/Models/Wartawan.php`)

```php
class Wartawan extends Model
{
    protected $table = 'wartawan';
    protected $fillable = ['nama', 'email'];

    // Relasi: Wartawan has many News (One to Many)
    public function news()
    {
        return $this->hasMany(News::class, 'wartawan_id');
    }
}
```

**Cara Menggunakan:**

```php
// Mengambil semua berita yang ditulis wartawan tertentu
$wartawan = Wartawan::find(1);
$semua_berita = $wartawan->news;
```

### 3. Model Komentar (`app/Models/Komentar.php`)

```php
class Komentar extends Model
{
    protected $table = 'komentar';
    protected $fillable = ['nama', 'isi', 'news_id'];

    // Relasi: Komentar belongs to News (Many to One)
    public function news()
    {
        return $this->belongsTo(News::class, 'news_id');
    }
}
```

## 🎮 Controller

### NewsController (`app/Http/Controllers/NewsController.php`)

Controller ini mengatur semua logic untuk menampilkan berita.

#### Method: `index()`

```php
public function index()
{
    // Mengambil semua berita dengan relasi wartawan dan komentar
    // latest() mengurutkan dari yang terbaru
    $semua_berita = News::with('wartawan', 'komentar')
        ->latest()
        ->get();

    // Mengirim data ke view news.index
    return view('news.index', [
        'news_list' => $semua_berita
    ]);
}
```

**Penjelasan:**
- `News::with('wartawan', 'komentar')` → Eager Loading untuk menghindari N+1 query problem
- `latest()` → Mengurutkan berdasarkan `created_at` DESC
- `get()` → Mengeksekusi query dan mengambil semua hasil
- `return view()` → Me-render view dan mengirim data

#### Method: `show()`

```php
public function show(News $news)
{
    // Load relasi wartawan dan komentar
    $news->load('wartawan', 'komentar');

    // Mengirim data ke view news.show
    return view('news.show', [
        'news' => $news
    ]);
}
```

**Penjelasan:**
- `News $news` → Route Model Binding otomatis mengisi parameter ini
- `$news->load()` → Lazy eager loading untuk load relasi
- Data dikirim ke view untuk ditampilkan

## 🎛 Filament Admin Panel

Aplikasi ini dilengkapi dengan **Filament Admin Panel** untuk memudahkan manajemen data berita dan wartawan tanpa perlu coding tambahan. Filament menyediakan interface CRUD (Create, Read, Update, Delete) yang modern dan user-friendly.

### Mengakses Admin Panel

```
URL: http://localhost:8000/admin
```

Setelah setup, login menggunakan kredensial admin yang telah dibuat.

### Fitur Admin Panel

#### 1. **Dashboard**
- Overview statistik aplikasi
- Quick access ke semua resource

#### 2. **News Management** 📰
- **Create:** Form untuk membuat berita baru dengan Rich Text Editor
- **Read:** Tabel data berita dengan search & filter
- **Update:** Edit berita yang sudah ada
- **Delete:** Hapus berita (single atau bulk)

**Dokumentasi Lengkap:** [📄 NewsResource Documentation](docs/NewsResource.md)

#### 3. **Wartawan Management** 👤
- **Create:** Form untuk menambah wartawan baru
- **Read:** Tabel data wartawan dengan search & sort
- **Update:** Edit data wartawan
- **Delete:** Hapus wartawan (single atau bulk)

**Dokumentasi Lengkap:** [📄 WartawanResource Documentation](docs/WartawanResource.md)

### Resource yang Tersedia

| Resource | Model | Fitur |
|----------|-------|-------|
| **NewsResource** | `News` | Manajemen berita dengan Rich Editor, relasi wartawan |
| **WartawanResource** | `Wartawan` | Manajemen data wartawan/jurnalis |

### Quick Start Guide

#### Membuat Berita Baru

1. Login ke admin panel `/admin`
2. Klik menu **📰 News** di sidebar
3. Klik tombol **"+ Create News"**
4. Isi form:
   - Pilih Wartawan
   - Tulis Judul
   - Tulis Ringkasan
   - Tulis Isi (dengan Rich Editor)
5. Klik **"Create"**

#### Mengelola Wartawan

1. Klik menu **👤 Wartawans** di sidebar
2. Klik **"+ Create Wartawan"**
3. Isi Nama dan Email
4. Klik **"Create"**

### Setup Admin User (First Time)

Jika belum ada admin user, buat dengan Tinker:

```bash
php artisan tinker
```

```php
$user = new App\Models\User();
$user->name = 'Admin';
$user->email = 'admin@news-app.com';
$user->password = bcrypt('password');
$user->save();
```

Atau buat dengan seeder di `database/seeders/DatabaseSeeder.php`.

### Customization

Filament Resource bisa di-customize sesuai kebutuhan:
- Menambah field baru di form
- Menambah kolom di tabel
- Menambah filter & search
- Menambah actions custom
- Mengubah icon dan label

Lihat dokumentasi lengkap untuk tutorial customization.

### Keuntungan Menggunakan Filament

✅ **Cepat:** CRUD otomatis tanpa banyak coding  
✅ **Modern UI:** Interface yang clean dan responsive  
✅ **Validation:** Built-in validation untuk semua field  
✅ **Searchable:** Search otomatis di tabel data  
✅ **Sortable:** Sort kolom dengan klik header  
✅ **Bulk Actions:** Delete multiple records sekaligus  
✅ **Rich Editor:** WYSIWYG editor untuk konten berita  
✅ **Relasi:** Handle relasi antar model dengan mudah  

## 🚀 Panduan Pengembangan

### Menambah Fitur Baru

#### 1. Membuat Migration Baru

```bash
php artisan make:migration create_categories_table
```

#### 2. Membuat Model

```bash
php artisan make:model Category
```

#### 3. Membuat Controller

```bash
php artisan make:controller CategoryController
```

#### 4. Menambah Route Baru

Edit `routes/web.php`:

```php
Route::get('/categories', [CategoryController::class, 'index']);
```

### Testing dengan Tinker

Laravel Tinker memungkinkan Anda berinteraksi dengan aplikasi via command line:

```bash
php artisan tinker
```

Contoh penggunaan:

```php
// Mengambil semua berita
>>> $berita = App\Models\News::all();

// Mengambil berita dengan id 1
>>> $berita = App\Models\News::find(1);

// Melihat wartawan dari berita
>>> $berita->wartawan;

// Membuat berita baru
>>> App\Models\News::create([
    'judul' => 'Test Berita',
    'ringkasan' => 'Ini ringkasan',
    'isi' => 'Ini isi berita lengkap',
    'wartawan_id' => 1
]);
```

### Generate Data Dummy

Gunakan Factory dan Seeder untuk membuat data testing:

```bash
php artisan db:seed
```

### Code Style

Gunakan Laravel Pint untuk merapikan code:

```bash
./vendor/bin/pint
```

## 📚 Referensi Laravel

### Dokumentasi Resmi Laravel
- [Laravel 11.x Documentation](https://laravel.com/docs/11.x) - Dokumentasi lengkap Laravel
- [Routing](https://laravel.com/docs/11.x/routing) - Panduan routing
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent) - Database ORM
- [Blade Templates](https://laravel.com/docs/11.x/blade) - Template engine
- [Migrations](https://laravel.com/docs/11.x/migrations) - Database migrations

### Dokumentasi Filament Admin Panel
- [Filament Documentation](https://filamentphp.com/docs) - Dokumentasi lengkap Filament
- [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started) - Membuat CRUD Resources
- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation) - Form builder
- [Filament Tables](https://filamentphp.com/docs/3.x/tables/installation) - Table builder
- [Heroicons](https://heroicons.com) - Icon library untuk Filament

### Dokumentasi Resource Aplikasi Ini
- [📄 NewsResource Documentation](docs/NewsResource.md) - Panduan lengkap NewsResource
- [📄 WartawanResource Documentation](docs/WartawanResource.md) - Panduan lengkap WartawanResource

### Tutorial & Learning Resources
- [Laravel Bootcamp](https://bootcamp.laravel.com) - Tutorial interaktif
- [Laracasts](https://laracasts.com) - Video tutorial Laravel (gratis & berbayar)
- [Laravel News](https://laravel-news.com) - Berita dan tips Laravel
- [Filament Tricks](https://filamentphp.com/community) - Community tips Filament

### Konsep Penting untuk Dipelajari

1. **MVC Pattern** - Memahami pemisahan Model, View, Controller
2. **Eloquent ORM** - Cara berinteraksi dengan database tanpa SQL mentah
3. **Blade Templating** - Membuat view yang dinamis
4. **Route Model Binding** - Otomatis inject model dari route parameter
5. **Relationships** - One to Many, Many to Many, dll
6. **Migrations** - Version control untuk database
7. **Seeders & Factories** - Generate data dummy untuk testing
8. **Filament Resources** - Admin panel CRUD dengan form & table builder

## 📝 Catatan Tambahan

### Struktur Folder Penting

```
news-app/
├── app/
│   ├── Http/Controllers/    # Controller files
│   ├── Models/              # Model/Eloquent files
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # File migration database
│   ├── seeders/             # File seeder untuk data dummy
│   └── factories/           # Factory untuk generate data
├── resources/
│   ├── views/               # Blade template files
│   ├── css/                 # CSS files
│   └── js/                  # JavaScript files
├── routes/
│   └── web.php              # Web routes definition
└── public/
    └── index.php            # Entry point aplikasi
```

### Tips Debugging

1. **Lihat Log Error**: `storage/logs/laravel.log`
2. **Gunakan `dd()`**: Dump & Die untuk debugging
   ```php
   dd($variabel); // Akan menampilkan isi variabel dan stop execution
   ```
3. **Gunakan Laravel Debugbar**: Install untuk melihat queries, route info, dll
   ```bash
   composer require barryvdh/laravel-debugbar --dev
   ```

### Command Artisan Berguna

```bash
# Lihat semua route
php artisan route:list

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Membuat controller dengan resource methods
php artisan make:controller NewsController --resource

# Rollback migration
php artisan migrate:rollback

# Fresh migration (drop all & re-migrate)
php artisan migrate:fresh

# Fresh migration + seeder
php artisan migrate:fresh --seed
```

## 📄 License

Aplikasi ini dibuat untuk keperluan pembelajaran dan menggunakan framework Laravel yang berlisensi [MIT license](https://opensource.org/licenses/MIT).
