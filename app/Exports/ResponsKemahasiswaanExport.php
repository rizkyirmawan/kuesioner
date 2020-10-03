<?php

namespace App\Exports;

use App\Models\Kemahasiswaan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResponsKemahasiswaanExport implements FromView, ShouldAutoSize
{
	protected $kemahasiswaan;

	function __construct(Kemahasiswaan $kemahasiswaan)
	{
		$this->kemahasiswaan = $kemahasiswaan;
	}

    public function view(): View
    {
    	$kemahasiswaan = $this->kemahasiswaan;

        return view('exports.responsKemahasiswaan', compact('kemahasiswaan'));
    }
}
