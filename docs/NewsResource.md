# 📰 Dokumentasi NewsResource

## 📋 Daftar Isi

- [Tentang NewsResource](#tentang-newsresource)
- [Lokasi File](#lokasi-file)
- [Struktur Resource](#struktur-resource)
- [Form Schema](#form-schema)
- [Table Configuration](#table-configuration)
- [Actions & Bulk Actions](#actions--bulk-actions)
- [Pages & Routes](#pages--routes)
- [Cara Menggunakan](#cara-menggunakan)
- [Customization](#customization)

## 🎯 Tentang NewsResource

`NewsResource` adalah Filament Resource yang digunakan untuk mengelola data berita (news) melalui admin panel. Resource ini menyediakan interface CRUD (Create, Read, Update, Delete) yang lengkap untuk manajemen berita dengan form yang user-friendly dan tabel data yang interaktif.

### Fitur Utama:
- ✅ Form input berita dengan Rich Text Editor
- ✅ Relasi dengan model Wartawan
- ✅ Tabel data dengan sorting dan searching
- ✅ Actions untuk Edit dan Delete
- ✅ Bulk delete untuk menghapus multiple records
- ✅ Validasi input otomatis

## 📂 Lokasi File

```
app/
└── Filament/
    └── Resources/
        ├── NewsResource.php              # Main resource file
        └── NewsResource/
            └── Pages/
                ├── ListNews.php          # Halaman list data
                ├── CreateNews.php        # Halaman create
                └── EditNews.php          # Halaman edit
```

## 🏗 Struktur Resource

```php
namespace App\Filament\Resources;

class NewsResource extends Resource
{
    // Model yang digunakan
    protected static ?string $model = News::class;
    
    // Icon di navigation menu (menggunakan Heroicons)
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
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
| `$model` | `News::class` | Model Eloquent yang dikelola |
| `$navigationIcon` | `'heroicon-o-newspaper'` | Icon koran untuk menu navigasi |

## 📝 Form Schema

Form schema mendefinisikan bagaimana form input berita akan ditampilkan dan divalidasi.

```php
public static function form(Form $form): Form
{
    return $form->schema([
        Section::make('Detail Berita')
            ->schema([
                // Field 1: Dropdown Wartawan
                Select::make('wartawan_id'),
                
                // Field 2: Input Judul
                TextInput::make('judul'),
                
                // Field 3: Input Ringkasan
                TextInput::make('ringkasan'),
                
                // Field 4: Rich Text Editor untuk Isi
                RichEditor::make('isi'),
            ]),
    ]);
}
```

### Breakdown Field by Field:

#### 1. Section - Container Form

```php
Section::make('Detail Berita')
    ->schema([...])
```

**Fungsi:** Mengelompokkan field-field dalam satu section dengan judul "Detail Berita"

**Output Visual:**
```
┌─────────────────────────────────┐
│      Detail Berita              │
├─────────────────────────────────┤
│  [Form fields disini]           │
└─────────────────────────────────┘
```

#### 2. Select - Dropdown Wartawan

```php
Select::make('wartawan_id')
    ->label('Wartawan')
    ->relationship('wartawan', 'nama')
    ->preload()
    ->required()
```

**Penjelasan:**
- `make('wartawan_id')` → Field untuk foreign key `wartawan_id`
- `->label('Wartawan')` → Label yang ditampilkan: "Wartawan"
- `->relationship('wartawan', 'nama')` → Mengambil data dari relasi `wartawan()` di model News, menampilkan kolom `nama`
- `->preload()` → Load semua option wartawan saat halaman dibuka (tidak lazy load)
- `->required()` → Field ini wajib diisi

**Validasi:**
- ✅ Tidak boleh kosong (required)
- ✅ Harus ID wartawan yang valid (foreign key constraint)

**Output Visual:**
```
Wartawan *
┌──────────────────────────────┐
│ Pilih wartawan...          ▼ │
└──────────────────────────────┘
```

#### 3. TextInput - Judul Berita

```php
TextInput::make('judul')
    ->label('Judul Berita')
    ->required()
    ->maxLength(255)
```

**Penjelasan:**
- `make('judul')` → Field untuk kolom `judul`
- `->label('Judul Berita')` → Label: "Judul Berita"
- `->required()` → Wajib diisi
- `->maxLength(255)` → Maksimal 255 karakter

**Validasi:**
- ✅ Tidak boleh kosong
- ✅ Maksimal 255 karakter

**Output Visual:**
```
Judul Berita *
┌──────────────────────────────┐
│                              │
└──────────────────────────────┘
```

#### 4. TextInput - Ringkasan

```php
TextInput::make('ringkasan')
    ->label('Ringkasan')
    ->required()
    ->maxLength(255)
```

**Penjelasan:**
- Field untuk ringkasan/preview berita
- Sama seperti field judul, maksimal 255 karakter
- Akan ditampilkan sebagai preview di halaman list berita

**Validasi:**
- ✅ Tidak boleh kosong
- ✅ Maksimal 255 karakter

#### 5. RichEditor - Isi Berita

```php
RichEditor::make('isi')
    ->label('Isi Berita')
    ->required()
```

**Penjelasan:**
- `RichEditor` → WYSIWYG editor (What You See Is What You Get)
- Memiliki toolbar untuk formatting: bold, italic, list, link, dll
- Support HTML output

**Fitur Editor:**
- **Bold, Italic, Underline**
- **Bullet & Numbered Lists**
- **Links**
- **Headings**
- **Code blocks**

**Output Visual:**
```
Isi Berita *
┌────────────────────────────────────────┐
│ [B] [I] [U] [•] [1.] [🔗] [</>]       │
├────────────────────────────────────────┤
│                                        │
│  Tulis isi berita disini...            │
│                                        │
│                                        │
└────────────────────────────────────────┘
```

**Validasi:**
- ✅ Tidak boleh kosong

## 📊 Table Configuration

Table configuration mendefinisikan bagaimana data berita ditampilkan dalam bentuk tabel.

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([...])      // Definisi kolom
        ->filters([...])      // Filter data
        ->actions([...])      // Action per row
        ->bulkActions([...])  // Action untuk multiple rows
}
```

### Columns (Kolom Tabel)

```php
->columns([
    TextColumn::make('wartawan.nama'),
    TextColumn::make('judul'),
    TextColumn::make('ringkasan'),
    TextColumn::make('isi'),
])
```

#### 1. Kolom Wartawan

```php
TextColumn::make('wartawan.nama')
    ->label('Nama Wartawan')
    ->searchable()
    ->sortable()
```

**Penjelasan:**
- `wartawan.nama` → Mengakses relasi `wartawan` dan menampilkan kolom `nama`
- `->searchable()` → Kolom bisa di-search
- `->sortable()` → Kolom bisa di-sort ascending/descending

**Contoh Output:**
```
Nama Wartawan    🔍
─────────────────
Ahmad Fauzi
Siti Nurhaliza
Budi Santoso
```

#### 2. Kolom Judul

```php
TextColumn::make('judul')
    ->label('Judul Berita')
    ->searchable()
    ->sortable()
```

**Penjelasan:**
- Menampilkan judul berita
- Bisa di-search dan di-sort

#### 3. Kolom Ringkasan

```php
TextColumn::make('ringkasan')
    ->label('Ringkasan')
    ->limit(50)
    ->sortable()
```

**Penjelasan:**
- `->limit(50)` → Memotong teks menjadi 50 karakter dengan "..." di akhir
- Berguna untuk teks panjang agar tabel tidak terlalu lebar

**Contoh:**
```
Ringkasan
──────────────────────────────────
Ini adalah ringkasan berita yang panjang...
Berita terbaru tentang ekonomi Indonesia...
```

#### 4. Kolom Isi

```php
TextColumn::make('isi')
    ->label('Isi Berita')
    ->limit(50)
    ->sortable()
```

**Penjelasan:**
- Sama seperti ringkasan, dipotong 50 karakter
- Memberikan preview isi berita

### Table Layout Example

```
┌─────────────────┬──────────────────────┬─────────────────────┬─────────────────────┬─────────┐
│ Nama Wartawan   │ Judul Berita         │ Ringkasan           │ Isi Berita          │ Actions │
├─────────────────┼──────────────────────┼─────────────────────┼─────────────────────┼─────────┤
│ Ahmad Fauzi     │ Ekonomi Meningkat    │ Pertumbuhan ekono...│ Jakarta - Ekonomi...│ ✏️  🗑️  │
│ Siti Nurhaliza  │ Teknologi AI         │ Perkembangan AI d...│ Teknologi kecerda...│ ✏️  🗑️  │
│ Budi Santoso    │ Olahraga Nasional    │ Tim nasional meng...│ Timnas Indonesia ...│ ✏️  🗑️  │
└─────────────────┴──────────────────────┴─────────────────────┴─────────────────────┴─────────┘
```

## 🔧 Actions & Bulk Actions

### Row Actions (Per Berita)

```php
->actions([
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
])
```

**Penjelasan:**

#### EditAction
- **Icon:** ✏️ (Pensil)
- **Fungsi:** Membuka form edit untuk berita tersebut
- **Route:** Mengarah ke `/admin/news/{id}/edit`
- **Behavior:** Membuka halaman edit dengan form yang sudah terisi data

#### DeleteAction
- **Icon:** 🗑️ (Trash)
- **Fungsi:** Menghapus berita
- **Behavior:** 
  - Menampilkan modal konfirmasi
  - Jika dikonfirmasi, menghapus record dari database
  - Menampilkan notifikasi sukses/error

**Contoh Konfirmasi Delete:**
```
╔═══════════════════════════════════╗
║  Konfirmasi Hapus                 ║
╟───────────────────────────────────╢
║  Apakah Anda yakin ingin          ║
║  menghapus berita ini?            ║
║                                   ║
║  [Batal]  [Hapus]                 ║
╚═══════════════════════════════════╝
```

### Bulk Actions (Multiple Berita)

```php
->bulkActions([
    Tables\Actions\BulkActionGroup::make([
        Tables\Actions\DeleteBulkAction::make(),
    ]),
])
```

**Penjelasan:**
- **Fungsi:** Menghapus beberapa berita sekaligus
- **Cara Pakai:** 
  1. Centang checkbox di beberapa row
  2. Klik tombol "Delete Selected"
  3. Konfirmasi penghapusan
  4. Semua berita yang dipilih akan terhapus

**Visual:**
```
☑️ [✓] Ahmad Fauzi    │ Ekonomi Meningkat
☑️ [✓] Siti Nurhaliza │ Teknologi AI
☐ [ ] Budi Santoso    │ Olahraga Nasional

[Delete Selected (2)]
```

## 🗺 Pages & Routes

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListNews::route('/'),
        'create' => Pages\CreateNews::route('/create'),
        'edit' => Pages\EditNews::route('/{record}/edit'),
    ];
}
```

### Route Structure

| Page Name | Route Path | URL | Fungsi |
|-----------|------------|-----|--------|
| `index` | `/` | `/admin/news` | List semua berita |
| `create` | `/create` | `/admin/news/create` | Form create berita baru |
| `edit` | `/{record}/edit` | `/admin/news/5/edit` | Form edit berita ID 5 |

### Page Classes

#### 1. ListNews.php
```php
// Location: app/Filament/Resources/NewsResource/Pages/ListNews.php

class ListNews extends ListRecords
{
    protected static string $resource = NewsResource::class;
    
    // Menambahkan tombol "Create" di header
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
```

**Fitur:**
- Menampilkan tabel data berita
- Search bar
- Filter (jika ada)
- Pagination
- Tombol "Create News" di header

#### 2. CreateNews.php
```php
// Location: app/Filament/Resources/NewsResource/Pages/CreateNews.php

class CreateNews extends CreateRecord
{
    protected static string $resource = NewsResource::class;
}
```

**Fitur:**
- Form kosong untuk input berita baru
- Validasi real-time
- Tombol "Create" & "Create & Create Another"
- Redirect ke list page setelah sukses

#### 3. EditNews.php
```php
// Location: app/Filament/Resources/NewsResource/Pages/EditNews.php

class EditNews extends EditRecord
{
    protected static string $resource = NewsResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
```

**Fitur:**
- Form terisi dengan data berita yang akan diedit
- Tombol "Save Changes"
- Tombol "Delete" di header
- Redirect ke list page setelah sukses

### Navigation Flow

```
┌─────────────────────┐
│   Sidebar Menu      │
│   📰 News           │
└──────────┬──────────┘
           │
           ▼
┌─────────────────────────────────┐
│   List News Page                │
│   ┌───────────────────────┐     │
│   │  [+ Create News]      │     │
│   └───────────────────────┘     │
│   ┌─────────────────────────┐   │
│   │ Search: [________] 🔍   │   │
│   └─────────────────────────┘   │
│   ┌─────────────────────────┐   │
│   │ [Table Data]            │   │
│   │ [✏️ Edit] [🗑️ Delete]   │   │
│   └─────────────────────────┘   │
└───────┬──────────────┬──────────┘
        │              │
   [Create]        [Edit]
        │              │
        ▼              ▼
   ┌─────────┐   ┌──────────┐
   │ Create  │   │  Edit    │
   │  Form   │   │  Form    │
   └────┬────┘   └────┬─────┘
        │              │
        └──────┬───────┘
               ▼
          [Back to List]
```

## 🚀 Cara Menggunakan

### 1. Mengakses Admin Panel

```
URL: http://localhost:8000/admin
```

Login dengan kredensial admin yang sudah dibuat.

### 2. Navigasi ke News Management

Di sidebar kiri, klik menu **📰 News**

### 3. Membuat Berita Baru

**Step-by-step:**

1. Klik tombol **"+ Create News"** di pojok kanan atas
2. Form akan terbuka dengan field:
   - **Wartawan** → Pilih wartawan dari dropdown
   - **Judul Berita** → Ketik judul
   - **Ringkasan** → Ketik ringkasan singkat
   - **Isi Berita** → Ketik isi lengkap dengan rich editor
3. Klik **"Create"** untuk menyimpan
4. Atau klik **"Create & Create Another"** untuk langsung buat berita lagi

**Validasi:**
- Semua field wajib diisi
- Judul dan ringkasan max 255 karakter
- Wartawan harus dipilih dari dropdown

### 4. Mengedit Berita

**Step-by-step:**

1. Di halaman list, klik icon **✏️ Edit** pada row berita yang ingin diedit
2. Form edit akan terbuka dengan data yang sudah terisi
3. Ubah field yang ingin diubah
4. Klik **"Save Changes"**

### 5. Menghapus Berita

**Cara 1: Delete Single**
1. Klik icon **🗑️ Delete** pada row berita
2. Konfirmasi di modal popup
3. Berita akan terhapus

**Cara 2: Bulk Delete**
1. Centang checkbox beberapa berita
2. Klik **"Delete Selected"**
3. Konfirmasi
4. Semua berita terpilih akan terhapus

### 6. Mencari Berita

Gunakan search bar untuk mencari berdasarkan:
- Nama wartawan
- Judul berita

```
Search: [ekonomi______] 🔍
```

Hasil akan difilter secara real-time.

### 7. Sorting Data

Klik header kolom untuk sorting:
- Klik 1x → Ascending (A-Z, 0-9)
- Klik 2x → Descending (Z-A, 9-0)
- Klik 3x → Reset sorting

## 🎨 Customization

### Mengubah Icon Navigation

```php
protected static ?string $navigationIcon = 'heroicon-o-newspaper';
```

**Icon Options:**
- `heroicon-o-newspaper` → Koran
- `heroicon-o-document-text` → Dokumen
- `heroicon-o-book-open` → Buku
- Dan 200+ Heroicons lainnya

Lihat: [Heroicons](https://heroicons.com)

### Mengubah Label Navigation

```php
protected static ?string $navigationLabel = 'Berita';
protected static ?string $pluralModelLabel = 'Berita';
protected static ?string $modelLabel = 'Berita';
```

### Menambah Field Baru

Contoh menambah field `kategori`:

```php
Section::make('Detail Berita')
    ->schema([
        Select::make('wartawan_id')
            ->label('Wartawan')
            ->relationship('wartawan', 'nama')
            ->preload()
            ->required(),
        
        // Field baru: Kategori
        Select::make('kategori')
            ->label('Kategori')
            ->options([
                'politik' => 'Politik',
                'ekonomi' => 'Ekonomi',
                'olahraga' => 'Olahraga',
                'teknologi' => 'Teknologi',
            ])
            ->required(),
        
        TextInput::make('judul')
            ->label('Judul Berita')
            ->required()
            ->maxLength(255),
        // ... field lainnya
    ]),
```

### Menambah Filter

Contoh filter berdasarkan wartawan:

```php
->filters([
    SelectFilter::make('wartawan_id')
        ->label('Filter by Wartawan')
        ->relationship('wartawan', 'nama'),
])
```

### Menambah Column di Table

```php
->columns([
    TextColumn::make('id')
        ->label('ID')
        ->sortable(),
    
    TextColumn::make('wartawan.nama')
        ->label('Nama Wartawan')
        ->searchable()
        ->sortable(),
    
    // ... columns lainnya
    
    TextColumn::make('created_at')
        ->label('Dibuat Pada')
        ->dateTime('d M Y H:i')
        ->sortable(),
])
```

### Menambah View Action

```php
->actions([
    Tables\Actions\ViewAction::make(),  // Tambah action view
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
])
```

### Customize Notifications

```php
// Di CreateNews.php atau EditNews.php

protected function getCreatedNotificationTitle(): ?string
{
    return 'Berita berhasil dibuat!';
}

protected function getSavedNotificationTitle(): ?string
{
    return 'Berita berhasil diupdate!';
}
```

## 🔗 Relasi dengan Component Lain

```
NewsResource
    │
    ├── Model: News.php
    │   └── Relasi: belongsTo(Wartawan)
    │
    ├── Migration: 2025_11_05_021159_create_news_table.php
    │
    ├── Factory: NewsFactory.php
    │
    ├── Controller: NewsController.php (untuk frontend)
    │
    └── Views: resources/views/news/
        ├── index.blade.php
        └── show.blade.php
```

## 📚 Referensi

- [Filament Documentation](https://filamentphp.com/docs)
- [Filament Resources](https://filamentphp.com/docs/3.x/panels/resources/getting-started)
- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Filament Tables](https://filamentphp.com/docs/3.x/tables/installation)
- [Heroicons](https://heroicons.com)