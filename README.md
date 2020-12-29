# Restfull-API with Laravel
Repository ini merupakan contoh program RESTfull API pada Laravel

## Tools:
1. Xampp
2. Composer
3. Laravel
4. Kode editor
5. Postman ataupun aplikasi SOAP dan REST lainnya
## Membuat project baru menggunakan laravel
Untuk membuat project baru, buka command prompt lalu arahkan ke direktori xampp/htdocs/namafolder. Jika sudah, ketikan kode berikut:
```
composer create-project –prefer-dist Laravel/Laravel nama_direktori_project
```
atau
```
composer create-project --prefer-dist laravel/laravel:^7.0 namaproject
```
## Membuat database baru
Aktifkan xampp terlebih dahulu, kemudian buat database baru anda.
## Atur database
Buka folder projek Laravel anda, lalu terdapat file dengan nama .env, buka file .env menggunakan kode editor kemudian edit sesuai database yang sudah dibuat:
```
DB_DATABASE = 'mahasiswa'
```
## Membuat file migrasi
Buka command prompt, lalu ketikkan kode berikut:
```
php artisan make:migration create_mahasiswa
```
Jika sudah, buka project anda lalu buka folder database -> migration -> buka file yang baru saja dibuat. Lalu edit seperti berikut:
```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->bigIncrements('nim');
            $table->string('nama');
            $table->string('prodi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa');
    }
}
```
Kemudian kembali ke command prompt dan ketik kode berikut:
```
php artisan migrate
```
Jika berhasil maka database mahasiswa akan terupdate sesuai dengan yang sudah dibuat.
## Membuat Controller
Sebagai contoh, untuk membuat controller ketik kode berikut pada command prompt:
```
php artisan make:controller apicontroller
```
File controller dapat di akses dengan membuka folder app -> Http -> Controllers
## Membuat model
Contoh pembuatan model, ketik kode berikut pada command prompt:
```
php artisan make:model mMahasiswa
```
File controller dapat di akses dengan membuka folder app.
Jika sudah, buka file model yang baru dibuat lalu edit seperti berikut:
```
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mMahasiswa extends Model
{
    // nama tabel
    protected $table = 'mahasiswa';

    // PK
    protected $primaryKey = 'nim';
}
```
## Membuat Restfull API
### 1. GET
Buka file apicontroller, kemudian tambahkan kode berikut agar dapat mengakses model:
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mMahasiswa;
```
Selanjutnya, buat method function untuk mengambil data dari database. Ketik kode berikut:
```
// untuk mendaptkan data dari database
public function get_data(){
  return response()->json(mMahasiswa::all(),200);
}
```
Kemudian buat url. Buka folder routes -> api.php lalu tambahkan kode berikut:
```
// menggunakan method get untuk akses url dan apicontroller dan menjalankannya (read data)
Route::get('mahasiswa', 'apicontroller@get_data')
```
Jalankan local server Laravel dengan mengetikkan kode berikut:
```
php artisan serve
```
Jika sudah buka browser dan arahkan menuju url localserver tersebut ditambah dengan url dari route yaitu /api dan tambahkan route yang kalian buat. Contohnya seperti ini:
```
127.0.0.1:8000/api/mahasiswa
```
Jika berhasil maka akan muncul data array yang berhasil diakses dari database.
### 2. POST
Buat function pada apicontroller untuk melakukan action post. Berikut kodenya:
```
// insert data
    public function insert_data_mahasiswa(Request $request){
    	$insert_mahasiswa = new mMahasiswa;

    	$insert_mahasiswa->nim = $request->nimMahasiwa;
    	$insert_mahasiswa->nama = $request->namaMahasiwa;
    	$insert_mahasiswa->prodi = $request->prodiMahasiwa;
    	$insert_mahasiswa->save();
    	return response([
    		'status' => 'OK',
    		'message' => 'Data Tersimpan',
    		'data' => $insert_mahasiswa
    	], 200);
    }
```
Kemudian tambahkan url. Buka folder routes -> api.php dan tambahkan kode berikut:
```
// menggunakan method post untuk insert data
Route::post('mahasiswa/insert_mahasiswa', 'apicontroller@insert_data_mahasiswa')
```
Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.
Buka postman, lalu pilih method POST dan masukkan url anda, seperti berikut:
```
http://127.0.0.1:8000/api/mahasiswa/insert_mahasiswa
```
### 3. PUT
Buat function pada apicontroller untuk melakukan action put. Berikut kodenya:
```
// update data
	public function update_data_mahasiswa(Request $request, $nim){
		// mengecek data yang akan di update berdasarkan nim ada atau tidak
		$check_mahasiswa = mMahasiswa::firstWhere('nim', $nim);
		if($check_mahasiswa){
			$data_mahasiswa = mMahasiswa::find($nim);
			$data_mahasiswa->nama = $request->namaMahasiwa;
			$data_mahasiswa->prodi = $request->prodiMahasiwa;
			$data_mahasiswa->save();
			return response([
				'status' => 'OK',
	    		'message' => 'Data Berhasil di Update',
	    		'data' => $data_mahasiswa
	    	], 200);

		} else {
			return response([
				'status' => 'Not Found',
	    		'message' => 'NIM tidak ditemukan'
	    	], 404);
		}
	}
 ``` 
Kemudian tambahkan url. Buka folder routes -> api.php dan tambahkan kode berikut:
```
// menggunakan put untuk update data
Route::put('/mahasiswa/update/{nim}', 'apicontroller@update_data_mahasiswa');
```
Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.
Buka postman, lalu pilih method PUT dan masukkan url anda, seperti contoh berikut akan mengupdate kode nim nomor 8:
```
http://127.0.0.1:8000/api/mahasiswa/update/8
```
### 4. DELETE
Buat function pada apicontroller untuk melakukan action put. Berikut kodenya:
```
// delete data
	public function delete_data_mahasiswa($nim){
		// mengecek data yang akan dihapus berdasarkan nim ada atau tidak
		$check_mahasiswa = mMahasiswa::firstWhere('nim', $nim);
		if($check_mahasiswa){
			mMahasiswa::destroy($nim);
			return response([
				'status' => 'OK',
	    		'message' => 'Data Berhasil di Hapus',
	    		'data' => $data_mahasiswa
	    	], 200);

		} else {
			return response([
				'status' => 'Not Found',
	    		'message' => 'NIM tidak ditemukan'
	    	], 404);
		}
	}
```  
Kemudian tambahkan url. Buka folder routes -> api.php dan tambahkan kode berikut:
```
// untuk hapus data
Route::delete('/mahasiswa/delete/{nim}', 'apicontroller@delete_data_mahasiswa');
```
Terakhir, untuk menguji fungsi tersebut, kita perlu menggunakan Postman.
Buka postman, lalu pilih method DELETE dan masukkan url anda, seperti contoh berikut akan menghapusb kode nim nomor 8:
```
http://127.0.0.1:8000/api/mahasiswa/delete/8
```
