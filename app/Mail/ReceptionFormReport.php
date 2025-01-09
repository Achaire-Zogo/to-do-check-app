<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReceptionFormReport extends Mailable
{
    use Queueable, SerializesModels;

    public $reportData;
    public $commentArray;
    public $pdfPath;

    public function __construct($reportData, $commentArray, $pdfPath)
    {
        $this->reportData = $reportData;
        $this->commentArray = $commentArray;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('emails.reception-form-report')
                    ->subject('Reception Form Report')
                    ->attach($this->pdfPath);
    }
}
