<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Dompdf\Dompdf;
// use Barryvdh\DomPDF\PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Mail\ChecklistReport;
use App\Models\ChecklistItem;
use Illuminate\Support\Facades\Mail;

class ChecklistController extends Controller
{
    public function index()
    {
        $vis_control_ar= [
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
        $items = [

            // Composants Électriques
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble terre GB1+FL1-W5',
                'description' => 'Câble de terre pour connexion à la plaque de cuivre du module 2',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble terre GB1+FL1-W2',
                'description' => 'Câble de terre pour connexion à la barre de cuivre principale',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble AS1+A2-W3',
                'description' => 'Câble pour armoire +A3 MASTER, longueur 600mm',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble AS1+A2-W4',
                'description' => 'Câble pour armoire +A3 MASTER',
                'is_present' => false
            ],
            [
                'category' => 'Composants Électriques',
                'name' => 'Câble CC1+A2-W1',
                'description' => 'Câble pour armoire +A3 MASTER',
                'is_present' => false
            ],

            // Composants Armoire SLAVE
            [
                'category' => 'Armoire SLAVE',
                'name' => 'Câble AS2+A2-W3',
                'description' => 'Câble ASi pour armoire +A4 SLAVE, longueur 600mm',
                'is_present' => false
            ],
            [
                'category' => 'Armoire SLAVE',
                'name' => 'Câble AS2+A2-W4',
                'description' => 'Câble pour armoire +A4 SLAVE',
                'is_present' => false
            ],
            [
                'category' => 'Armoire SLAVE',
                'name' => 'Câble CC1+A2-W2',
                'description' => 'Câble pour armoire +A4 SLAVE, longueur 660mm',
                'is_present' => false
            ],

            // Composants Mécaniques
            [
                'category' => 'Composants Mécaniques',
                'name' => 'Support ASi',
                'description' => 'Support pour module ASi',
                'is_present' => false
            ],
            [
                'category' => 'Composants Mécaniques',
                'name' => 'Vis M5x10',
                'description' => 'Vis pour fixation équerre alimentation 230VAC',
                'is_present' => false
            ],
            [
                'category' => 'Composants Mécaniques',
                'name' => 'Rondelles M5',
                'description' => 'Rondelles pour fixation équerre alimentation 230VAC',
                'is_present' => false
            ],
            [
                'category' => 'Composants Mécaniques',
                'name' => 'Équerre alimentation 230VAC',
                'description' => 'Support pour alimentation principale',
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

            // Interface HMI
            [
                'category' => 'Interface HMI',
                'name' => 'Câble HDMI HM1+OP1-PH1-W1',
                'description' => 'Câble HDMI pour connexion écran',
                'is_present' => false
            ],
            [
                'category' => 'Interface HMI',
                'name' => 'Câble USB HM1+OP1-K1-W5',
                'description' => 'Câble USB pour connexion interface',
                'is_present' => false
            ],
            [
                'category' => 'Interface HMI',
                'name' => 'Lampe CL1+FR1-P1',
                'description' => 'Lampe de signalisation',
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

        return view('checklist', ['items' => $items, 'vis_control_ar'=>$vis_control_ar]);
    }

    public function store(Request $request)
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
        $pdf = Pdf::loadView('emails.checklist-report', [
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
