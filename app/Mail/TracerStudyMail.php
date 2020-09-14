<?php

namespace App\Mail;

use App\Models\TracerStudy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TracerStudyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tracerStudy;

    public function __construct(TracerStudy $tracerStudy)
    {
        $this->tracerStudy = $tracerStudy;
    }

    public function build()
    {
        return $this->markdown('email.pengisian');
    }
}
