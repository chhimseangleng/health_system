<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Vaccine Record</title>
    <style>
        /* Professional printable styles */
        @page { margin: 20mm; }
        body { font-family: DejaVu Sans, Arial, sans-serif; color: #222; font-size: 12px; line-height:1.4; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { display: table; width: 100%; margin-bottom: 14px; }
        .logo { display: table-cell; vertical-align: middle; width: 120px; }
        .clinic { display: table-cell; vertical-align: middle; text-align: left; padding-left:12px; }
        .clinic h1 { margin:0; font-size:18px; letter-spacing:0.5px; }
        .clinic p { margin:2px 0; color:#555; font-size:11px; }
        .title { text-align:center; margin: 10px 0 18px 0; font-size:16px; font-weight:700; color:#0b63b8; }
        .divider { height:1px; background:#e6e6e6; margin-bottom:14px; }
        .info-table { width:100%; border-collapse: collapse; margin-bottom:12px; }
        .info-table td { padding:8px 10px; vertical-align:top; border: 1px solid #efefef; }
        .info-label { background:#f7f9fb; width:170px; font-weight:600; color:#333; }
        .dose-table { width:100%; border-collapse: collapse; margin-top:6px; }
        .dose-table th, .dose-table td { padding:8px 10px; border:1px solid #e9e9e9; text-align:left; font-size:12px; }
        .dose-table th { background:#fafafa; font-weight:700; color:#333; }
        .note { background:#fbfbfb; border-left:4px solid #0b63b8; padding:10px; margin-top:12px; color:#333; }
        .footer { margin-top:18px; font-size:11px; color:#666; display:flex; justify-content:space-between; }
        .muted { color:#777; font-size:11px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                @if(!empty($logoBase64))
                    <img src="data:{{ $logoMime }};base64,{{ $logoBase64 }}" alt="logo" style="max-width:120px; display:block;">
                @endif
            </div>
            <div class="clinic">
                <h1>Health Center / Clinic</h1>
                <p>Address: 123 Clinic Street, Phnom Penh</p>
                <p>Phone: (+855) 12 345 678 • Email: info@clinic.example</p>
            </div>
        </div>

        <div class="title">VACCINATION RECORD</div>
        <div class="divider" role="presentation"></div>

        <table class="info-table">
            <tr>
                <td class="info-label">Patient Name</td>
                <td>{{ $vaccine->name }}</td>
                <td class="info-label">Record ID</td>
                <td>{{ (string) ($vaccine->_id ?? '') }}</td>
            </tr>
            <tr>
                <td class="info-label">Date of Birth</td>
                <td>{{ \Carbon\Carbon::parse($vaccine->bod)->format('Y-m-d') }}</td>
                <td class="info-label">Age</td>
                <td>{{ $vaccine->age }}</td>
            </tr>
            <tr>
                <td class="info-label">Father</td>
                <td>{{ $vaccine->father_name }}</td>
                <td class="info-label">Mother</td>
                <td>{{ $vaccine->mother_name }}</td>
            </tr>
            <tr>
                <td class="info-label">Vaccine Type</td>
                <td>{{ $vaccine->vaccineCategory?->name ?? 'N/A' }}</td>
                <td class="info-label">Payment Type</td>
                <td>
                    @php
                        $payment = null;
                        try {
                            $parts = explode(' ', $vaccine->name);
                            $first = $parts[0] ?? '';
                            $last = $parts[1] ?? '';
                            $patient = \App\Models\Patient::where('first_name', $first)->where('last_name', $last)->first();
                            if ($patient) {
                                $assignment = $patient->assignments()->where('assigned_to', 'vaccine')->latest()->first();
                                $payment = $assignment?->payment_type;
                            }
                        } catch (\Throwable $e) { /* ignore */ }
                    @endphp
                    {{ $payment ?? 'N/A' }}
                </td>
            </tr>
        </table>

        <h4 style="margin:8px 0 6px 0; font-size:13px;">Dose History</h4>
        <table class="dose-table" role="table" aria-label="Dose dates">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($vaccine->dose_dates) && is_array($vaccine->dose_dates))
                    @foreach($vaccine->dose_dates as $i => $d)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $d }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="muted">No dose records available</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <div class="note">
            <strong>Description:</strong>
            <div style="margin-top:6px;">{{ $vaccine->description ?? '—' }}</div>
        </div>

        <div class="footer">
            <div class="muted">Printed: {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</div>
            <div class="muted">Prepared by: {{ auth()->user()->name ?? 'System' }}</div>
        </div>
    </div>
</body>
</html>


