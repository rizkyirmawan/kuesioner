<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@index')->name('/');
Route::post('/', 'AuthController@login');

Route::middleware(['auth'])->group(function() {

	Route::get('dasbor', 'DasborController@index')->name('dasbor');

	Route::middleware(['isAdmin'])->group(function() {
		
		Route::prefix('users')->group(function() {
			// Mahasiswa Routes
			Route::get('mahasiswa', 'MahasiswaController@index')->name('mahasiswa.index');
			Route::get('mahasiswa/create', 'MahasiswaController@create')->name('mahasiswa.create');
			Route::post('mahasiswa/create', 'MahasiswaController@store')->name('mahasiswa.store');
			Route::get('mahasiswa/{mahasiswa}', 'MahasiswaController@show')->name('mahasiswa.show');
			Route::get('mahasiswa/{mahasiswa}/edit', 'MahasiswaController@edit')->name('mahasiswa.edit');
			Route::patch('mahasiswa/{mahasiswa}', 'MahasiswaController@update')->name('mahasiswa.update');
			Route::delete('mahasiswa/{mahasiswa}', 'MahasiswaController@destroy')->name('mahasiswa.destroy');

			// Mahasiswa API
			Route::get('mahasiswa/data/matkul/{matkul}', 'MahasiswaController@mahasiswaAttached');
			Route::get('mahasiswa/data/{kelas}', 'MahasiswaController@mahasiswaByKelas');
			Route::get('mahasiswa/data/{kelas}/{jurusan}', 'MahasiswaController@mahasiswaByJurusan');
			Route::get('mahasiswa/data/{kelas}/{jurusan}/{angkatan}', 'MahasiswaController@mahasiswaByAngkatan');

			// Dosen Routes
			Route::get('dosen', 'DosenController@index')->name('dosen.index');
			Route::get('dosen/create', 'DosenController@create')->name('dosen.create');
			Route::post('dosen/create', 'DosenController@store')->name('dosen.store');
			Route::get('dosen/{dosen}', 'DosenController@show')->name('dosen.show');
			Route::get('dosen/{dosen}/edit', 'DosenController@edit')->name('dosen.edit');
			Route::patch('dosen/{dosen}', 'DosenController@update')->name('dosen.update');
			Route::delete('dosen/{dosen}', 'DosenController@destroy')->name('dosen.destroy');
		});

		Route::prefix('master')->group(function() {
			// Matkul Routes
			Route::get('mata-kuliah', 'MatkulController@index')->name('matkul.index');
			Route::get('mata-kuliah/create', 'MatkulController@create')->name('matkul.create');
			Route::post('mata-kuliah/create', 'MatkulController@store')->name('matkul.store');
			Route::get('mata-kuliah/{mataKuliah:kode}', 'MatkulController@show')->name('matkul.show');
			Route::get('mata-kuliah/{mataKuliah:kode}/edit', 'MatkulController@edit')->name('matkul.edit');
			Route::patch('mata-kuliah/{mataKuliah:kode}', 'MatkulController@update')->name('matkul.update');
			Route::delete('mata-kuliah/{mataKuliah:kode}', 'MatkulController@destroy')->name('matkul.destroy');
			Route::post('mata-kuliah/{mataKuliah:kode}', 'MatkulController@storeStudi')->name('matkul.studi');
			Route::patch('mata-kuliah/{mataKuliah:kode}/{studi}', 'MatkulController@updateStudi')->name('matkul.studi.update');
			Route::delete('mata-kuliah/{mataKuliah:kode}/{studi}', 'MatkulController@destroyStudi')->name('matkul.studi.destroy');
			Route::get('mata-kuliah/{mataKuliah:kode}/peserta-didik', 'MatkulController@pesertaDidik')->name('matkul.peserta');
			Route::post('mata-kuliah/{mataKuliah:kode}/peserta-didik', 'MatkulController@storePeserta')->name('matkul.peserta.store');

			// Kelas Routes
			Route::get('kelas', 'KelasController@index')->name('kelas.index');
			Route::get('kelas/create', 'KelasController@create')->name('kelas.create');
			Route::post('kelas/create', 'KelasController@store')->name('kelas.store');
			Route::get('kelas/{kelas}', 'KelasController@show')->name('kelas.show');
			Route::get('kelas/{kelas}/edit', 'KelasController@edit')->name('kelas.edit');
			Route::patch('kelas/{kelas}', 'KelasController@update')->name('kelas.update');
			Route::delete('kelas/{kelas}', 'KelasController@destroy')->name('kelas.destroy');

			// Tahun Ajaran Routes
			Route::get('tahun-ajaran', 'TahunAjaranController@index')->name('tahunAjaran.index');
			Route::get('tahun-ajaran/create', 'TahunAjaranController@create')->name('tahunAjaran.create');
			Route::post('tahun-ajaran/create', 'TahunAjaranController@store')->name('tahunAjaran.store');
			Route::patch('tahun-ajaran/{tahunAjaran}', 'TahunAjaranController@activate')->name('tahunAjaran.activate');
			Route::delete('tahun-ajaran/{tahunAjaran}', 'TahunAjaranController@destroy')->name('tahunAjaran.destroy');

			// Matkul API
			Route::get('mata-kuliah/{mataKuliah}/jurusan', 'MatkulController@getJurusan');

			// Import KRS
			Route::post('mata-kuliah', 'MatkulController@importKRS')->name('matkul.import');
		});

		Route::prefix('kuesioner')->group(function () {
			// Kuesioner Pembelajaran Routes
			Route::get('pembelajaran', 'PembelajaranController@index')->name('pembelajaran.index');
			Route::get('pembelajaran/create', 'PembelajaranController@create')->name('pembelajaran.create');
			Route::post('pembelajaran/create', 'PembelajaranController@store')->name('pembelajaran.store');
			Route::get('pembelajaran/{pembelajaran}', 'PembelajaranController@show')->name('pembelajaran.show');
			Route::get('pembelajaran/{pembelajaran}/edit', 'PembelajaranController@edit')->name('pembelajaran.edit');
			Route::patch('pembelajaran/{pembelajaran}', 'PembelajaranController@update')->name('pembelajaran.update');
			Route::delete('pembelajaran/{pembelajaran}', 'PembelajaranController@destroy')->name('pembelajaran.destroy');

			// Pertanyaan Pembelajaran Routes
			Route::post('pembelajaran/{pembelajaran}', 'PertanyaanController@storePembelajaranDefault')->name('pembelajaran.default.create');
			Route::get('pembelajaran/{pembelajaran}/pertanyaan/create', 'PertanyaanController@createPembelajaran')->name('pertanyaan.pembelajaran.create');
			Route::post('pembelajaran/{pembelajaran}/pertanyaan', 'PertanyaanController@storePembelajaran')->name('pertanyaan.pembelajaran.store');
			Route::patch('pembelajaran/{pembelajaran}/pertanyaan/{pertanyaan}', 'PertanyaanController@updatePembelajaran')->name('pertanyaan.pembelajaran.update');
			Route::delete('pembelajaran/{pembelajaran}/pertanyaan/{pertanyaan}', 'PertanyaanController@destroyPembelajaran')->name('pertanyaan.pembelajaran.destroy');
		});

	});

	Route::prefix('kuesioner')->group(function () {
		// Pembelajaran Respon
		Route::get('dosen/pembelajaran', 'PembelajaranController@indexDosen')->name('dosen.pembelajaran.index');
		Route::get('dosen/pembelajaran/{pembelajaran}/respons', 'PembelajaranController@showRespons')->name('pembelajaran.respons');
	});

	// Pengisian Kuesioner Pembelajaran Routes
	Route::get('mahasiswa/kuesioner/pembelajaran', 'SurveyController@getPembelajaran')->name('mahasiswa.pembelajaran');
	Route::get('mahasiswa/kuesioner/pembelajaran/{pembelajaran}', 'SurveyController@showPembelajaran')->name('mahasiswa.pembelajaran.show');
	Route::post('mahasiswa/kuesioner/pembelajaran/{pembelajaran}', 'SurveyController@storePembelajaran')->name('mahasiswa.pembelajaran.store');
	
	Route::post('/logout', 'AuthController@logout');
});
