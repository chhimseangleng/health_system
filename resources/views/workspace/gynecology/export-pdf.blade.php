<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gynecology Record</title>
    @php $fontDataUri = !empty($fontBase64) ? "data:font/ttf;base64,$fontBase64" : null; @endphp
    <style>
        @if(!empty($fontDataUri))
        @font-face {
            font-family: 'NotoSansKhmer';
            src: url('{{ $fontDataUri }}') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body { font-family: 'NotoSansKhmer', 'DejaVu Sans', sans-serif; font-size: 12px; color: #111; line-height: 1.4; }
        @else
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; color: #111; line-height: 1.4; }
        @endif
        .container { width: 100%; }
        .header { width: 100%; margin-bottom: 14px; border-bottom: 2px solid #444; padding-bottom: 10px; }
        .brand img { width: 36px; height: 36px; border-radius: 50%; }
        .brand-text .name { font-weight: bold; font-size: 16px; }
        .meta { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .meta th { text-align: left; width: 25%; padding: 6px 8px; background: #f5f5f5; font-weight: 600; }
        .meta td { padding: 6px 8px; border-bottom: 1px solid #eee; }
        .section-title { font-size: 14px; margin: 14px 0 8px; font-weight: 600; }
        table { width: 100%; border-collapse: collapse; }
        thead th { text-align: left; background: #f5f5f5; padding: 6px 8px; border: 1px solid #e5e5e5; font-weight: 600; }
        tbody td { padding: 6px 8px; border: 1px solid #e5e5e5; }
    </style>
</head>
<body>

    @php
        use Carbon\Carbon;
        $meta = $meta ?? [];
        $prescriptions = $prescriptions ?? ($record->prescriptions ?? []);
        $patientObj = $patient ?? ($record->patient ?? null);

        $patientName = $meta['patientName'] ?? trim(($patientObj->first_name ?? '') . ' ' . ($patientObj->last_name ?? ''));
        if ($patientName === '') {
            $patientName = $record->name ?? 'N/A';
        }

        $age = $meta['age'] ?? 'N/A';
        if ($age === 'N/A') {
            if (!empty($patientObj?->date_of_birth)) {
                try {
                    $age = Carbon::parse($patientObj->date_of_birth)->age;
                } catch (\Exception $e) {
                    $age = $record->age ?? 'N/A';
                }
            } elseif (!empty($record->age)) {
                $age = $record->age;
            }
        }

        $gender = $meta['gender'] ?? ($patientObj->gender ?? ($record->gender ?? 'N/A'));
        $phone = $meta['phone'] ?? ($patientObj->phone ?? 'N/A');
        $paymentType = $meta['paymentType'] ?? 'N/A';
        $staffName = $meta['staffName'] ?? ($record->staff_name ?? 'N/A');
        $treatmentDate = $meta['treatmentDate'] ?? 'N/A';
        if ($treatmentDate === 'N/A') {
            if (!empty($record->treatment_date)) {
                try {
                    $treatmentDate = Carbon::parse($record->treatment_date)->format('Y-m-d');
                } catch (\Exception $e) {
                    $treatmentDate = $record->treatment_date;
                }
            } elseif ($record->updated_at) {
                $treatmentDate = $record->updated_at->format('Y-m-d');
            }
        }
        $address = $meta['address'] ?? ($patientObj->address ?? ($record->village ?? 'N/A'));
        $updatedAt = $meta['updatedAt'] ?? ($record->updated_at ? $record->updated_at->format('Y-m-d H:i') : 'N/A');
        $symptoms = $meta['symptoms'] ?? ($record->symptoms ?? 'N/A');
        $medicationText = $meta['medicationText'] ?? ($record->medication ?? 'N/A');
        $notes = $meta['notes'] ?? ($record->notes ?? '');
    @endphp
    <div class="container">
        <div class="header">
            <div class="brand" style="display:inline-block;vertical-align:middle;">
                @if(!empty($logoBase64))
                    <img src="data:{{ $logoMime ?? 'image/png' }};base64,{{ $logoBase64 }}" alt="Logo">
                @else
                    <img src="{{ public_path('IMG/samaky.png') }}" alt="Logo">
                @endif
            </div>
            <div class="brand-text" style="display:inline-block;vertical-align:middle;margin-left:8px;">
                <div class="name">Samaky Health Center</div>
                <div class="subtitle">Gynecology Record</div>
            </div>
        </div>

        <table class="meta">
            <tr>

                <th>Patient</th><td>{{ $patientName }}</td>
                <th>Updated</th><td>{{ $updatedAt }}</td>
            </tr>
            <tr>
                <th>Age</th><td>{{ $age }}</td>
                <th>Gender</th><td>{{ $gender }}</td>
            </tr>
            <tr>
                <th>Phone</th><td>{{ $phone }}</td>
                <th>Payment Type</th><td>{{ $paymentType }}</td>
            </tr>
            <tr>
                <th>Staff</th><td>{{ $staffName }}</td>
                <th>Treatment Date</th><td>{{ $treatmentDate }}</td>
            </tr>
            <tr>
                <th>Address</th><td colspan="3">{{ $address }}</td>
            </tr>
        </table>

        <div class="section-title">Symptoms</div>
        <div>{{ $symptoms }}</div>

        <div class="section-title">Medication</div>
        <div>{{ $medicationText }}</div>

        @php
            $formatDose = function($value) {
                if (is_array($value)) {
                    $parts = [];
                    if (isset($value['qty']) && $value['qty'] !== '') {
                        $parts[] = 'Qty: ' . $value['qty'];
                    }
                    if (!empty($value['remark'])) {
                        $parts[] = $value['remark'];
                    }
                    return implode(' • ', $parts);
                }
                return $value;
            };
        @endphp
        @if(!empty($prescriptions) && is_array($prescriptions))
            <div class="section-title">Prescriptions</div>
            <table>
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Total Medicine</th>
                        <th>Total Day</th>
                        <th>Morning (M)</th>
                        <th>Afternoon (A)</th>
                        <th>Evening (E)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $p)
                        @php
                            $mid = (string)($p['medicine_id'] ?? '');
                            $mname = $p['medicine_name'] ?? ($medicineMap[$mid] ?? $mid);
                            $times = $p['times'] ?? [];
                        @endphp
                        <tr>
                            <td>{{ $mname }}</td>
                            <td>{{ $p['total_medicine'] ?? '' }}</td>
                            <td>{{ $p['total_day'] ?? '' }}</td>
                            <td>{{ $formatDose($times['M'] ?? '') }}</td>
                            <td>{{ $formatDose($times['A'] ?? '') }}</td>
                            <td>{{ $formatDose($times['E'] ?? '') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        @if(!empty($notes))
            <div class="section-title">Notes</div>
            <div>{{ $notes }}</div>
        @endif
    </div>
</body>
</html>


