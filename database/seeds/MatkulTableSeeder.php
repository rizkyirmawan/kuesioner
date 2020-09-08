<?php

use App\Models\Jurusan;
use App\Models\Matkul;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class MatkulTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jurusanIF = Jurusan::where('kode', 'IF')->first();

        $jurusanSI = Jurusan::where('kode', 'SI')->first();

        $data = [
        	['kode' => 'IF1406', 'mata_kuliah' => 'RPL Berbasis Objek'],
        	['kode' => 'KD1413', 'mata_kuliah' => 'Model dan Simulasi'],
        	['kode' => 'KD1617', 'mata_kuliah' => 'Pengujian Perangkat Lunak'],
        	['kode' => 'KD1618', 'mata_kuliah' => 'Sistem Pengamanan Komputer'],
        	['kode' => 'KD1821', 'mata_kuliah' => 'Kapita Selekta'],
        	['kode' => 'KU1814', 'mata_kuliah' => 'Kewarganegaraan'],
        	['kode' => 'SI1019', 'mata_kuliah' => 'Data Mining'],
        	['kode' => 'IF1101', 'mata_kuliah' => 'Fisika 1'],
        	['kode' => 'IF1200', 'mata_kuliah' => 'Mini Project 1'],
        	['kode' => 'IF1202', 'mata_kuliah' => 'Fisika 2'],
        	['kode' => 'IF1203', 'mata_kuliah' => 'Arsitektur dan Organisasi Komputer'],
        	['kode' => 'IF1304', 'mata_kuliah' => 'Pemrograman 3 (Java)'],
        	['kode' => 'IF1405', 'mata_kuliah' => 'Kalkulus Lanjut'],
        	['kode' => 'IF1407', 'mata_kuliah' => 'Pemrograman 4 (WEB Framework & XML)'],
        	['kode' => 'IF1508', 'mata_kuliah' => 'Analisis Numerik'],
        	['kode' => 'IF1509', 'mata_kuliah' => 'Teori Bahasa dan Otomata'],
        	['kode' => 'IF1510', 'mata_kuliah' => 'Pemrograman 5 (Java Desktop Framework)'],
        	['kode' => 'IF1713', 'mata_kuliah' => 'Intelegensi Buatan'],
        	['kode' => 'IF1714', 'mata_kuliah' => 'Grafika Komputer'],
        	['kode' => 'KD1101', 'mata_kuliah' => 'Algoritma (Problem Solving)'],
        	['kode' => 'KD1102', 'mata_kuliah' => 'Pemrograman 1 (Bahasa C)'],
        	['kode' => 'KD1103', 'mata_kuliah' => 'Konsep Teknologi Informasi'],
        	['kode' => 'KD1104', 'mata_kuliah' => 'Paket Aplikasi (Macro, VBA)'],
        	['kode' => 'KD1205', 'mata_kuliah' => 'Struktur Data'],
        	['kode' => 'KD1206', 'mata_kuliah' => 'Pemrograman 2 (Web Design)'],
        	['kode' => 'KD1307', 'mata_kuliah' => 'Matematika Diskrit'],
        	['kode' => 'KD1308', 'mata_kuliah' => 'Sistem Informasi Manajemen'],
        	['kode' => 'KD1309', 'mata_kuliah' => 'Sistem Operasi'],
        	['kode' => 'KD1310', 'mata_kuliah' => 'Rekayasa Perangkat Lunak (SDLC + Template)'],
        	['kode' => 'KD1411', 'mata_kuliah' => 'Perancangan Basis Data'],
        	['kode' => 'KD1412', 'mata_kuliah' => 'Komunikasi Data dan Jaringan'],
        	['kode' => 'KD1514', 'mata_kuliah' => 'Interaksi Manusia dan Komputer'],
        	['kode' => 'KD1515', 'mata_kuliah' => 'Sistem Basis Data (PostGreSQL)'],
        	['kode' => 'KD1720', 'mata_kuliah' => 'Manajemen Proyek Teknologi Informasi'],
        	['kode' => 'KU1101', 'mata_kuliah' => 'Matematika'],
        	['kode' => 'KU1102', 'mata_kuliah' => 'Manajemen dan Perilaku Organisasi'],
        	['kode' => 'KU1203', 'mata_kuliah' => 'Bahasa Inggris 1 (Reading)'],
        	['kode' => 'KU1204', 'mata_kuliah' => 'Aljabar Linier'],
        	['kode' => 'KU1205', 'mata_kuliah' => 'Pancasila'],
        	['kode' => 'KU1306', 'mata_kuliah' => 'Statistik'],
        	['kode' => 'KU1307', 'mata_kuliah' => 'Bahasa Inggris 2 (Writing)'],
        	['kode' => 'KU1408', 'mata_kuliah' => 'Agama (Etika)'],
        	['kode' => 'KU1509', 'mata_kuliah' => 'Bahasa Indonesia'],
        	['kode' => 'KU1510', 'mata_kuliah' => 'Interpersonal Skill'],
        	['kode' => 'KU1511', 'mata_kuliah' => 'Kewirausahaan 1'],
        	['kode' => 'KU1612', 'mata_kuliah' => 'Kewirausahaan 2'],
        	['kode' => 'IF1400', 'mata_kuliah' => 'Mini Project 2'],
        	['kode' => 'IF1443', 'mata_kuliah' => 'Data Mining'],
        	['kode' => 'IF1611', 'mata_kuliah' => 'Pemrograman 6 (Mobile Programming)'],
        	['kode' => 'IF1712', 'mata_kuliah' => 'Analisis Algoritma'],
        	['kode' => 'KD1616', 'mata_kuliah' => 'Riset Operasi'],
        	['kode' => 'KD1619', 'mata_kuliah' => 'Multimedia'],
        	['kode' => 'KU1813', 'mata_kuliah' => 'HAKI & Etika Profesi'],
        	['kode' => 'SI1412', 'mata_kuliah' => 'Perencanaan Strategis Sistem Informasi'],
        	['kode' => 'SI1427', 'mata_kuliah' => 'Audit Teknologi Informasi'],
        	['kode' => 'SI1428', 'mata_kuliah' => 'Statistik Stokastik'],
        	['kode' => 'IF1600', 'mata_kuliah' => 'Kerja Praktek'],
        	['kode' => 'SI1426', 'mata_kuliah' => 'Proses Bisnis'],
        	['kode' => 'IF1201', 'mata_kuliah' => 'Pemrograman 3'],
        	['kode' => 'KD1203', 'mata_kuliah' => 'Sistem Operasi'],
        	['kode' => 'KD1204', 'mata_kuliah' => 'Matematika Diskrit'],
        	['kode' => 'KD1207', 'mata_kuliah' => 'Komunikasi Data dan Jaringan'],
        	['kode' => 'KD1303', 'mata_kuliah' => 'Sistem Basis Data'],
        	['kode' => 'KD1401', 'mata_kuliah' => 'Manajemen Proyek Teknologi Informas'],
        	['kode' => 'KU1104', 'mata_kuliah' => 'Bahasa Inggris'],
        	['kode' => 'KU1105', 'mata_kuliah' => 'Aljabar Linier'],
        	['kode' => 'KU1201', 'mata_kuliah' => 'Statistik'],
        	['kode' => 'KU1202', 'mata_kuliah' => 'English Communications'],
        	['kode' => 'KU1301', 'mata_kuliah' => 'Tata Tulis Karya Ilmiah'],
        	['kode' => 'SI1411', 'mata_kuliah' => 'Analisis dan Perancangan Sistem Informasi 2'],
        	['kode' => 'IF1102', 'mata_kuliah' => 'Arsitektur dan Organisasi Komputer'],
        	['kode' => 'IF1202', 'mata_kuliah' => 'Kalkulus Lanjut'],
        	['kode' => 'IF1301', 'mata_kuliah' => 'Rekayasa Perangkat Lunak'],
        	['kode' => 'IF1302', 'mata_kuliah' => 'Analisis Numerik'],
        	['kode' => 'IF1303', 'mata_kuliah' => 'Teori Bahasa dan Otomata'],
        	['kode' => 'IF1411', 'mata_kuliah' => 'Analisis Algoritma'],
        	['kode' => 'IF1414', 'mata_kuliah' => 'Grafika Komputer'],
        	['kode' => 'IF1422', 'mata_kuliah' => 'Sistem Robotik'],
        	['kode' => 'KD1105', 'mata_kuliah' => 'Struktur Data'],
        	['kode' => 'KD1106', 'mata_kuliah' => 'Pemrograman 2'],
        	['kode' => 'KD1208', 'mata_kuliah' => 'Model dan Simulasi'],
        	['kode' => 'KD1302', 'mata_kuliah' => 'Pemrograman 5'],
        	['kode' => 'KD1304', 'mata_kuliah' => 'Riset Operasi'],
        	['kode' => 'KD1305', 'mata_kuliah' => 'Pemrograman 6'],
        	['kode' => 'KD1306', 'mata_kuliah' => 'Pengujian Perangkat Lunak'],
        	['kode' => 'KD1403', 'mata_kuliah' => 'Kapita Selekta'],
        	['kode' => 'KU1103', 'mata_kuliah' => 'Kewarganegaraan'],
        	['kode' => 'KU1204', 'mata_kuliah' => 'Manajemen Komunikasi'],
        	['kode' => 'KU1303', 'mata_kuliah' => 'Kewirausahaan'],
        	['kode' => 'KU1400', 'mata_kuliah' => 'Wawasan Kebangsaan'],
        	['kode' => 'KU1401', 'mata_kuliah' => 'Etika Profesi'],
        	['kode' => 'SI1414', 'mata_kuliah' => 'Sistem Pendukung Keputusan'],
        	['kode' => 'SI1414', 'mata_kuliah' => 'Sistem Pendukung Keputusan & Intelijensia Bisnis'],
        	['kode' => 'IF1203', 'mata_kuliah' => 'Pemrograman 4'],
        	['kode' => 'IF1412', 'mata_kuliah' => 'Metodologi Berorientasi Objek'],
        	['kode' => 'IF1424', 'mata_kuliah' => 'Jaringan Komputer Lanjut'],
        	['kode' => 'KD1201', 'mata_kuliah' => 'Logika Matematika'],
        	['kode' => 'KD1202', 'mata_kuliah' => 'Sistem Informasi Manajemen'],
        	['kode' => 'KD1301', 'mata_kuliah' => 'Interaksi Manusia dan Komputer'],
        	['kode' => 'SI1300', 'mata_kuliah' => 'Kerja Praktek'],
        	['kode' => 'SI1424', 'mata_kuliah' => 'Basisdata Terdistribusi'],
        	['kode' => 'IF1800', 'mata_kuliah' => 'Skripsi']
        ];

        foreach ($data as $matkul) {
        	if (Str::substr($matkul['kode'], 0, 2) == 'IF') {
        		$jurusan = [$jurusanIF->id];
        	} elseif (Str::substr($matkul['kode'], 0, 2) == 'SI') {
        		$jurusan = [$jurusanSI->id];
        	} else {
        		$jurusan = [$jurusanIF->id, $jurusanSI->id];
        	}

        	$mk = Matkul::create($matkul);
        	$mk->jurusan()->sync($jurusan);
        }
    }
}
