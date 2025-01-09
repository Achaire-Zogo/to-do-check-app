<?php

namespace App\Http\Controllers;
use App\Models\ChecklistItem;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\ChecklistReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Dompdf\Dompdf;

class ChecklistController extends Controller
{
    protected $vis_control_ar = [
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A1',
            'description' => 'Vérification visuelle de l\'armoire A1',
            'is_present' => true, // Default to "présent"
        ],
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A2',
            'description' => 'Vérification visuelle de l\'armoire A2',
            'is_present' => true, // Default to "présent"
        ],
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A3',
            'description' => 'Vérification visuelle de l\'armoire A3',
            'is_present' => true, // Default to "présent"
        ],
        [
            'category' => 'Controle visuel des armoires',
            'name' => 'Armoire A4 (Optionnelle)',
            'description' => 'Vérification visuelle de l\'armoire A4',
            'is_present' => false, // Default to "non présent"
        ],
    ];

    public function index()
    {
        $items = [
           
            // Composants Électriques
            [
                'category' => 'Composants Électriques',
                'name' => 'Colonne lumineuse',
                'description' => 'Colonne lumineuse Pour HMI',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => ' Sécurité de porte avant',
                'description' => 'Capteur  sécurité de porte avant Schermersal',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Sécurité porte arrière',
                'description' => 'Capteur  sécurité de portes arrières Schermersal',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble alimentation',
                'description' => 'Câble alimentation armoire A1+',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'équerre AS-i dans modules ',
                'description' => 'équerre AS-i dans modules ',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble terres ',
                'description' => 'Câble Terre pour ensemble machine controle de la présence de tous les cables standards ',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Lampe avant Machine',
                'description' => 'Lampe avant Machine éclairage cellules',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Switch principal et filtre A1',
                'description' => 'Switch principal et filtre A1 ',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câbles descente montant gauche venant A2 ',
                'description' => 'Câbles descente montant gauche venant A2 ',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câbles descente montant droite venant A2 ',
                'description' => 'Câbles descente montant droite venant A2 ',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'HMI',
                'description' => 'HMI controle câbles et HMI',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Chaine HMI',
                'description' => 'Chaine passage câble HMI',
                'is_present' => false
            ],

            // Composants Mécaniques
            [
                'category' => 'Composants Mécaniques',
                'name' => 'Supports ASi Frontal',
                'description' => 'Support pour module ASi avant machine',
                'is_present' => false
            ],
        
            // Composants Pneumatiques
            [
                'category' => 'Composants Pneumatiques',
                'name' => 'Manomètre',
                'description' => 'Manomètre pour contrôle pression (6 bars)',
                'is_present' => false
            ],
            [
                'category' => 'Composants Pneumatiques',
                'name' => 'Tuyau pneumatique bleu',
                'description' => 'Tuyau pour circuit pneumatique',
                'is_present' => false
            ],
            [
                'category' => 'Composants Pneumatiques',
                'name' => 'Tuyau pneumatique noir',
                'description' => 'Tuyau pour circuit pneumatique',
                'is_present' => false
            ],
            [
                'category' => 'Composants Pneumatiques',
                'name' => 'Support pneumatique avant',
                'description' => 'Support pour système pneumatique',
                'is_present' => false
            ],

            // Composants de Sécurité
            [
                'category' => 'Composants de Sécurité',
                'name' => 'Câble SG1+A2-K1-W1',
                'description' => 'Câble pour sécurité de porte avant',
                'is_present' => false
            ],
            [
                'category' => 'Composants de Sécurité',
                'name' => 'Câble SG1+A2-S3-W1',
                'description' => 'Câble pour sécurité de porte avant',
                'is_present' => false
            ],
            [
                'category' => 'Composants de Sécurité',
                'name' => 'Switch principal',
                'description' => 'Interrupteur principal de sécurité',
                'is_present' => false
            ],
            [
                'category' => 'Composants de Sécurité',
                'name' => 'Filtre d\'entrée',
                'description' => 'Filtre pour switch principal',
                'is_present' => false
            ],
            
            // Capteurs et Sondes
            [
                'category' => 'Capteurs et Sondes',
                'name' => 'Câble PC1+FR1-B3-W1',
                'description' => 'Câble pour capteur entrée palette V6, longueur 750mm',
                'is_present' => false
            ],
            [
                'category' => 'Capteurs et Sondes',
                'name' => 'Sonde entrée palette',
                'description' => 'Sonde pour détection palette V6',
                'is_present' => false
            ],
            [
                'category' => 'Capteurs et Sondes',
                'name' => 'Câble CI1+A2-B1-W1',
                'description' => 'Câble pour tête de lecture BALUFF',
                'is_present' => false
            ],
            [
                'category' => 'Capteurs et Sondes',
                'name' => 'Tête de lecture BALUFF',
                'description' => 'Tête de lecture pour connexion sur "Head 1" de CI1-K1',
                'is_present' => false
            ]
        ];

        return view('checklist', ['items' => $items, 'vis_control_ar'=>$this->vis_control_ar]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project' => 'required|string',
            'check_date' => 'required|date',
            'stamp_number' => 'required|string',
            'report_email' => 'required|email',
            'signature_performer' => 'required|string',
            'signature_witness' => 'nullable|string',
            'signature_reviewer' => 'nullable|string',
        ]);

        // Process the form data
        $checklistData = [
            'project' => $request->project,
            'check_date' => $request->check_date,
            'stamp_number' => $request->stamp_number,
            'items' => [],
        ];

        // Process armoire items
        foreach ($this->vis_control_ar as $index => $item) {
            $checklistData['items'][] = [
                'name' => $item['name'],
                'status' => $request->input("status_${index}"),
                'comment' => $request->input("comment_${index}"),
            ];
        }

        // Generate PDF
        $pdf = PDF::loadView('checklist.pdf', [
            'data' => $checklistData,
            'signature_performer' => $request->signature_performer,
            'signature_witness' => $request->signature_witness,
            'signature_reviewer' => $request->signature_reviewer,
        ]);

        // Send email with PDF attachment
        Mail::to($request->report_email)
            ->send(new ChecklistReport($pdf->output(), $checklistData));

        return redirect()->route('checklist.index')
            ->with('success', 'Checklist submitted successfully and sent by email.');
    }

    public function store2(Request $request)
    {
        $validatedData = $request->validate([
            'user_name' => 'required|string|max:255',
            'recipient_email' => 'required|email',
            'items' => 'required|array'
        ]);

        // Préparation des statistiques globales
        $totalItems = count($request->items);
        $presentItems = count(array_filter($request->items, fn($item) => $item['is_present']));
        $missingItems = $totalItems - $presentItems;
        $itemsWithComments = count(array_filter($request->items, fn($item) => !empty($item['comment'])));

        // Organisation des items par catégorie avec statistiques
        $categorizedItems = [];
        foreach ($request->items as $item) {
            if (!isset($categorizedItems[$item['category']])) {
                $categorizedItems[$item['category']] = [
                    'total' => 0,
                    'present' => 0,
                    'missing' => 0,
                    'items' => []
                ];
            }

            // S'assurer que le champ comment existe
            $item['comment'] = isset($item['comment']) ? $item['comment'] : null;

            $categorizedItems[$item['category']]['total']++;
            if ($item['is_present']) {
                $categorizedItems[$item['category']]['present']++;
            } else {
                $categorizedItems[$item['category']]['missing']++;
            }
            $categorizedItems[$item['category']]['items'][] = $item;
        }

        // Préparation des données pour le rapport
        $reportData = [
            'userName' => $request->user_name,
            'date' => Carbon::now()->format('d/m/Y H:i'),
            'totalItems' => $totalItems,
            'machineName' => $request->machineName,
            'presentItems' => $presentItems,
            'missingItems' => $missingItems,
            'itemsWithComments' => $itemsWithComments,
            'categorizedItems' => $categorizedItems
        ];

        // Sauvegarde dans la base de données
        foreach ($request->items as $item) {
            ChecklistItem::create([
                'name' => $item['name'],
                'category' => $item['category'],
                'description' => $item['description'],
                'is_present' => $item['is_present'],
                'comment' => $item['comment'] ?? null,
                'user_name' => $request->user_name,
                'recipient_email' => $request->recipient_email,
            ]);
        }
$commentAr=($request->commentAr);
$pdf = PDF::loadView('emails.checklist-report', [
    'userName' => $reportData['userName'],
    'date' => $reportData['date'],
    'machineName' => $request->machineName,
    'totalItems' => $reportData['totalItems'],
    'presentItems' => $reportData['presentItems'],
    'missingItems' => $reportData['missingItems'],
    'itemsWithComments' => $reportData['itemsWithComments'],
    'categorizedItems' => $reportData['categorizedItems'],
    'commentAr' => $commentAr
]);

// Save the PDF to a file (optional)
$pdfPath = storage_path('app/public/checklist_report.pdf');
$pdf->save($pdfPath);
Mail::to($request->recipient_email)
->send(new ChecklistReport($reportData,$commentAr, $pdfPath));
        // Envoi du rapport par email
     /*   Mail::to($request->recipient_email)
            ->send(new ChecklistReport($reportData,$commentAr));*/

        return response()->json([
            'message' => 'Checklist enregistrée et rapport envoyé avec succès',
            'statistics' => [
                'total' => $totalItems,
                'present' => $presentItems,
                'missing' => $missingItems,
                'with_comments' => $itemsWithComments
            ]
        ]);
    }
}
