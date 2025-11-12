# 👤 Dokumentasi WartawanResource

## 📋 Daftar Isi

- [Tentang WartawanResource](#tentang-wartawanresource)
- [Lokasi File](#lokasi-file)
- [Struktur Resource](#struktur-resource)
- [Form Schema](#form-schema)
- [Table Configuration](#table-configuration)
- [Actions & Bulk Actions](#actions--bulk-actions)
- [Pages & Routes](#pages--routes)
- [Cara Menggunakan](#cara-menggunakan)
- [Customization](#customization)
- [Relasi dengan News](#relasi-dengan-news)

## 🎯 Tentang WartawanResource

`WartawanResource` adalah Filament Resource yang digunakan untuk mengelola data wartawan/jurnalis melalui admin panel. Resource ini menyediakan interface CRUD (Create, Read, Update, Delete) yang sederhana dan efisien untuk manajemen data wartawan yang nantinya akan dihubungkan dengan berita yang mereka tulis.

### Fitur Utama:
- ✅ Form input data wartawan (nama & email)
- ✅ Validasi email otomatis
- ✅ Tabel data dengan sorting dan searching
- ✅ Actions untuk Edit dan Delete
- ✅ Bulk delete untuk menghapus multiple records
- ✅ Helper text untuk panduan pengisian

## 📂 Lokasi File

```
app/
└── Filament/
    └── Resources/
        ├── WartawanResource.php              # Main resource file
        └── WartawanResource/
            └── Pages/
                ├── ListWartawans.php         # Halaman list data
                ├── CreateWartawan.php        # Halaman create
                └── EditWartawan.php          # Halaman edit
```

## 🏗 Struktur Resource

```php
namespace App\Filament\Resources;

class WartawanResource extends Resource
{
    // Model yang digunakan
    protected static ?string $model = Wartawan::class;
    
    // Icon di navigation menu (menggunakan Heroicons)
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    // Method-method utama:
    // - form()        → Mendefinisikan form input
    // - table()       → Mendefinisikan tampilan tabel
    // - getRelations()→ Mendefinisikan relation managers
    // - getPages()    → Mendefinisikan routes & pages
}
```

### Penjelasan Properties:

| Property | Nilai | Keterangan |
|----------|-------|------------|
| `$model` | `Wartawan::class` | Model Eloquent yang dikelola |
| `$navigationIcon` | `'heroicon-o-rectangle-stack'` | Icon untuk menu navigasi |

💡 **Tips:** Anda bisa mengubah icon menjadi lebih relevan seperti `heroicon-o-user-group` atau `heroicon-o-identification`

## 📝 Form Schema

Form schema untuk WartawanResource sangat sederhana, hanya terdiri dari 2 field utama: nama dan email.

```php
public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('nama'),
        TextInput::make('email'),
    ]);
}
```

### Field-by-Field Breakdown:

#### 1. Field Nama

```php
TextInput::make('nama')
    ->required()
    ->maxLength(255)
    ->label('Nama')
    ->placeholder('Masukkan nama wartawan')
    ->helperText('Maksimal 255 karakter')
```

**Penjelasan Setiap Method:**

| Method | Parameter | Fungsi |
|--------|-----------|--------|
| `make('nama')` | `'nama'` | Mendefinisikan field untuk kolom `nama` di database |
| `->required()` | - | Field wajib diisi, tidak boleh kosong |
| `->maxLength(255)` | `255` | Membatasi input maksimal 255 karakter |
| `->label('Nama')` | `'Nama'` | Label yang ditampilkan di form |
| `->placeholder()` | `'Masukkan nama wartawan'` | Placeholder text di input box |
| `->helperText()` | `'Maksimal 255 karakter'` | Teks bantuan di bawah input |

**Validasi Otomatis:**
- ✅ Tidak boleh kosong (required)
- ✅ Maksimal 255 karakter
- ✅ Real-time validation saat user mengetik

**Output Visual:**
```
Nama *
┌────────────────────────────────────┐
│ Masukkan nama wartawan             │
└────────────────────────────────────┘
Maksimal 255 karakter
```

**Contoh Input Valid:**
- ✅ "Ahmad Fauzi"
- ✅ "Dr. Siti Nurhaliza, M.Kom"
- ✅ "Budi Santoso Junior"

**Contoh Input Invalid:**
- ❌ "" (kosong)
- ❌ String lebih dari 255 karakter

#### 2. Field Email

```php
TextInput::make('email')
    ->required()
    ->email()
    ->label('Email')
    ->placeholder('Masukkan email wartawan')
    ->helperText('Masukkan alamat email yang valid')
```

**Penjelasan Setiap Method:**

| Method | Parameter | Fungsi |
|--------|-----------|--------|
| `make('email')` | `'email'` | Mendefinisikan field untuk kolom `email` di database |
| `->required()` | - | Field wajib diisi |
| `->email()` | - | **Validasi email format** (harus valid email) |
| `->label('Email')` | `'Email'` | Label yang ditampilkan |
| `->placeholder()` | `'Masukkan email wartawan'` | Placeholder text |
| `->helperText()` | `'Masukkan alamat email yang valid'` | Teks bantuan |

**Validasi Otomatis:**
- ✅ Tidak boleh kosong (required)
- ✅ Harus format email valid (ada @ dan domain)
- ✅ Browser modern juga melakukan client-side validation

**Output Visual:**
```
Email *
┌────────────────────────────────────┐
│ Masukkan email wartawan            │
└────────────────────────────────────┘
Masukkan alamat email yang valid
```

**Contoh Input Valid:**
- ✅ "ahmad.fauzi@news.com"
- ✅ "siti@kompas.co.id"
- ✅ "budi.santoso123@gmail.com"

**Contoh Input Invalid:**
- ❌ "" (kosong)
- ❌ "ahmad" (tidak ada @)
- ❌ "ahmad@" (tidak ada domain)
- ❌ "ahmad@news" (domain tidak valid)
- ❌ "@news.com" (tidak ada username)

### Form Layout Lengkap

```
┌───────────────────────────────────────────────┐
│                                               │
│  Nama *                                       │
│  ┌─────────────────────────────────────────┐ │
│  │ Masukkan nama wartawan                  │ │
│  └─────────────────────────────────────────┘ │
│  Maksimal 255 karakter                        │
│                                               │
│  Email *                                      │
│  ┌─────────────────────────────────────────┐ │
│  │ Masukkan email wartawan                 │ │
│  └─────────────────────────────────────────┘ │
│  Masukkan alamat email yang valid             │
│                                               │
│                        [Batal]  [Simpan]      │
└───────────────────────────────────────────────┘
```

## 📊 Table Configuration

Table configuration mendefinisikan bagaimana data wartawan ditampilkan dalam bentuk tabel.

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([...])      // Definisi kolom
        ->filters([...])      // Filter data (kosong untuk saat ini)
        ->actions([...])      // Action per row
        ->bulkActions([...])  // Action untuk multiple rows
}
```

### Columns (Kolom Tabel)

```php
->columns([
    TextColumn::make('nama'),
    TextColumn::make('email'),
])
```

#### 1. Kolom Nama

```php
TextColumn::make('nama')
    ->label('Nama')
    ->sortable()
    ->searchable()
```

**Penjelasan:**

| Method | Fungsi |
|--------|--------|
| `make('nama')` | Menampilkan data dari kolom `nama` |
| `->label('Nama')` | Header kolom: "Nama" |
| `->sortable()` | Kolom bisa di-sort A-Z atau Z-A |
| `->searchable()` | Kolom bisa di-search |

**Fitur Sortable:**
```
Nama ▲              # Klik 1x: A-Z (ascending)
Nama ▼              # Klik 2x: Z-A (descending)
Nama                # Klik 3x: Reset
```

**Fitur Searchable:**
- User bisa ketik nama di search bar
- Filter otomatis berdasarkan nama yang diketik
- Case-insensitive (tidak peduli huruf besar/kecil)

**Contoh Data:**
```
Nama
─────────────────
Ahmad Fauzi
Siti Nurhaliza
Budi Santoso
Dewi Lestari
```

#### 2. Kolom Email

```php
TextColumn::make('email')
    ->label('Email')
    ->sortable()
    ->searchable()
```

**Penjelasan:**
- Sama seperti kolom nama
- Menampilkan alamat email wartawan
- Bisa di-sort dan di-search

**Contoh Data:**
```
Email
─────────────────────────
ahmad.fauzi@news.com
siti@kompas.co.id
budi@detik.com
dewi@tempo.com
```

### Table Layout Lengkap

```
┌──────────────────────┬─────────────────────────┬──────────────────┐
│ Nama ▲▼             │ Email ▲▼               │ Actions          │
├──────────────────────┼─────────────────────────┼──────────────────┤
│ Ahmad Fauzi          │ ahmad.fauzi@news.com    │ ✏️  🗑️           │
│ Siti Nurhaliza       │ siti@kompas.co.id       │ ✏️  🗑️           │
│ Budi Santoso         │ budi@detik.com          │ ✏️  🗑️           │
│ Dewi Lestari         │ dewi@tempo.com          │ ✏️  🗑️           │
└──────────────────────┴─────────────────────────┴──────────────────┘

[◀ Previous] Page 1 of 3 [Next ▶]
```

### Fitur Search & Filter

**Search Bar:**
```
┌────────────────────────────────────────┐
│ 🔍 Search: [ahmad_______________]     │
└────────────────────────────────────────┘
```

Ketik "ahmad" → Hanya tampilkan wartawan dengan nama atau email mengandung "ahmad"

### Pagination

Secara default, Filament menampilkan 10 records per halaman:

```
Showing 1-10 of 45 results

[◀ Previous] 1 2 3 4 5 [Next ▶]
```

User bisa ubah jumlah per halaman: 10 | 25 | 50 | 100

## 🔧 Actions & Bulk Actions

### Row Actions (Per Wartawan)

```php
->actions([
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
])
```

#### EditAction (✏️)

**Fungsi:** Membuka form edit untuk wartawan tersebut

**Behavior:**
1. Klik icon ✏️
2. Redirect ke halaman edit
3. Form terisi dengan data wartawan
4. User bisa ubah nama atau email
5. Klik "Save Changes" untuk update

**URL Pattern:**
```
/admin/wartawans/5/edit
```

#### DeleteAction (🗑️)

**Fungsi:** Menghapus data wartawan

**Behavior:**
1. Klik icon 🗑️
2. Muncul modal konfirmasi:

```
╔═══════════════════════════════════════════╗
║  Hapus Wartawan?                          ║
╟───────────────────────────────────────────╢
║  Apakah Anda yakin ingin menghapus        ║
║  wartawan ini?                            ║
║                                           ║
║  ⚠️  Warning: Jika wartawan ini memiliki  ║
║  berita, hapus berita tersebut terlebih   ║
║  dahulu atau akan error!                  ║
║                                           ║
║  [Batal]  [Hapus]                         ║
╚═══════════════════════════════════════════╝
```

3. Jika dikonfirmasi, wartawan dihapus
4. Notifikasi sukses muncul
5. Table refresh otomatis

**⚠️ Penting:** 
- Jika wartawan memiliki berita (foreign key constraint), penghapusan akan error
- Harus hapus semua berita wartawan tersebut dulu
- Atau ubah foreign key menjadi `onDelete('cascade')` di migration

### Bulk Actions (Multiple Wartawan)

```php
->bulkActions([
    Tables\Actions\BulkActionGroup::make([
        Tables\Actions\DeleteBulkAction::make(),
    ]),
])
```

**Fungsi:** Menghapus beberapa wartawan sekaligus

**Cara Menggunakan:**

**Step 1:** Select wartawan dengan checkbox
```
☑️ [✓] Ahmad Fauzi    │ ahmad.fauzi@news.com
☑️ [✓] Siti Nurhaliza │ siti@kompas.co.id
☐ [ ] Budi Santoso    │ budi@detik.com
☑️ [✓] Dewi Lestari   │ dewi@tempo.com

Selected: 3 records
```

**Step 2:** Klik "Delete Selected"
```
[🗑️ Delete Selected (3)]
```

**Step 3:** Konfirmasi
```
╔═══════════════════════════════════════════╗
║  Hapus 3 Wartawan?                        ║
╟───────────────────────────────────────────╢
║  Apakah Anda yakin ingin menghapus        ║
║  3 wartawan yang dipilih?                 ║
║                                           ║
║  [Batal]  [Hapus Semua]                   ║
╚═══════════════════════════════════════════╝
```

**Step 4:** Wartawan terhapus dan notifikasi muncul
```
✅ 3 wartawan berhasil dihapus
```

## 🗺 Pages & Routes

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListWartawans::route('/'),
        'create' => Pages\CreateWartawan::route('/create'),
        'edit' => Pages\EditWartawan::route('/{record}/edit'),
    ];
}
```

### Route Structure

| Page Name | Route Path | Full URL | Fungsi |
|-----------|------------|----------|--------|
| `index` | `/` | `/admin/wartawans` | List semua wartawan |
| `create` | `/create` | `/admin/wartawans/create` | Form create wartawan baru |
| `edit` | `/{record}/edit` | `/admin/wartawans/5/edit` | Form edit wartawan ID 5 |

### Page Classes

#### 1. ListWartawans.php

```php
// Location: app/Filament/Resources/WartawanResource/Pages/ListWartawans.php

class ListWartawans extends ListRecords
{
    protected static string $resource = WartawanResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
```

**Fitur Halaman:**
- 📋 Tabel data wartawan
- 🔍 Search bar (search by nama & email)
- 📄 Pagination
- ➕ Tombol "Create Wartawan" di header
- ✏️🗑️ Actions (Edit & Delete) per row
- ☑️ Checkbox untuk bulk actions

**Layout:**
```
┌──────────────────────────────────────────────────┐
│  Wartawans                   [+ Create Wartawan] │
├──────────────────────────────────────────────────┤
│  🔍 Search: [________________]                   │
├──────────────────────────────────────────────────┤
│  ☐ Nama ▲▼        Email ▲▼            Actions   │
│  ────────────────────────────────────────────    │
│  ☐ Ahmad Fauzi    ahmad.fauzi@news.com  ✏️ 🗑️   │
│  ☐ Siti Nurhaliza siti@kompas.co.id     ✏️ 🗑️   │
│  ☐ Budi Santoso   budi@detik.com        ✏️ 🗑️   │
├──────────────────────────────────────────────────┤
│  Showing 1-10 of 25  [◀] 1 2 3 [▶]              │
└──────────────────────────────────────────────────┘
```

#### 2. CreateWartawan.php

```php
// Location: app/Filament/Resources/WartawanResource/Pages/CreateWartawan.php

class CreateWartawan extends CreateRecord
{
    protected static string $resource = WartawanResource::class;
}
```

**Fitur Halaman:**
- 📝 Form kosong untuk input wartawan baru
- ✅ Validasi real-time
- 💾 Tombol "Create" untuk save
- 🔄 Tombol "Create & Create Another" untuk save dan buat lagi
- ❌ Tombol "Cancel" untuk kembali

**Layout:**
```
┌──────────────────────────────────────────────────┐
│  Create Wartawan                    [← Back]     │
├──────────────────────────────────────────────────┤
│                                                  │
│  Nama *                                          │
│  ┌────────────────────────────────────────────┐ │
│  │ Masukkan nama wartawan                     │ │
│  └────────────────────────────────────────────┘ │
│  Maksimal 255 karakter                           │
│                                                  │
│  Email *                                         │
│  ┌────────────────────────────────────────────┐ │
│  │ Masukkan email wartawan                    │ │
│  └────────────────────────────────────────────┘ │
│  Masukkan alamat email yang valid                │
│                                                  │
├──────────────────────────────────────────────────┤
│     [Cancel] [Create & Create Another] [Create]  │
└──────────────────────────────────────────────────┘
```

**Notifikasi Sukses:**
```
✅ Wartawan berhasil dibuat!
```

**Redirect:** Kembali ke halaman list wartawan

#### 3. EditWartawan.php

```php
// Location: app/Filament/Resources/WartawanResource/Pages/EditWartawan.php

class EditWartawan extends EditRecord
{
    protected static string $resource = WartawanResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
```

**Fitur Halaman:**
- 📝 Form terisi dengan data wartawan yang akan diedit
- ✅ Validasi real-time
- 💾 Tombol "Save Changes" untuk update
- 🗑️ Tombol "Delete" di header
- ❌ Tombol "Cancel" untuk kembali

**Layout:**
```
┌──────────────────────────────────────────────────┐
│  Edit Wartawan: Ahmad Fauzi  [🗑️ Delete] [← Back]│
├──────────────────────────────────────────────────┤
│                                                  │
│  Nama *                                          │
│  ┌────────────────────────────────────────────┐ │
│  │ Ahmad Fauzi                                │ │
│  └────────────────────────────────────────────┘ │
│  Maksimal 255 karakter                           │
│                                                  │
│  Email *                                         │
│  ┌────────────────────────────────────────────┐ │
│  │ ahmad.fauzi@news.com                       │ │
│  └────────────────────────────────────────────┘ │
│  Masukkan alamat email yang valid                │
│                                                  │
├──────────────────────────────────────────────────┤
│                    [Cancel] [Save Changes]       │
└──────────────────────────────────────────────────┘
```

**Notifikasi Sukses:**
```
✅ Wartawan berhasil diupdate!
```

### Navigation Flow Diagram

```
┌─────────────────────┐
│   Sidebar Menu      │
│   👤 Wartawans      │
└──────────┬──────────┘
           │
           ▼
┌───────────────────────────────────┐
│   List Wartawans Page             │
│   ┌─────────────────────────┐     │
│   │  [+ Create Wartawan]    │     │
│   └─────────────────────────┘     │
│   ┌─────────────────────────┐     │
│   │ 🔍 Search: [______]     │     │
│   └─────────────────────────┘     │
│   ┌─────────────────────────┐     │
│   │ [Table Data]            │     │
│   │ [✏️ Edit] [🗑️ Delete]   │     │
│   └─────────────────────────┘     │
└────────┬──────────────┬───────────┘
         │              │
    [Create]        [Edit]
         │              │
         ▼              ▼
   ┌──────────┐   ┌───────────┐
   │ Create   │   │  Edit     │
   │  Form    │   │  Form     │
   │          │   │  [Delete] │
   └────┬─────┘   └─────┬─────┘
        │               │
        └───────┬───────┘
                ▼
          [Back to List]
```

## 🚀 Cara Menggunakan

### 1. Akses Menu Wartawan

**Step 1:** Login ke admin panel
```
URL: http://localhost:8000/admin
```

**Step 2:** Di sidebar, klik menu **👤 Wartawans**

### 2. Membuat Wartawan Baru

**Langkah-langkah:**

1. Klik tombol **"+ Create Wartawan"**
2. Isi form:
   - **Nama:** Ketik nama lengkap wartawan (wajib)
   - **Email:** Ketik email valid (wajib)
3. Klik **"Create"**
4. Notifikasi sukses muncul
5. Redirect ke halaman list

**Contoh Input:**
```
Nama: Ahmad Fauzi Hidayat
Email: ahmad.fauzi@kompas.com
```

**Tips:**
- Gunakan email asli untuk memudahkan kontak
- Nama sebaiknya lengkap dan formal
- Email harus unique (tidak boleh duplikat)

### 3. Mencari Wartawan

**Cara 1: Search by Nama**
```
🔍 Search: [ahmad]
```
Hasil: Semua wartawan dengan nama mengandung "ahmad"

**Cara 2: Search by Email**
```
🔍 Search: [@kompas]
```
Hasil: Semua wartawan dengan email mengandung "@kompas"

**Cara 3: Kombinasi**
```
🔍 Search: [fauzi]
```
Hasil: Wartawan dengan nama ATAU email mengandung "fauzi"

### 4. Sorting Data

**Sort by Nama:**
- Klik header "Nama" → A-Z
- Klik lagi → Z-A
- Klik lagi → Reset

**Sort by Email:**
- Klik header "Email" → A-Z
- Klik lagi → Z-A
- Klik lagi → Reset

### 5. Mengedit Wartawan

**Langkah-langkah:**

1. Di halaman list, klik icon **✏️ Edit**
2. Form edit terbuka dengan data terisi
3. Ubah nama atau email sesuai kebutuhan
4. Klik **"Save Changes"**
5. Notifikasi sukses muncul
6. Redirect ke halaman list

**Contoh:**
```
Before:
Nama: Ahmad Fauzi
Email: ahmad@gmail.com

After:
Nama: Dr. Ahmad Fauzi, M.Kom
Email: ahmad.fauzi@kompas.com
```

### 6. Menghapus Wartawan

**⚠️ Perhatian:** Hapus semua berita wartawan tersebut terlebih dahulu!

**Cara 1: Delete Single**
1. Klik icon **🗑️ Delete**
2. Konfirmasi di modal popup
3. Wartawan terhapus

**Cara 2: Bulk Delete**
1. Centang checkbox beberapa wartawan
2. Klik **"Delete Selected"**
3. Konfirmasi
4. Semua wartawan terpilih terhapus

**Error yang Mungkin Muncul:**
```
❌ Cannot delete wartawan. 
   This wartawan has 5 news articles.
   Delete the articles first.
```

**Solusi:**
- Hapus semua berita wartawan tersebut
- Atau ubah berita ke wartawan lain
- Atau ubah migration menjadi `onDelete('cascade')`

## 🎨 Customization

### 1. Mengubah Navigation Icon

```php
protected static ?string $navigationIcon = 'heroicon-o-user-group';
```

**Icon Suggestions:**
- `heroicon-o-user-group` → Grup user
- `heroicon-o-identification` → ID card
- `heroicon-o-users` → Multiple users
- `heroicon-o-user-circle` → User dengan circle

Lihat: [Heroicons](https://heroicons.com)

### 2. Mengubah Navigation Label

```php
protected static ?string $navigationLabel = 'Jurnalis';
protected static ?string $pluralModelLabel = 'Jurnalis';
protected static ?string $modelLabel = 'Jurnalis';
```

Menu akan berubah dari "Wartawans" menjadi "Jurnalis"

### 3. Mengubah Navigation Group

```php
protected static ?string $navigationGroup = 'User Management';
```

Wartawan akan masuk ke group "User Management" di sidebar

### 4. Mengubah Navigation Sort

```php
protected static ?int $navigationSort = 1;
```

Menentukan urutan menu (1 = paling atas)

### 5. Menambah Field Phone Number

```php
public static function form(Form $form): Form
{
    return $form->schema([
        TextInput::make('nama')
            ->required()
            ->maxLength(255)
            ->label('Nama')
            ->placeholder('Masukkan nama wartawan')
            ->helperText('Maksimal 255 karakter'),
        
        TextInput::make('email')
            ->required()
            ->email()
            ->label('Email')
            ->placeholder('Masukkan email wartawan')
            ->helperText('Masukkan alamat email yang valid'),
        
        // Field baru: Phone
        TextInput::make('phone')
            ->label('No. Telepon')
            ->tel()
            ->placeholder('08xx xxxx xxxx')
            ->helperText('Masukkan nomor telepon yang bisa dihubungi'),
    ]);
}
```

**Jangan lupa:**
1. Tambahkan kolom `phone` di migration
2. Tambahkan ke `$fillable` di model
3. Tambahkan kolom di table

### 6. Menambah Column di Table

```php
->columns([
    TextColumn::make('id')
        ->label('ID')
        ->sortable(),
    
    TextColumn::make('nama')
        ->label('Nama')
        ->sortable()
        ->searchable(),
    
    TextColumn::make('email')
        ->label('Email')
        ->sortable()
        ->searchable(),
    
    // Kolom baru: Jumlah berita
    TextColumn::make('news_count')
        ->counts('news')
        ->label('Jumlah Berita')
        ->sortable(),
    
    // Kolom timestamps
    TextColumn::make('created_at')
        ->label('Terdaftar Sejak')
        ->dateTime('d M Y')
        ->sortable(),
])
```

### 7. Menambah Filter

```php
->filters([
    // Filter wartawan yang punya berita
    Filter::make('has_news')
        ->label('Memiliki Berita')
        ->query(fn (Builder $query) => $query->has('news')),
    
    // Filter wartawan tanpa berita
    Filter::make('no_news')
        ->label('Belum Ada Berita')
        ->query(fn (Builder $query) => $query->doesntHave('news')),
])
```

### 8. Menambah View Action

```php
->actions([
    Tables\Actions\ViewAction::make(),  // View only (read-only)
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
])
```

### 9. Custom Notifications

Edit di `CreateWartawan.php` atau `EditWartawan.php`:

```php
protected function getCreatedNotificationTitle(): ?string
{
    return 'Wartawan berhasil ditambahkan! 🎉';
}

protected function getSavedNotificationTitle(): ?string
{
    return 'Data wartawan berhasil diperbarui! ✅';
}

protected function getDeletedNotificationTitle(): ?string
{
    return 'Wartawan telah dihapus.';
}
```

### 10. Menambah Relation Manager

Untuk menampilkan semua berita wartawan di halaman edit:

```php
public static function getRelations(): array
{
    return [
        RelationManagers\NewsRelationManager::class,
    ];
}
```

Kemudian buat `NewsRelationManager` dengan command:
```bash
php artisan make:filament-relation-manager WartawanResource news judul
```

## 🔗 Relasi dengan News

### Relasi di Model

```php
// Model: Wartawan.php
public function news()
{
    return $this->hasMany(News::class, 'wartawan_id');
}
```

**Artinya:**
- 1 wartawan bisa punya banyak berita (One to Many)
- Foreign key: `wartawan_id` di table `news`

### Menggunakan Relasi

#### Mengambil Semua Berita Wartawan

```php
$wartawan = Wartawan::find(1);
$berita_list = $wartawan->news;

foreach($berita_list as $berita) {
    echo $berita->judul;
}
```

#### Menghitung Jumlah Berita

```php
$wartawan = Wartawan::withCount('news')->find(1);
echo "Jumlah berita: " . $wartawan->news_count;
```

#### Query Builder

```php
// Wartawan yang memiliki minimal 5 berita
$wartawan_produktif = Wartawan::has('news', '>=', 5)->get();

// Wartawan yang belum punya berita
$wartawan_baru = Wartawan::doesntHave('news')->get();
```

### Dependency di Database

```
┌─────────────────┐
│    wartawan     │
│  id (PK) ───┐   │
│  nama       │   │
│  email      │   │
└─────────────┘   │
                  │ 1:N (One to Many)
                  │
                  ▼
┌─────────────────┐
│      news       │
│  id (PK)        │
│  judul          │
│  wartawan_id(FK)│ ← Foreign Key Constraint
└─────────────────┘
```

**Foreign Key Constraint:**
- Tidak bisa hapus wartawan jika punya berita
- Harus hapus berita dulu, baru bisa hapus wartawan
- Atau set `onDelete('cascade')` untuk hapus otomatis

## 🔄 Integrasi dengan Aplikasi

### 1. Digunakan di NewsResource

Di `NewsResource.php`, wartawan digunakan di dropdown:

```php
Select::make('wartawan_id')
    ->label('Wartawan')
    ->relationship('wartawan', 'nama')  // ← Mengambil dari WartawanResource
    ->preload()
    ->required()
```

### 2. Digunakan di Frontend

Di controller atau blade, wartawan ditampilkan:

```php
// Controller
$berita = News::with('wartawan')->get();

// Blade
@foreach($news_list as $news)
    <p>Ditulis oleh: {{ $news->wartawan->nama }}</p>
@endforeach
```

### 3. API Resource (Optional)

Jika membuat API:

```php
// WartawanResource.php (API Resource, bukan Filament)
public function toArray($request)
{
    return [
        'id' => $this->id,
        'nama' => $this->nama,
        'email' => $this->email,
        'jumlah_berita' => $this->news->count(),
        'berita' => NewsResource::collection($this->news),
    ];
}
```

## 📚 Referensi

### Dokumentasi Filament
- [Filament Documentation](https://filamentphp.com/docs)
- [Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started)
- [Forms](https://filamentphp.com/docs/3.x/forms/fields/text-input)
- [Tables](https://filamentphp.com/docs/3.x/tables/columns/text)
- [Actions](https://filamentphp.com/docs/3.x/actions/overview)

### Laravel Eloquent
- [Eloquent Relationships](https://laravel.com/docs/11.x/eloquent-relationships)
- [One to Many](https://laravel.com/docs/11.x/eloquent-relationships#one-to-many)

### UI Components
- [Heroicons](https://heroicons.com) - Icon library
- [Tailwind CSS](https://tailwindcss.com) - CSS framework yang digunakan Filament

## 💡 Tips & Best Practices

### 1. Validasi Email Unique

Tambahkan validasi agar email tidak duplikat:

```php
TextInput::make('email')
    ->required()
    ->email()
    ->unique(ignoreRecord: true)  // Unique, kecuali record yang sedang diedit
    ->label('Email')
```

### 2. Format Email Lowercase

Auto-convert email ke lowercase:

```php
TextInput::make('email')
    ->required()
    ->email()
    ->unique(ignoreRecord: true)
    ->dehydrateStateUsing(fn ($state) => strtolower($state))  // Convert ke lowercase
    ->label('Email')
```

### 3. Placeholder yang Jelas

Gunakan placeholder yang informatif:

```php
->placeholder('contoh: ahmad.fauzi@kompas.com')
```

### 4. Avatar/Photo (Advanced)

Tambah upload photo wartawan:

```php
FileUpload::make('avatar')
    ->label('Foto Profil')
    ->image()
    ->maxSize(2048)  // 2MB
    ->directory('avatars')
    ->helperText('Format: JPG, PNG. Maksimal 2MB')
```

### 5. Soft Delete (Advanced)

Aktifkan soft delete untuk recovery:

```php
// Di model Wartawan.php
use SoftDeletes;

// Di WartawanResource.php
->filters([
    TrashedFilter::make(),
])
```
---

**Next Steps:**
- Pelajari NewsResource untuk manajemen berita
- Pelajari Eloquent Relationships lebih dalam
- Coba customization sesuai kebutuhan proyek
