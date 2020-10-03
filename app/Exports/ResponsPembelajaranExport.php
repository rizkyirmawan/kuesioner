<?php

namespace App\Exports;

use App\Models\Pembelajaran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResponsPembelajaranExport implements FromView, ShouldAutoSize
{
	protected $pembelajaran;

	function __construct(Pembelajaran $pembelajaran)
	{
		$this->pembelajaran = $pembelajaran;
	}

    public function view(): View
    {
    	$pembelajaran = $this->pembelajaran;

        return view('exports.responsPembelajaran', compact('pembelajaran'));
    }
}
