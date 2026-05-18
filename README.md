# Catatan Belajar Laravel Eloquent

Catatan ini disusun agar mudah dipahami oleh programmer junior, merangkum konsep-konsep dasar hingga lanjutan dari Eloquent ORM di Laravel, lengkap dengan referensi penggunaannya pada kode project ini.

---

## 1. Operasi Dasar (CRUD)

### Insert (Menambah Data)
Membuat instance object baru, isi property-nya, lalu panggil `save()`.
```php
$category = new Category();
$category->id = 'C001';
$category->name = 'Gadget';
$category->save(); // Baru melakukan query INSERT setelah save() dipanggil
```

### Insert Many (Menambah Banyak Data)
Gunakan Query Builder `insert()` untuk mengeksekusi banyak data sekaligus dari array, sehingga performa lebih cepat dibanding satu per satu.
```php
Category::query()->insert([
    ['id' => 'C002', 'name' => 'Fashion'],
    ['id' => 'C003', 'name' => 'Food']
]);
```

### Find (Mencari Data)
Cara termudah mencari 1 data berdasarkan *Primary Key*. Mengembalikan satu object Model.
```php
$category = Category::query()->find('C001'); // Mencari ID 'C001'
```

### Select (Mengambil Data Berdasarkan Kondisi)
Mirip seperti `SELECT ... WHERE ...` pada SQL. Gunakan `get()` untuk mengeksekusi dan mengambil semua hasilnya.
```php
$categories = Category::where('name', 'Gadget')->get();

// Menghitung jumlah keseluruhan data (SELECT COUNT)
$count = Category::count();
```

### Update (Mengubah Data)
Cara 1: Cari datanya dulu dengan `find()`, ubah property-nya, lalu `save()`.
```php
$category = Category::query()->find('C001');
$category->name = 'Gadget Update';
$category->save(); 
```

### Update Many (Mengubah Banyak Data)
Cara 2: Update banyak data sekaligus menggunakan Query Builder tanpa harus me-load semuanya ke dalam memori.
```php
Category::whereNull('description')->update(['description' => 'Updated Description']);
```

### Delete (Menghapus Data)
Cari datanya dulu, lalu panggil method `delete()`.
```php
$category = Category::query()->find('C001');
$category->delete();
```

### Delete Many (Menghapus Banyak Data)
Hapus banyak data secara langsung menggunakan Query Builder.
```php
Category::whereNull('description')->delete();
```

---

## 2. Fitur-fitur Atribut pada Model

### UUID
Jika *Primary Key* kamu bukan angka *Auto Increment* melainkan string acak unik (UUID).
- Di Model: gunakan trait `use HasUuids;` (Contoh penerapannya ada di Model `Voucher`).
- Jika nama kolom UUID kamu bukan `id`, override method `uniqueIds()` untuk mendefinisikannya.

### Timestamps
Laravel bisa otomatis mengisi kolom `created_at` dan `updated_at`.
- Di tabel database: gunakan `$table->timestamps();`.
- Di Model: aktif secara default. Jika tabel tidak punya timestamps, set `public $timestamps = false;` (Contoh di Model `Category`).

### Default Attribute Values
Memberi nilai bawaan (*default*) langsung dari level aplikasi (Laravel) sebelum di insert.
- Tambahkan property `protected $attributes = [...];` pada Model (Contoh di Model `Comment`).

### Fillable Attributes (Mass Assignment)
Agar aman, Laravel memblokir input massal (misal input satu form penuh dari user). Kamu harus mengizinkan kolom apa saja yang boleh diisi langsung secara *Mass Assignment* lewat property `$fillable`.
```php
// Di Model Category:
protected $fillable = ["id", "name", "description"];

// Cara menggunakannya:
// create() akan mengecek fillable dan langsung insert ke database.
Category::create($requestDataArray); 
```

### Soft Delete
Data yang dihapus tidak benar-benar hilang dari database, melainkan hanya diisi tanggalnya di kolom `deleted_at`.
- Di tabel database: `$table->softDeletes();`
- Di Model: gunakan trait `use SoftDeletes;` (Contoh di Model `Voucher`).
- Saat `$voucher->delete()` dipanggil, data akan disembunyikan.
- Mengambil data termasuk yang dihapus: `Voucher::withTrashed()->get()`
- Menghapus permanen: `$voucher->forceDelete()`

---

## 3. Query Scopes (Template Query)
Scope digunakan untuk menyatukan query agar gampang dipakai berulang kali.

### Query Global Scope
Scope ini akan otomatis **selalu menempel** di setiap kita melakukan query pada Model tersebut.
- Cara Buat: Buat class khusus (contoh: `IsActiveScope` di folder `Models/Scopes`), dan wajib punya fungsi `apply()`.
- Cara Daftar: Pasang (register) di method `booted()` pada Model (Contoh di Model `Category`).
- Jika mau dimatikan sesekali saat query: `Category::withoutGlobalScope(IsActiveScope::class)->get()`

### Query Local Scope
Method untuk menambahkan query kustom langsung dari dalam model.
```php
// Di model Voucher, gunakan prefix 'scope' di nama method
public function scopeActive(Builder $builder): void {
    $builder->where('is_active', true);
}

// Di controller saat dipakai, panggil namanya tanpa kata 'scope'
Voucher::query()->active()->get();
```

---

## 4. Relationships (Relasi Antar Tabel)

### One to One
Hubungan 1 baris ke tepat 1 baris di tabel lain. (Contoh: 1 `Customer` punya 1 `Wallet`).
- Model Asal: `hasOne(ModelTujuan::class)`
- Model Tujuan: `belongsTo(ModelAsal::class)`

### One to Many
Hubungan 1 baris ke banyak baris. (Contoh: 1 `Category` punya banyak `Product`).
- Model Asal: `hasMany(ModelTujuan::class)`
- Model Tujuan: `belongsTo(ModelAsal::class)`

### Query Builder Relationship
Kita bisa mem-filter data relasi lagi dengan menambahkan *query builder* di belakang pemanggilan method relasi.
```php
$category->products()->where('price', '>', 10000)->get();
```

### Has One of Many
Punya relasi HasMany, tapi kita ingin membuat relasi praktis untuk mengambil **hanya 1 data paling spesifik** (contoh barang termurah / barang paling akhir ditambah).
```php
// Di model Category
public function cheapestProduct(): HasOne {
    return $this->hasOne(Product::class)->oldest("price"); // Mengambil 1 termurah
}
```

### Has One Through & Has Many Through
Jalan pintas relasi dengan melompati/melewati tabel perantara.
- **Has One Through**: Contoh dari `Customer` ingin mengambil `VirtualAccount` dengan melewati tabel `Wallet`.
- **Has Many Through**: Contoh dari `Category` ingin mengambil kumpulan `Review` dengan melewati tabel `Product`.

### Many to Many
Hubungan banyak-ke-banyak, mutlak membutuhkan 1 tabel perantara / tabel *pivot*. (Contoh: `Customer` dan `Product` punya relasi saling menyukai (*Like*)).
- Di kedua model gunakan: `belongsToMany(Model::class, 'nama_tabel_perantara')`.
- Untuk menambahkan relasi: `$customer->likeProducts()->attach($product_id)`
- Untuk menghapus relasi: `$customer->likeProducts()->detach($product_id)`

### Pivot Model
Tabel perantara dari Many-to-Many bisa kamu buatkan class Modelnya sendiri (wajib *extends* class `Pivot`, bukan Model). (Contoh: model `Like`).
Untuk menyambungkannya, gunakan `->using(Like::class)` di dalam definisi relasi `belongsToMany`.

---

## 5. Polymorphic Relationships
Bentuk relasi canggih dimana sebuah tabel (Tabel Relasi) bisa terhubung (digunakan) oleh banyak tabel lain yang sama sekali berbeda tipe dan fungsinya. 
Setiap tabel morph wajib punya kolom ID relasi (`xxx_id`) dan Tipe Model asalnya (`xxx_type`).

### One to One Polymorphic
Contoh: Tabel `images` bisa difungsikan sebagai foto profile `Customer`, atau juga sebagai foto `Product`.
- Di tabel `images`: butuh field `imageable_id` & `imageable_type`.
- Di Model `Image`: panggil `morphTo()`.
- Di Model `Customer` / `Product`: panggil `morphOne(Image::class, 'imageable')`.

### One to Many Polymorphic
Contoh: Tabel `comments` bisa berfungsi sebagai komentar untuk barang (`Product`), maupun komentar untuk kupon (`Voucher`).
- Di Model `Comment`: panggil `morphTo()`.
- Di Model `Product` / `Voucher`: panggil `morphMany(Comment::class, 'commentable')`.

### One of Many Polymorphic
Variasi dari *One to Many Polymorphic*. Fungsinya hanya untuk ngambil **satu data spesifik** dari relasi morph.
```php
// Di model Product
public function latestComment(): MorphOne {
    return $this->morphOne(Comment::class, "commentable")->latest("created_at");
}
```

### Many to Many Polymorphic
Contoh: Sistem penanda (`Tag`). Tabel `tags` (Banyak tag) bisa nempel di `Product` dan juga `Voucher`.
- Butuh tabel pivot *taggables* (`tag_id`, `taggable_id`, `taggable_type`).
- Di model `Tag`: panggil `morphedByMany(TujuanModel::class, 'taggable')`.
- Di model `Product` / `Voucher`: panggil `morphToMany(Tag::class, 'taggable')`.

---

## 6. Optimization & Eksekusi Relasi

### Lazy dan Eager Loading
- **Lazy Loading**: (Otomatis & Bahaya N+1 Query). Data relasi baru di-query ke DB pada detik kita memanggil `$model->relasi`. Jika ini ada di dalam looping, query akan berjalan ribuan kali.
- **Eager Loading**: (Solusi Cepat). Datanya langsung di Join / diambil sekaligus di awal secara optimal dengan fungsi `with()`.
```php
// Cara memanggil Eager Loading dari controller:
$customers = Customer::with('wallet')->get();
```
> Catatan: Bisa juga diset default eager load di model lewat `protected $with = ["wallet"];` seperti di Model `Customer`.

### Querying Relations
Melakukan Query `WHERE` berdasarkan kondisi tabel relasinya (Misal: Ambil Kategori yang punya Produk di atas harga 100).
```php
Category::whereHas('products', function($query) {
    $query->where('price', '>', 100);
})->get();
```

### Aggregating Relations
Menghitung relasinya (Menjumlah, Rata-rata, Min/Max) tanpa perlu meload semua isi datanya. Lebih ringan ke database.
```php
$categories = Category::withCount('products')->get();
// Nantinya bisa dipanggil lewat property: $category->products_count
```

---

## 7. Fitur Lanjutan Lainnya

### Eloquent Collection
Hasil data keluaran `get()` bukanlah array PHP biasa, tapi *Collection*. Collection ini kaya fitur (mirip array javascript modern), kita bisa pakai fungsi canggih bawaan seperti `->map()`, `->filter()`, dll langsung ke datanya tanpa looping manual.

### Accessors dan Mutators
Fungsi memodifikasi format data secara rahasia di Model. (Contoh di Model `Person`).
- **Accessor**: Mengubah data saat mau diambil ke view/ditampilkan (Contoh huruf besar semua).
- **Mutator**: Mengubah format data sesaat sebelum disimpan ke database (Contoh simpan uang yang diformat).
Digunakan lewat class `Attribute::make(get: ..., set: ...)`.

### Attribute Casting
Otomatis konversi tipe data yang keluar dari database. (Misal di DB datanya string `2023-01-01`, lewat *Casting* otomatis jadi object `datetime` PHP).
Diatur lewat property `protected $casts = [];` (Contoh di Model `Person` & `Category`).

### Custom Casts
Bikin casting buatan kita sendiri berbentuk *Class Object*. 
- Contoh: mengubah gabungan string alamat jadi Object `Address`.
- Buat class yang implements `CastsAttributes` (Lihat class `AsAddress`).
- Sambungkan di Model `Person` lewat array `$casts`: `"address" => AsAddress::class`.

### Serialization
Saat `$model->toArray()` atau dijadikan bentuk JSON untuk API:
- Sembunyikan kolom rahasia lewat `protected $hidden = ['kolom_rahasia'];` (Contoh di `User` dan `Product`).
- Munculkan *Accessor* yang sebenarnya ngga ada di Database agar ikut jadi JSON lewat `protected $appends = ['nama_accessor_kamu'];`.

### Factory
Pembuat data Dummy (Bohongan) instan dalam jumlah banyak, super berguna untuk Unit Testing atau Data Seeder.
- Terletak di folder `database/factories` (Contoh: `EmployeeFactory`).
- `definition()`: Menentukan template isi datanya apa saja.
- Bisa buat *state*/variasi, seperti method `programmer()` atau `seniorProgrammer()`.
- Cara jalankan: `Employee::factory()->programmer()->count(10)->create();`