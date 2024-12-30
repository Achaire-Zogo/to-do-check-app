<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ChecklistReport extends Mailable
{
    use Queueable, SerializesModels;

    public $userName;
    public $date;
    public $totalItems;
    public $presentItems;
    public $missingItems;
    public $itemsWithComments;
    public $categorizedItems;
    public $commentAr;
    public $pdfPath;
    public $machineName;

    public function __construct($data, $cmtAr,$pdfpath)
    {
        $this->userName = $data['userName'];
        $this->date = $data['date'];
        $this->totalItems = $data['totalItems'];
        $this->presentItems = $data['presentItems'];
        $this->missingItems = $data['missingItems'];
        $this->itemsWithComments = $data['itemsWithComments'];
        $this->machineName = $data['machineName'];
        $this->categorizedItems = $data['categorizedItems'];
        $this->commentAr = $cmtAr;
        $this->pdfPath = $pdfpath;
    }

    public function build()
    {
        return $this->subject('Rapport de Vérification Matériel G05')
                    ->view('emails.checklist-report')
                    ->attach($this->pdfPath, [
                        'as' => 'checklist_report.pdf',
                        'mime' => 'application/pdf',
                    ])
                    ;
    }
}
