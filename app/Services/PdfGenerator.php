<?php

namespace App\Services;

use App\Models\ReceptionForm;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerator
{
    public function generateReceptionFormPdf(ReceptionForm $form)
    {
        $pdf = PDF::loadView('pdf.reception-form', [
            'form' => $form,
            'items' => $form->items()->get()->groupBy('category')
        ]);

        $filename = 'reception_form_' . $form->id . '_' . now()->format('Y-m-d_His') . '.pdf';
        $path = 'pdfs/' . $filename;
        
        // Sauvegarde le PDF dans le storage
        $pdf->save(storage_path('app/public/' . $path));
        
        return $path;
    }
}
