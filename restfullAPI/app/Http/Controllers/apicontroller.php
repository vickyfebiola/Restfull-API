<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mMahasiswa;

class apicontroller extends Controller
{
    // untuk mendaptkan data dari database
    public function get_data(){
    	return response()->json(mMahasiswa::all(),200);
    }

    // insert data
    public function insert_data_mahasiswa(Request $request){
    	$insert_mahasiswa = new mMahasiswa;
    	$insert_mahasiswa->nama = $request->namaMahasiwa;
    	$insert_mahasiswa->prodi = $request->prodiMahasiwa;
    	$insert_mahasiswa->save();
    	return response([
    		'status' => 'OK',
    		'message' => 'Data Tersimpan',
    		'data' => $insert_mahasiswa
    	], 200);
    }

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
	
}
