<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Checklist Reception Machine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 40px;
        }
        .header {
            text-align: left;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 150px;
        }
        .header-right {
            float: right;
            text-align: right;
        }
        .form-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .project-info {
            margin-bottom: 20px;
        }
        .project-info div {
            margin-bottom: 10px;
        }
        .checklist-item {
            margin-bottom: 5px;
        }
        .status-box {
            display: inline-block;
            width: 15px;
            height: 15px;
            padding: 5px;
            vertical-align: top;
        }
        .status-ok {
            background-color: #17DD45FF;
            font-weight: bold;
        }
        .status-nok {
            background-color: #E31126FF;
            font-weight: bold;
        }
        .signature-image {
    width: 120px; /* Set your desired width */
    height: 35px; /* Maintain the aspect ratio */
    border: 1px solid #ddd; /* Optional: Add a border */
    border-radius: 5px; /* Optional: Add rounded corners */
    box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2); /* Optional: Add a shadow */
}
        .commentTd {
 
            font-size: 12px; 
  }
  td {
    word-wrap: break-word; /* Ensures text breaks to fit in the cell */
    word-break: break-word; /* Fallback for some older browsers */
    white-space: normal;  
   
   
  }
        .signature-section {
            margin-top: 30px;
        }
        .signature-row {
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin: 0 auto;
            display: block;
        }
        .signature-box {
            border-bottom: 1px solid #000;
            min-height: 40px;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <div class="header">
    
        <img src="{{ public_path('images/logo.png') }}" width="120px" height="80px" alt="Company Logo" class="logo">


        <div class="header-right">
            <div>DP 07.3-12e</div>
            <div>V1.0</div>
        </div>
        <div style="clear: both;"></div>
        <div style="text-align: center; margin-top: 20px;">
            <div>Project Management</div>
            <div>Etec Standard G05</div>
            <div>Wiring Prerequisites Checklist</div>
        </div>
    </div>

    <div class="form-title">
        Checklist Reception Machine pour câblage standard
    </div>

    <div class="project-info">
        <table>
            <tr>
                <td width="200">Projet</td>
                <td>: {{ $data['project'] }}</td>
            </tr>
            <tr>
                <td>Date du Check</td>
                <td>: {{ $data['submitted_at'] }}</td>
            </tr>
            <tr>
                <td>Check Roadmap</td>
                <td>: <span class="{{ $data['check_roadmap'] === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $data['check_roadmap'] }}</span></td>
            </tr>
            <tr>
                <td>Check Numéro de timbrage</td>
                <td>: {{ $data['stamp_number'] }}</td>
            </tr>
            <tr>
                <td>Check Schémas Eplan</td>
                <td>: <span class="{{ $data['check_schemas'] === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $data['check_schemas'] }}</span></td>
            </tr>
            <tr>
                <td>Check Étiquette standard</td>
                <td>: <span class="{{ $data['check_etiquette'] === 'OK' ? 'status-ok' : 'status-nok' }}">{{ $data['check_etiquette'] }}</span></td>
            </tr>
        </table>
    </div>

    <div class="checklist-section">
        <div style="margin-bottom: 20px;">
            <strong>Controle visuel des armoires</strong>
            @foreach($data['items'] as $item)
                @if($item['category'] === 'Controle visuel des armoires')
                <div class="checklist-item">
                    <table>
                        <tr>
                            <td width="48%">: {{ $item['description'] }}</td>
                            
                            <td width="45%" class="commentTd">@if ($item['comment']!=null) {{ $item['comment'] }} @endif</td>
                           
                            <td width="7%" class="{{ $item['status'] === 'ok' ? 'status-ok' : 'status-nok' }}">
                                {{ $item['status'] }}
                            </td>
                        </tr>
                    </table>
                </div>
                @endif
            @endforeach
        </div>


        <div style="margin-bottom: 20px;">
            <strong>HMI</strong>
            @foreach($data['items'] as $item)
                @if($item['category'] === 'HMI')
                <div class="checklist-item">
                    <table>
                        <tr>
                            <td width="48%">: {{ $item['description'] }}</td>
                            <td width="45%" class="commentTd">@if ($item['comment']!=null) {{ $item['comment'] }} @endif</td>

                            <td width="7%" class="{{ $item['status'] === 'ok' ? 'status-ok' : 'status-nok' }}">
                                {{ $item['status'] }}
                            </td>
                          
                        </tr>
                    </table>
                </div>
                @endif
            @endforeach
        </div>

        <div style="margin-bottom: 20px;">
            <strong>Chaine HMI</strong>
            @foreach($data['items'] as $item)
                @if($item['category'] === 'Chaine HMI')
                <div class="checklist-item">
                    <table>
                        <tr>
                            <td width="48%">: {{ $item['description'] }}</td>
                            <td width="45%" class="commentTd">@if ($item['comment']!=null) {{ $item['comment'] }} @endif</td>

                            <td width="7%" class="{{ $item['status'] === 'ok' ? 'status-ok' : 'status-nok' }}">
                                {{ $item['status'] }}
                            </td>
                        </tr>
                    </table>
                </div>
                @endif
            @endforeach
        </div>

        <div style="margin-bottom: 20px;">
            <strong>Carton fournisseur</strong>
            @foreach($data['items'] as $item)
                @if($item['category'] === 'Carton fournisseur')
                <div class="checklist-item">
                    <table>
                        <tr>
                            <td width="48%">: {{ $item['description'] }}</td>
                            <td width="45%" class="commentTd">@if ($item['comment']!=null) {{ $item['comment'] }} @endif</td>

                            <td width="7%" class="{{ $item['status'] === 'ok' ? 'status-ok' : 'status-nok' }}">
                                {{ $item['status'] }}
                            </td>
                        </tr>
                    </table>
                </div>
                @endif
            @endforeach
        </div>

        <div style="margin-bottom: 20px;">
            <strong>Vérine</strong>
            @foreach($data['items'] as $item)
                @if($item['category'] === 'Vérine')
                <div class="checklist-item">
                    <table>
                        <tr>
                            <td width="48%">: {{ $item['description'] }}</td>
                         
                            <td width="45%" class="commentTd">@if ($item['comment']!=null) {{ $item['comment'] }} @endif</td>

                            <td width="7%" class="{{ $item['status'] === 'ok' ? 'status-ok' : 'status-nok' }}">
                                {{ $item['status'] }}
                            </td>
                        </tr>
                    </table>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    <div style="margin-top: 20px;">
        <strong>Check Pièces Manquante</strong>
        <div>: {{ $data['missing_parts'] ?: '-' }}</div>
    </div>

    <div style="margin-top: 20px;">
        <strong>Check Pièces non montée</strong>
        <div>: {{ $data['unmounted_parts'] ?: '-' }}</div>
    </div>

    <div style="margin-top: 20px;">
        <strong>Result Summary</strong>
        <div>: {{ $data['result_summary'] ?: '-' }}</div>
    </div>

    <div class="signature-section">
        <table style="width: 100%;">
            <tr>
                <td style="width: 100px;">Performed by</td>
                <td>: {{ $data['signature_performer'] }}</td>
                <td>Signature:</td>
                <td>
                    @if($data['signature_image'])
                    <img src="{{ public_path('signatures/' . $data['signature_image']) }}"  class="signature-image">

                    @endif
                </td>
                <td>Date {{ $data['submitted_at'] }}</td>
            </tr>
            <tr>
                <td>Witnessed by</td>
                <td>: {{ $data['signature_witness'] ?: '________________' }}</td>
                <td>Signature:</td>
                <td>________________</td>
                <td>Date ________________</td>
            </tr>
            <tr>
                <td>Reviewed by</td>
                <td>: {{ $data['signature_reviewer'] ?: '________________' }}</td>
                <td>Signature:</td>
                <td>________________</td>
                <td>Date ________________</td>
            </tr>
        </table>
    </div>

    <div style="text-align: right; margin-top: 20px;">
        Page 1/1
    </div>
</body>
</html>
