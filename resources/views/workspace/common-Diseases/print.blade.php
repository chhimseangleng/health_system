<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Common Diseases - Print</title>
    <style>
        @page { size: A4 landscape; margin: 10mm; }
        *{ box-sizing: border-box; }
        body{ font-family: 'Khmer OS Battambang', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; color:#111827; }
        .sheet{ display: grid; grid-template-columns: 1fr 1fr; gap: 10mm; }
        .card{ border:1px solid #cbd5e1; border-radius:8px; padding:8mm; }
        .header{ display:flex; align-items:center; justify-content:space-between; margin-bottom:6mm; }
        .logo{ width:26mm; height:26mm; border-radius:50%; object-fit:cover; }
        .title{ text-align:center; flex:1; }
        .title h1{ margin:0; font-size:16px; font-weight:800; }
        .title h2{ margin:2px 0 0; font-size:12px; font-weight:700; }
        .grid{ width:100%; border-collapse:collapse; }
        .grid th, .grid td{ border:1px solid #cbd5e1; padding:6px 8px; font-size:11px; }
        .grid thead th{ background:#e5e7eb; text-align:center; }
        .muted{ color:#6b7280; font-size:10px; }
        .row-number{ width:18px; text-align:center; }
        .section{ margin:6mm 0 3mm; font-weight:700; }
        .two-col{ display:grid; grid-template-columns: 120px 1fr; gap:6px; align-items:center; }
        .label{ font-weight:700; font-size:11px; }
        .box{ border:1px solid #cbd5e1; height:26px; }
        .nowrap{ white-space:nowrap; }
        @media print { .noprint{ display:none; } }
    </style>
</head>
<body>
    <div class="noprint" style="margin-bottom:8px; display:flex; justify-content:flex-end; gap:8px;">
        <button onclick="window.print()" style="padding:8px 12px; background:#2563eb; color:#fff; border:none; border-radius:6px;">Print</button>
    </div>
    <div class="sheet">
        <!-- Left card -->
        <div class="card">
            <div class="header">
                <img src="{{ asset('IMG/samaky.png') }}" alt="Samaky Health Logo" class="logo">
                <div class="title">
                    <h1>មណ្ឌលសុខភាពសាមគ្គី</h1>
                    <h2>បញ្ចី សេចក្ដីរាយការណ៍</h2>
                </div>
                <div style="width:26mm"></div>
            </div>

            <div style="height: 12px;"></div>
            <div class="two-col"><div class="label">ឈ្មោះ:</div><div class="box"></div></div>
            <div style="height: 12px;"></div>
            <div class="two-col"><div class="label">ទីលំនៅ:</div><div class="box"></div></div>
            <div style="height: 12px;"></div>

            <div class="section">ព័ត៌មានអ្នកជំងឺ</div>
            <table class="grid">
                <thead>
                    <tr>
                        <th class="row-number">ល.រ</th>
                        <th>ឈ្មោះជំងឺ</th>
                        <th>ប្រភេទ</th>
                        <th>វេជ្ជបណ្ឌិត</th>
                        <th>អាយុ</th>
                        <th>ភេទ</th>
                        <th>ថ្នាំ/រោគវិនិច្ឆ័យ</th>
                        <th>ភូមិ</th>
                        <th>ឃុំ</th>
                        <th>ថ្ងៃកែប្រែ</th>
                        <th>បុគ្គលិក</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($diseases ?? []) as $i => $d)
                        <tr>
                            <td class="row-number">{{ $i + 1 }}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->category }}</td>
                            <td>{{ $d->physician }}</td>
                            <td>{{ $d->age }}</td>
                            <td>{{ $d->gender }}</td>
                            <td>{{ $d->drug_diagnosis }}</td>
                            <td>{{ $d->village }}</td>
                            <td>{{ $d->commune }}</td>
                            <td>{{ optional($d->updated_at)->format('Y-m-d') }}</td>
                            <td>{{ $d->staff_name }}</td>
                        </tr>
                    @empty
                        @for ($i = 1; $i <= 6; $i++)
                            <tr>
                                <td class="row-number">{{ $i }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                    @endforelse
                </tbody>
            </table>

            <div class="section">ការកត់សម្គាល់</div>
            <div class="box" style="height:32px"></div>
            <div class="muted" style="margin-top:6mm; display:flex; justify-content:space-between;">
                <div>អ្នកបំពេញ...................................................................</div>
                <div>ឆ្នាំ........ខែ........ទីកន្លែង........</div>
            </div>
        </div>

        <!-- Right card (duplicate layout for 2-per-page like sample) -->
        <div class="card">
            <div class="header">
                <img src="{{ asset('IMG/samaky.png') }}" alt="Samaky Health Logo" class="logo">
                <div class="title">
                    <h1>មណ្ឌលសុខភាពសាមគ្គី</h1>
                    <h2>បញ្ចី សេចក្ដីរាយការណ៍</h2>
                </div>
                <div style="width:26mm"></div>
            </div>

            <div style="height: 12px;"></div>
            <div class="two-col"><div class="label">ឈ្មោះ:</div><div class="box"></div></div>
            <div style="height: 12px;"></div>
            <div class="two-col"><div class="label">ទីលំនៅ:</div><div class="box"></div></div>
            <div style="height: 12px;"></div>

            <div class="section">ព័ត៌មានអ្នកជំងឺ</div>
            <table class="grid">
                <thead>
                    <tr>
                        <th class="row-number">ល.រ</th>
                        <th>ឈ្មោះជំងឺ</th>
                        <th>ប្រភេទ</th>
                        <th>វេជ្ជបណ្ឌិត</th>
                        <th>អាយុ</th>
                        <th>ភេទ</th>
                        <th>ថ្នាំ/រោគវិនិច្ឆ័យ</th>
                        <th>ភូមិ</th>
                        <th>ឃុំ</th>
                        <th>ថ្ងៃកែប្រែ</th>
                        <th>បុគ្គលិក</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($diseases ?? []) as $i => $d)
                        <tr>
                            <td class="row-number">{{ $i + 1 }}</td>
                            <td>{{ $d->name }}</td>
                            <td>{{ $d->category }}</td>
                            <td>{{ $d->physician }}</td>
                            <td>{{ $d->age }}</td>
                            <td>{{ $d->gender }}</td>
                            <td>{{ $d->drug_diagnosis }}</td>
                            <td>{{ $d->village }}</td>
                            <td>{{ $d->commune }}</td>
                            <td>{{ optional($d->updated_at)->format('Y-m-d') }}</td>
                            <td>{{ $d->staff_name }}</td>
                        </tr>
                    @empty
                        @for ($i = 1; $i <= 6; $i++)
                            <tr>
                                <td class="row-number">{{ $i }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endfor
                    @endforelse
                </tbody>
            </table>

            <div class="section">ការកត់សម្គាល់</div>
            <div class="box" style="height:32px"></div>
            <div class="muted" style="margin-top:6mm; display:flex; justify-content:space-between;">
                <div>អ្នកបំពេញ...................................................................</div>
                <div>ឆ្នាំ........ខែ........ទីកន្លែង........</div>
            </div>
        </div>
    </div>
</body>
</html>


