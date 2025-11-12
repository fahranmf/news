# 📰 Aplikasi Berita (News App)

Aplikasi web sederhana untuk mengelola dan menampilkan berita yang dibuat menggunakan Laravel 12. Aplikasi ini dikembangkan untuk tujuan pembelajaran mahasiswa dalam memahami konsep MVC (Model-View-Controller), ORM (Object-Relational Mapping), dan routing di Laravel.


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



## 🚀 Panduan Pengembangan

### Menambah Page Administrasi Komentar

#### 1. Membuat Seeder untuk membuat akun user

```bash
php artisan make:seeder AdminSeeder
```

#### 2. Edit AdminSeeder

```bash
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Filament',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // ubah sesuai kebutuhan
            'email_verified_at' => now(),
        ]);
    }
}
```

#### 3. Edit DatabaseSeeder

```bash
<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use App\Models\Komentar;
use App\Models\Wartawan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // TODO 
        // 1. BUAT WARTAWAN
        $wartawans = Wartawan::factory(2)->create();
        // 2. BUAT 4 BERITA (MASING-MASING BERITA DIMILIKI OLEH WARTAWAN)
        $berita1 = News::factory()->create([
            'wartawan_id' => $wartawans->first()->id
        ]);

        $berita2 = News::factory()->create([
            'wartawan_id' => $wartawans->first()->id
        ]);

        $berita3 = News::factory()->create([
            'wartawan_id' => $wartawans->last()->id
        ]);

        $berita4 = News::factory()->create([
            'wartawan_id' => $wartawans->last()->id
        ]);
        // 3. BUAT 20 KOMENTAR TOTAL DARI MASING-MASIGN BERITA 5 KOMENTAR
        $all_berita = collect([$berita1, $berita2, $berita3, $berita4]);
        foreach($all_berita as $berita) {
            Komentar::factory(5)->create([
                'news_id' => $berita->id
            ]);
        }

        $this->call(AdminSeeder::class);
    }
}
```

#### 4. Jalankan migrasi


```bash
php artisan migrate:fresh --seed
```

### 5. Jalankan artisan make


```bash
php artisan make:filament-resource Komentar
```

### 6. Edit Filament/Resource/KomentarResource

```bash
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KomentarResource\Pages;
use App\Models\Komentar;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KomentarResource extends Resource
{
    protected static ?string $model = Komentar::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Komentar';
    //protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('news.judul')
                    ->label('Judul Berita')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Komentator')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('isi')
                    ->label('Isi Komentar')
                    ->limit(50)
                    ->wrap()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKomentars::route('/'),
        ];
    }
}
```

### 7. Edit Filament/Resources/KomentarResources/Pages

```php
<?php

namespace App\Filament\Resources\KomentarResource\Pages;

use App\Filament\Resources\KomentarResource;
use Filament\Resources\Pages\ListRecords;

class ListKomentars extends ListRecords
{
    protected static string $resource = KomentarResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
```

## Tampilan

<img width="1600" height="864" alt="image" src="https://github.com/user-attachments/assets/bb834243-007a-4fe1-a7d1-528a3079a9dd" />
