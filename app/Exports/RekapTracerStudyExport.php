<?php

namespace App\Exports;

use App\Models\Identitas;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekapTracerStudyExport implements FromView, ShouldAutoSize
{
	protected $identitas;

	function __construct(Identitas $identitas)
	{
		$this->identitas = $identitas;
	}

    public function view(): View
    {
        $identitas = $this->identitas;

        return view('exports.rekapTracerStudy', compact('identitas'));
    }
}
