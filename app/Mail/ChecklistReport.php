<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ChecklistReport extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfContent;
    public $checklistData;

    public function __construct($pdfContent, $checklistData)
    {
        $this->pdfContent = $pdfContent;
        $this->checklistData = $checklistData;
    }

    public function build()
    {
        return $this->subject('Checklist Reception Machine - ' . $this->checklistData['project'])
                    ->view('emails.checklist-report')
                    ->attachData($this->pdfContent, 'checklist_report.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
