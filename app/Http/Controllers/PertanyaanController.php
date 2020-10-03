<?php

namespace App\Http\Controllers;

use App\Models\Kemahasiswaan;
use App\Models\Pembelajaran;
use App\Models\Pertanyaan;
use App\Http\Requests\PertanyaanRequest;

class PertanyaanController extends Controller
{
	// Create Pembelajaran
    public function createPembelajaran(Pembelajaran $pembelajaran)
    {
    	$title = 'Tambah Pertanyaan';

    	return view('pertanyaan.pembelajaran.create', compact('title', 'pembelajaran'));
    }

    // Store Pembelajaran
    public function storePembelajaran(PertanyaanRequest $request, Pembelajaran $pembelajaran)
    {
    	$pertanyaan = $pembelajaran
    					->pertanyaan()
    					->create($request->only('pertanyaan', 'tipe'));

    	if ($request->jawaban) {
	    	$pertanyaan->jawaban()->createMany($request->jawaban);
    	}

    	return redirect()
    			->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
    			->with('success', 'Pertanyaan berhasil ditambah.');
    }

    // Update Pembelajaran
    public function updatePembelajaran(Pembelajaran $pembelajaran, Pertanyaan $pertanyaan)
    {
        $pertanyaan->update(request()->only('pertanyaan'));

        return redirect()
                ->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
                ->with('success', 'Pertanyaan berhasil diubah.');
    }

    // Delete Pembelajaran
    public function destroyPembelajaran(Pembelajaran $pembelajaran, Pertanyaan $pertanyaan)
    {
        $pertanyaan->jawaban()->delete();

        $pertanyaan->respons()->delete();

        $pertanyaan->delete();

        return redirect()
                ->route('pembelajaran.show', ['pembelajaran' => $pembelajaran])
                ->with('success', 'Pertanyaan berhasil dihapus.');   
    }

    // Create Kemahasiswaan
    public function createKemahasiswaan(Kemahasiswaan $kemahasiswaan)
    {
        $title = 'Tambah Pertanyaan';

        return view('pertanyaan.kemahasiswaan.create', compact('title', 'kemahasiswaan'));
    }

    // Store Kemahasiswaan
    public function storeKemahasiswaan(PertanyaanRequest $request, Kemahasiswaan $kemahasiswaan)
    {
        $pertanyaan = $kemahasiswaan
                        ->pertanyaan()
                        ->create($request->only('pertanyaan', 'tipe'));

        if ($request->jawaban) {
            $pertanyaan->jawaban()->createMany($request->jawaban);
        }

        return redirect()
                ->route('kemahasiswaan.show', ['kemahasiswaan' => $kemahasiswaan])
                ->with('success', 'Pertanyaan berhasil ditambah.');
    }

    // Update Kemahasiswaan
    public function updateKemahasiswaan(Kemahasiswaan $kemahasiswaan, Pertanyaan $pertanyaan)
    {
        $pertanyaan->update(request()->only('pertanyaan'));

        return redirect()
                ->route('kemahasiswaan.show', ['kemahasiswaan' => $kemahasiswaan])
                ->with('success', 'Pertanyaan berhasil diubah.');
    }

    // Delete Kemahasiswaan
    public function destroyKemahasiswaan(Kemahasiswaan $kemahasiswaan, Pertanyaan $pertanyaan)
    {
        $pertanyaan->jawaban()->delete();

        $pertanyaan->respons()->delete();

        $pertanyaan->delete();

        return redirect()
                ->route('kemahasiswaan.show', ['kemahasiswaan' => $kemahasiswaan])
                ->with('success', 'Pertanyaan berhasil dihapus.');   
    }
}
