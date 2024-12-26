<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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

    public function __construct($data)
    {
        $this->userName = $data['userName'];
        $this->date = $data['date'];
        $this->totalItems = $data['totalItems'];
        $this->presentItems = $data['presentItems'];
        $this->missingItems = $data['missingItems'];
        $this->itemsWithComments = $data['itemsWithComments'];
        $this->categorizedItems = $data['categorizedItems'];
    }

    public function build()
    {
        return $this->subject('Rapport de Vérification Matériel G05')
                    ->view('emails.checklist-report');
    }
}
