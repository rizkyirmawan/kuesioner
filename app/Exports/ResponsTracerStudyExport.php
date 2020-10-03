<?php

namespace App\Exports;

use App\Models\TracerStudy;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ResponsTracerStudyExport implements FromView, ShouldAutoSize
{
	protected $tracerStudy;

	function __construct(TracerStudy $tracerStudy)
	{
		$this->tracerStudy = $tracerStudy;
	}

    public function view(): View
    {
    	$tracerStudy = $this->tracerStudy;

        return view('exports.responsTracerStudy', compact('tracerStudy'));
    }
}
