<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Common Disease Record</title>
    <style>
        /* dompdf-friendly styles only */
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; line-height: 1.4; }
        .container { width: 100%; }
        .header { width: 100%; margin-bottom: 14px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .brand { display: inline-block; vertical-align: middle; }
        .brand img { width: 36px; height: 36px; border-radius: 50%; }
        .brand-text { display: inline-block; vertical-align: middle; margin-left: 8px; }
        .brand-text .name { font-weight: bold; font-size: 16px; }
        .brand-text .subtitle { font-size: 11px; color: #555; }

        h1 { font-size: 18px; margin: 0 0 12px; }
        .meta { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .meta th { text-align: left; width: 25%; padding: 6px 8px; background: #f5f5f5; font-weight: 600; }
        .meta td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .section-title { font-size: 14px; margin: 14px 0 8px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        thead th { text-align: left; background: #f5f5f5; padding: 6px 8px; border: 1px solid #e5e5e5; font-weight: 600; }
        tbody td { padding: 6px 8px; border: 1px solid #e5e5e5; }
    </style>
    <!-- NOTE: No Tailwind classes; keep CSS simple for dompdf parser -->
    <!-- dompdf parses inline CSS only; avoid advanced selectors -->
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="brand">
                @if(!empty($logoBase64))
                    <img src="data:{{ $logoMime ?? 'image/png' }};base64,{{ $logoBase64 }}" alt="Logo">
                @else
                    <img src="{{ public_path('IMG/samaky.png') }}" alt="Logo">
                @endif
            </div>
            <div class="brand-text">
                <div class="name">Samaky Health Center</div>
                <div class="subtitle">Common Disease Record</div>
            </div>
        </div>
        <h1 style="display:none;">Common Disease Record</h1>

        <table class="meta">
            <tr>
                <th>Name</th><td>{{ $record->name }}</td>
                <th>Updated</th><td>{{ optional($record->updated_at)->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Category</th><td>{{ $record->category }}</td>
                <th>Physician</th><td>{{ $record->physician }}</td>
            </tr>
            <tr>
                <th>Age</th><td>{{ $record->age }}</td>
                <th>Gender</th><td>{{ $record->gender }}</td>
            </tr>
            <tr>
                <th>Village</th><td>{{ $record->village }}</td>
                <th>Commune</th><td>{{ $record->commune }}</td>
            </tr>
        </table>

        <div class="section-title">Drug Diagnosis</div>
        <div>{{ $record->drug_diagnosis }}</div>

        @php $prescriptions = $record->prescriptions ?? []; @endphp
        @if(!empty($prescriptions) && is_array($prescriptions))
            <div class="section-title">Prescriptions</div>
            <table>
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Total Day</th>
                        <th>Total Medicine</th>
                        <th>Morning (M)</th>
                        <th>Afternoon (A)</th>
                        <th>Evening (E)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $p)
                        @php
                            $mid = (string)($p['medicine_id'] ?? '');
                            $mname = $medicineMap[$mid] ?? $mid;
                            $times = $p['times'] ?? [];
                        @endphp
                        <tr>
                            <td>{{ $mname }}</td>
                            <td>{{ $p['total_day'] ?? '' }}</td>
                            <td>{{ $p['total_medicine'] ?? '' }}</td>
                            <td>{{ $times['M']['qty'] ?? '' }}</td>
                            <td>{{ $times['A']['qty'] ?? '' }}</td>
                            <td>{{ $times['E']['qty'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>



