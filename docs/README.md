# 📚 Dokumentasi Aplikasi Berita

Selamat datang di pusat dokumentasi Aplikasi Berita! Di sini Anda akan menemukan panduan lengkap untuk memahami dan menggunakan aplikasi ini.

## 📋 Daftar Dokumentasi

### 1. [📄 README.md (Dokumentasi Utama)](../README.md)

Dokumentasi utama yang berisi:
- Overview aplikasi
- Teknologi yang digunakan
- Instalasi dan setup
- Arsitektur aplikasi (MVC)
- Struktur database & relasi
- Cara kerja routing
- Model dan Eloquent ORM
- Controller logic
- Panduan development

**Mulai dari sini jika Anda baru pertama kali melihat aplikasi ini!**

---

### 2. [📰 NewsResource Documentation](NewsResource.md)

Dokumentasi lengkap untuk **NewsResource** (Filament Admin Panel):

#### Yang Akan Anda Pelajari:
- ✅ Cara kerja NewsResource untuk manajemen berita
- ✅ Form schema & field-field input berita
- ✅ Rich Text Editor untuk konten
- ✅ Table configuration dengan search & sort
- ✅ Actions (Edit, Delete, Bulk Delete)
- ✅ Pages & routing di admin panel
- ✅ Cara menggunakan CRUD berita
- ✅ Customization & tips

#### Cocok Untuk:
- Mahasiswa yang ingin memahami Filament Resources
- Developer yang ingin customize form berita
- Admin yang akan menggunakan panel untuk input berita

#### Topics:
- Form Components (Select, TextInput, RichEditor)
- Table Columns & Filters
- Route Model Binding di Filament
- Relasi dengan Wartawan
- Validasi otomatis

**Baca dokumentasi ini jika Anda ingin mengelola atau customize fitur berita!**

---

### 3. [👤 WartawanResource Documentation](WartawanResource.md)

Dokumentasi lengkap untuk **WartawanResource** (Filament Admin Panel):

#### Yang Akan Anda Pelajari:
- ✅ Cara kerja WartawanResource untuk manajemen wartawan
- ✅ Form input data wartawan (nama & email)
- ✅ Email validation otomatis
- ✅ Table dengan search & sort
- ✅ Actions & bulk delete
- ✅ Relasi One-to-Many dengan News
- ✅ Best practices untuk manajemen user data

#### Cocok Untuk:
- Mahasiswa yang ingin memahami manajemen data user
- Developer yang ingin menambah field wartawan
- Admin yang akan mengelola data jurnalis

#### Topics:
- TextInput validation (required, maxLength, email)
- Helper text & placeholder
- Searchable & sortable columns
- Foreign key relationships
- Dependency management (wartawan → berita)

**Baca dokumentasi ini jika Anda ingin mengelola data wartawan/jurnalis!**

---

## 🗺 Navigasi Berdasarkan Kebutuhan

### Saya Mahasiswa Baru...

#### Ingin Memahami Laravel MVC?
1. Baca [README.md](../README.md) bagian **Arsitektur Aplikasi**
2. Pelajari bagian **Model dan Relasi**
3. Pahami bagian **Cara Kerja Routing**
4. Lihat bagian **Controller**

#### Ingin Belajar Eloquent ORM?
1. Baca [README.md](../README.md) bagian **Model dan Relasi**
2. Baca [NewsResource.md](NewsResource.md) bagian **Relasi dengan Component Lain**
3. Baca [WartawanResource.md](WartawanResource.md) bagian **Relasi dengan News**

#### Ingin Belajar Database Design?
1. Baca [README.md](../README.md) bagian **Struktur Database**
2. Pahami ERD diagram
3. Lihat file migration di `database/migrations/`

### Saya Developer...

#### Ingin Customize Admin Panel?
1. Baca [NewsResource.md](NewsResource.md) bagian **Customization**
2. Baca [WartawanResource.md](WartawanResource.md) bagian **Customization**
3. Lihat Filament Documentation untuk advanced features

#### Ingin Menambah Fitur Baru?
1. Baca [README.md](../README.md) bagian **Panduan Pengembangan**
2. Lihat contoh NewsResource & WartawanResource
3. Ikuti pattern yang sama untuk resource baru

#### Ingin Optimize Query?
1. Baca bagian **Eager Loading** di NewsResource
2. Pahami N+1 Problem
3. Gunakan `with()` dan `load()`

### Saya Admin/User...

#### Ingin Menggunakan Admin Panel?
1. Baca [README.md](../README.md) bagian **Filament Admin Panel**
2. Baca [NewsResource.md](NewsResource.md) bagian **Cara Menggunakan**
3. Baca [WartawanResource.md](WartawanResource.md) bagian **Cara Menggunakan**

#### Ingin Membuat Berita Baru?
1. Baca [NewsResource.md](NewsResource.md) bagian **Cara Menggunakan → Membuat Berita Baru**
2. Ikuti step-by-step guide

#### Ingin Mengelola Wartawan?
1. Baca [WartawanResource.md](WartawanResource.md) bagian **Cara Menggunakan**
2. Perhatikan relasi dengan berita sebelum menghapus

---

## 📊 Diagram Arsitektur

```
┌─────────────────────────────────────────────────────────┐
│                  APLIKASI BERITA                        │
├─────────────────────────────────────────────────────────┤
│                                                         │
│  ┌──────────────┐              ┌──────────────┐        │
│  │   FRONTEND   │              │  ADMIN PANEL │        │
│  │   (Public)   │              │  (Filament)  │        │
│  └──────┬───────┘              └──────┬───────┘        │
│         │                             │                │
│         │  Routes (web.php)           │                │
│         ▼                             ▼                │
│  ┌──────────────┐              ┌──────────────┐        │
│  │NewsController│              │NewsResource  │        │
│  │              │              │WartawanRes.. │        │
│  └──────┬───────┘              └──────┬───────┘        │
│         │                             │                │
│         │        ┌────────────┐       │                │
│         └───────▶│   MODELS   │◀──────┘                │
│                  │            │                        │
│                  │  - News    │                        │
│                  │  - Wartawan│                        │
│                  │  - Komentar│                        │
│                  └─────┬──────┘                        │
│                        │                               │
│                        ▼                               │
│                  ┌────────────┐                        │
│                  │  DATABASE  │                        │
│                  │   MySQL    │                        │
│                  └────────────┘                        │
│                                                         │
└─────────────────────────────────────────────────────────┘
```

---

## 🔗 Link Dokumentasi

### Dokumentasi
- [📄 README Utama](../README.md)
- [📰 NewsResource](NewsResource.md)
- [👤 WartawanResource](WartawanResource.md)

### Source Code
- [Models](../app/Models/)
- [Controllers](../app/Http/Controllers/)
- [Filament Resources](../app/Filament/Resources/)
- [Migrations](../database/migrations/)
- [Routes](../routes/web.php)

### External Links
- [Laravel Documentation](https://laravel.com/docs/11.x)
- [Filament Documentation](https://filamentphp.com/docs)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)
- [Blade Templates](https://laravel.com/docs/11.x/blade)

---

## 💡 Tips Belajar

### Untuk Mahasiswa

1. **Mulai dari Dasar**
   - Pahami MVC pattern terlebih dahulu
   - Baca dokumentasi dari atas ke bawah
   - Jangan skip bagian instalasi

2. **Praktek Sambil Belajar**
   - Install aplikasi di local
   - Coba setiap fitur yang dijelaskan
   - Eksperimen dengan ubah code

3. **Gunakan Tinker**
   - Test query Eloquent di Tinker
   - Lihat hasil real-time
   - Pahami relasi antar model

4. **Baca Code**
   - Buka file yang disebutkan di dokumentasi
   - Bandingkan dengan penjelasan
   - Trace alur dari route → controller → model → view

### Untuk Developer

1. **Ikuti Pattern**
   - Lihat pattern NewsResource & WartawanResource
   - Gunakan pattern yang sama untuk resource baru
   - Maintain consistency

2. **Optimize Query**
   - Selalu gunakan eager loading
   - Avoid N+1 problem
   - Use `with()` untuk relasi

3. **Test Everything**
   - Gunakan Laravel Tinker untuk quick test
   - Write unit tests
   - Test edge cases

4. **Documentation First**
   - Update dokumentasi saat menambah fitur
   - Tulis comment yang jelas
   - Maintain README.md

---

## 🆘 Troubleshooting

### Error Umum

#### "Table not found"
**Solusi:** Jalankan migrations
```bash
php artisan migrate
```

#### "Foreign key constraint fails" saat hapus wartawan
**Solusi:** Hapus semua berita wartawan tersebut terlebih dahulu, atau ubah migration:
```php
$table->foreignId('wartawan_id')
    ->constrained('wartawan')
    ->onDelete('cascade');  // Auto delete berita
```

#### "Class not found" di Filament
**Solusi:** Clear cache
```bash
php artisan optimize:clear
composer dump-autoload
```

#### Admin panel tidak muncul
**Solusi:** 
1. Pastikan Filament sudah terinstall
2. Check route: `/admin`
3. Buat user admin jika belum ada

---

## 📞 Support

Jika ada pertanyaan atau kendala:

1. **Baca Dokumentasi Terlebih Dahulu**
   - Kemungkinan sudah dijelaskan di dokumentasi
   
2. **Check Laravel Documentation**
   - https://laravel.com/docs
   
3. **Check Filament Documentation**
   - https://filamentphp.com/docs
   
4. **Search di Stack Overflow**
   - Tag: `laravel`, `filament`, `eloquent`

