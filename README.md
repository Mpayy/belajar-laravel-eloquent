Eloquent

- $data->save() = untuk insert satu data
- Model::query()->insert($dataArray) = untuk insert langsung banyak data atau satu data juga bisa
- Model::query()->find("primaryKey") = untuk mencari data berdasarkan primary key di database, dan mengembalikan semua data yang di dapat
- $data->update() = untuk mengupdate data, tetapi harus melakukan find() terlebih dahulu
- Model::where("description")->get() = ini seperti select where
- Model::count() = untuk menghitung berapa banyak row table
- Model::whereNull("description")->update(["description" => "Updated"]); = update juga bisa di lakukan langsung ke banyak data seperti ini menggunakan Query Builder
- $data->delete() = sama seperti delete where, tapi harus find() terlebih dahulu
- Model::whereNull("description")->delete(); = delete juga bisa di lakukan langsung ke banyak data seperti ini menggunakan Query Builder

- id juga bisa menggunakan UUID dengan cara mengimport HasUuids pada model
- UUID juga bisa digunakan untuk mengisi field table, dengan cara mengoveridenya property uniqueIds

- $table->timestamps(); untuk auto membuat created_at dan updated_at
- selain kita bisa memebuat default attribute di database (direkomendasikan), kita juga bisa membuat default atribut di laravelnya sebelum di kirimkan ke database dengan cara menambahkan di model protected $attributes

- protected $fillable = ini agar memberi izin field di table bisa di ubah fillednya secara massal (mass assignment)
- Model::create($arrayRequest) = method ini akan langsung menginsert ke db dan mengecek fillable terlebih dahulu. berbeda dengan save() yang akan menyimpan kedb setelah method save() di panggil

- $category->fill($request) = ini digunakan untuk mengupdate field secara masal, tetapi harus find dulu

- $table->softDeletes() = ini untuk auto membuat deleted_at, saat kita menggunakan soft delete, kita harus import SoftDeletes pada model. softdelete ini akan merubah fungsi delete() menjadi update data dari field deleted_at. dan jika kita ingin menghapusnya secara permanen maka harus menggunakan forceDelete(). jika ingin mengambil data yang sudah di soft delete, gunakan withTrashed() sebelum query

- GlobalScope = membuatnya dengan perintah make:scope NamaScope, pengisiannya bisa di lihat di Models/Scopes/NamaScope.php, setelah itu kita jangan lupa mengimport GlobalScope nya di method boot() pada model dengan cara use App\Models\Scopes\NamaScope;, setelah itu kita tinggal menambahkan nama methodnya di querynya, misal query()->namaScope(), dan GlobalScope ini akan otomatis jalan setiap kali model tersebut diakses. jika kita tidak ingin menggunakannya, bisa gunakan withoutGlobalScope(NamaScope::class) sebelum melakukan query

- LocalScope = di buat langsung di Modelnya dengan Builder, cara membuatnya bisa dilihat di Model Voucher,dan jangan lupa import use Illuminate\Database\Eloquent\Builder; pada modelnya. cara menggunakanyanya, di controller tinggal menambahkan nama methodnya di querynya, misal query()->namaScope(), gunakan prefixnya saja dan menggunakan lowercase.