<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>បញ្ចីរាយការណ៍ជំងឺ - សម្រាប់បោះពុម្ព</title>
    <style>
        @page { size: A4 landscape; margin: 8mm 8mm 6mm 8mm; }
        * { box-sizing: border-box; }
        body {
            font-family: 'Khmer OS Battambang', system-ui, Arial, sans-serif;
            color: #111827;
            background: #fff;
        }
        .sheet {
            display: flex;
            gap: 12mm;
            justify-content: center;
            align-items: flex-start;
            width: 100%;
        }
        .card {
            border: 1.2px solid #b2b7c5;
            border-radius: 6px;
            width: 198mm;
            min-height: 140mm;
            padding: 0;
            overflow: hidden;
            background: #fff;
            margin-bottom: 0;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 36mm;
            background: #f5f6fa;
            border-bottom: 1.2px solid #b2b7c5;
            padding: 0 8mm 0 6mm;
            position: relative;
        }
        .header .logo {
            width: 23mm;
            height: 23mm;
            object-fit: contain;
            background: #fff;
        }
        .header .org-name {
            flex: 1;
            text-align: center;
            line-height: 1.25;
        }
        .org-name h1 {
            font-size: 15.5px;
            margin: 0 0 2px 0;
            font-weight: bold;
        }
        .org-name .sub {
            font-size: 12px;
        }
        .report-title {
            text-align: center;
            background: #e4e9f2;
            font-weight: bold;
            font-size: 13px;
            letter-spacing: .7px;
            padding: 3px 0;
            border-bottom: 1.2px solid #b2b7c5;
        }
        .meta-row {
            display: flex;
            align-items: center;
            padding: 7px 11mm 7px 11mm;
            font-size: 12px;
            background: #fff;
            border-bottom: 1.2px solid #b2b7c5;
        }
        .meta-cell {
            flex: 1;
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .meta-cell.label {
            flex: none;
            width: 54mm;
            font-weight: 500;
        }
        .meta-cell.value {
            border-bottom: 1.2px dotted #ccc;
            min-width: 42mm;
            height: 21px;
        }
        .report-table-wrap {
            padding: 7px 11mm 0 11mm;
        }
        .report-table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 2.5mm;
            background: #fcfdff;
        }
        .report-table th, .report-table td {
            border: 1.1px solid #b2b7c5;
            padding: 2.5px 3px;
            font-size: 11.5px;
            text-align: center;
        }
        .report-table th {
            background: #e0e3eb;
            font-weight: 600;
        }
        .sect-title {
            font-size: 12.5px;
            font-weight: bold;
            margin-top: 3.5mm;
            margin-bottom: .8mm;
        }
        .note-row {
            display: flex;
            justify-content: space-between;
            margin: 6mm 11mm 0 11mm;
            font-size: 11px;
        }
        .note-sign {
            width: 60%;
            border-bottom: 1px dashed #aaa;
            min-height: 18px;
        }
        .note-meta {
            width: 35%;
            text-align: right;
        }
        @media print {
            html, body { background: #fff; }
            .noprint { display: none !important; }
            .card {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="noprint" style="margin-bottom:12px; text-align:right;">
        <button onclick="window.print()"
                style="padding:8px 14px; background:#1d4ed8; color:#fff; border:none; border-radius:5px; font-size:14px; cursor:pointer;">
            បោះពុម្ព/Print
        </button>
    </div>
    <div class="sheet">
        @for($copy=0; $copy<2; $copy++)
        <div class="card">
            <div class="header">
                <img src="{{ asset('IMG/samaky.png') }}" class="logo" alt="Logo">
                <div class="org-name">
                    <h1>មណ្ឌលសុខភាពសាមគ្គី</h1>
                    <div class="sub">ខេត្តបាត់ដំបង</div>
                </div>
                <div style="width:24mm"></div>
            </div>
            <div class="report-title">បញ្ជីរាយការណ៍រោគសញ្ញា/ជំងឺ សាខាសុខភាព</div>
            <div class="meta-row">
                <div class="meta-cell label">ឈ្មោះអង្គភាព/ឈ្មោះអ្នករាយការណ៍:</div>
                <div class="meta-cell value"></div>
                <div style="width:16px;"></div>
                <div class="meta-cell label">ទីតាំង/ភូមិ:</div>
                <div class="meta-cell value"></div>
            </div>
            <div class="meta-row" style="background:#f9fafb;">
                <div class="meta-cell label">ខែ/ឆ្នាំ:</div>
                <div class="meta-cell value"></div>
                <div class="meta-cell label" style="width:auto;">កាលបរិច្ឆេទបញ្ចូនរបាយការណ៍:</div>
                <div class="meta-cell value"></div>
            </div>
            <div class="report-table-wrap">
                <div class="sect-title">ព័ត៌មានអ្នកជំងឺ</div>
                <table class="report-table">
                    <thead>
                        <tr>
                            <th class="row-number">ល.រ</th>
                            <th>ឈ្មោះជំងឺ/រោគសញ្ញា</th>
                            <th>ប្រភេទ/អាការៈ</th>
                            <th>ល.រ សំគាល់ភេទ</th>
                            <th>អាយុ</th>
                            <th>ស្រី</th>
                            <th>ប្រុស</th>
                            <th>លេខទូរស័ព្ទ</th>
                            <th>ភូមិ</th>
                            <th>ចំណាំ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(($diseases ?? []) as $i => $d)
                            <tr>
                                <td class="row-number">{{ $i + 1 }}</td>
                                <td>{{ $d->name }}</td>
                                <td>{{ $d->category }}</td>
                                <td>{{ $d->gender }}</td>
                                <td>{{ $d->age }}</td>
                                <td>@if(isset($d->gender) && $d->gender == 'ស្រី') 1 @endif</td>
                                <td>@if(isset($d->gender) && $d->gender == 'ប្រុស') 1 @endif</td>
                                <td>{{ $d->phone ?? '' }}</td>
                                <td>{{ $d->village }}</td>
                                <td>{{ $d->note ?? '' }}</td>
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
                                </tr>
                            @endfor
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="sect-title" style="margin-bottom: 1.2mm; margin-left:11mm;">កត់សម្គាល់</div>
            <div style="height:26px; border:1px solid #cbd5e1; background:#fafdff; margin:0 11mm 0 11mm;"></div>
            <div class="note-row">
                <div class="note-sign">ឈ្មោះអ្នកបំពេញ .................................</div>
                <div class="note-meta">
                    ថ្ងៃទី ............. ខែ ............. ឆ្នាំ ............., កន្លែង...........................
                </div>
            </div>
        </div>
        @endfor
    </div>
</body>
</html>
