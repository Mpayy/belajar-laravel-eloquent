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
