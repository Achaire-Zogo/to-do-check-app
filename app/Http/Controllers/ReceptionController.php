<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ReceptionForm;
use App\Models\ReceptionItem;
use App\Services\PdfGenerator;
use App\Mail\ReceptionFormReport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ReceptionController extends Controller
{
    protected $armoires_items = [
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A1',
            'description' => 'Vérification visuelle de l\'armoire A1',
            'is_present' => true
        ],
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A2',
            'description' => 'Vérification visuelle de l\'armoire A2',
            'is_present' => true
        ],
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A3',
            'description' => 'Vérification visuelle de l\'armoire A3',
            'is_present' => true
        ],
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A4 (Optionnelle)',
            'description' => 'Vérification visuelle de l\'armoire A4',
            'is_present' => false
        ]
    ];

    protected $hmi_items = [
        [
            'category' => 'HMI',
            'name' => 'sachet fournisseur avec 2 peignes',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'HMI',
            'name' => 'câble USB pour HMI et télécommande écrans ELO',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'HMI',
            'name' => 'clef pour sélecteur de protection à mettre sur sélecteur',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'HMI',
            'name' => 'à jeter: câble HDMI et VGA',
            'description' => '',
            'is_present' => false
        ]
    ];

    protected $chaine_hmi_items = [
        [
            'category' => 'Chaine HMI',
            'name' => 'Chaine HMI, vérification position reprise de blindage',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Chaine HMI',
            'name' => 'Câble HM1+OP1-W5',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Chaine HMI',
            'name' => 'Câble HM1+OP1-W7',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Chaine HMI',
            'name' => 'Câble HM1.+OP1-P1-W3',
            'description' => '',
            'is_present' => false
        ]
    ];

    protected $carton_items = [
        [
            'category' => 'Carton fournisseur',
            'name' => 'Set de fil HMI',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Carton fournisseur',
            'name' => 'Set de câble de terre',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Carton fournisseur',
            'name' => 'Documentation PC',
            'description' => '',
            'is_present' => false
        ]
    ];

    protected $verine_items = [
        [
            'category' => 'Vérine',
            'name' => 'Vérine rouge jaune et vert avec les leds (et bleu)',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Vérine',
            'name' => 'Tube pour vérine',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Vérine',
            'name' => 'pied pour tube',
            'description' => '',
            'is_present' => false
        ],
        [
            'category' => 'Vérine',
            'name' => 'embase vérine avec couvercle',
            'description' => '',
            'is_present' => false
        ]
    ];

    public function index()
    {
        $allItems = array_merge(
            $this->armoires_items,
            $this->hmi_items,
            $this->chaine_hmi_items,
            $this->carton_items,
            $this->verine_items
        );

        // Grouper les items par catégorie
        $groupedItems = [];
        foreach ($allItems as $item) {
            $category = $item['category'];
            if (!isset($groupedItems[$category])) {
                $groupedItems[$category] = [];
            }
            $groupedItems[$category][] = $item;
        }

        return view('reception.index', [
            'title' => 'Checklist de réception',
            'items' => $groupedItems
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validate form data
            $validatedData = $request->validate([
                'project' => 'required|string',
                'check_date' => 'required|date',
                'stamp_number' => 'required|string',
                'check_roadmap' => 'required|string',
                'check_schemas' => 'required|string',
                'check_etiquette' => 'required|string',
                'receiver_email' => 'required|email',
                'signature_performer' => 'required|string',
                'signature_witness' => 'nullable|string',
                'signature_reviewer' => 'nullable|string',
                'signature_image' => 'nullable|string',
                'missing_parts' => 'nullable|string',
                'unmounted_parts' => 'nullable|string',
                'items' => 'required|array'
            ]);

            // Create reception form
            $form = ReceptionForm::create([
                'project' => $validatedData['project'],
                'check_date' => $validatedData['check_date'],
                'stamp_number' => $validatedData['stamp_number'],
                'check_roadmap' => $validatedData['check_roadmap'],
                'check_schemas' => $validatedData['check_schemas'],
                'check_etiquette' => $validatedData['check_etiquette'],
                'receiver_email' => $validatedData['receiver_email'],
                'signature_performer' => $validatedData['signature_performer'],
                'signature_witness' => $validatedData['signature_witness'],
                'signature_reviewer' => $validatedData['signature_reviewer'],
                'signature_image' => $validatedData['signature_image'],
                'missing_parts' => $validatedData['missing_parts'],
                'unmounted_parts' => $validatedData['unmounted_parts'],
                'submitted_at' => now(),
            ]);

            // Process items
            foreach ($request->items as $item) {
                ReceptionItem::create([
                    'reception_form_id' => $form->id,
                    'category' => $item['category'],
                    'name' => $item['name'],
                    'status' => $item['status'],
                    'comment' => $item['comment'] ?? null,
                ]);
            }

             // Generate PDF
             $pdfFileName = 'reception_form_' . $form->id . '_' . now()->format('Y-m-d_His') . '.pdf';
             $pdfPath = 'pdfs/' . $pdfFileName;

             // Fetch the items for this form
             $items = ReceptionItem::where('reception_form_id', $form->id)->get();

             $fullPdfPath = public_path($pdfPath);

             // Prepare data for PDF and email
             $data = [
                 'project' => $form->project,
                 'submitted_at' => $form->submitted_at->format('d.m.Y'),
                 'check_date' => $form->submitted_at,
                 'stamp_number' => $form->stamp_number,
                 'check_roadmap' => $form->check_roadmap,
                 'check_schemas' => $form->check_schemas,
                 'check_etiquette' => $form->check_etiquette,
                 'items' => $items->map(function($item) {
                     return [
                         'category' => $item->category,
                         'description' => $item->name,
                         'status' => $item->status,
                         'comment' => $item->comment
                     ];
                 })->toArray(),
                 'missing_parts' => $form->missing_parts,
                 'unmounted_parts' => $form->unmounted_parts,
                 'result_summary' => '',
                 'signature_performer' => $form->signature_performer,
                 'signature_image' => $form->signature_image ? base64_encode(Storage::get('public/' . $form->signature_image)) : null,
                 'signature_witness' => $form->signature_witness,
                 'signature_reviewer' => $form->signature_reviewer
             ];

             // Generate PDF
             $pdf = PDF::loadView('pdf.reception-form', compact('data'));
             $pdf->save($fullPdfPath);

            // Prepare comment array for email
            $commentArray = $form->items->groupBy('category')->map(function ($items) {
                return $items->map(function ($item) {
                    return [
                        'name' => $item->name,
                        'status' => $item->status,
                        'comment' => $item->comment ?? ''
                    ];
                });
            })->toArray();

            // Send email
            Mail::to($form->receiver_email)
                ->send(new ReceptionFormReport($data, $commentArray, $fullPdfPath));

            return response()->json([
                'message' => 'Formulaire enregistré et envoyé avec succès',
                'form' => $form,
                'pdf_path' => $pdfPath
            ], 201);

        } catch (\Exception $e) {
            Log::error('Error in ReceptionController@store: ' . $e->getMessage());
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'enregistrement du formulaire',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
