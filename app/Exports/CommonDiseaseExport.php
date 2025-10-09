<?php

namespace App\Exports;

use App\Models\CommonDisease;
use App\Models\Medicine;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CommonDiseaseExport
{
    /**
     * Generate a filesystem-safe base file name with record name and id.
     */
    protected static function generateBaseFilename(CommonDisease $record): string
    {
        $name = (string) ($record->name ?? 'record');
        $slug = Str::slug($name, '_');
        return 'common_disease_' . $slug . '_' . (string) ($record->_id ?? 'id');
    }

    /**
     * Resolve medicine id to name using a map.
     */
    protected static function resolveMedicineName(array $medicineMap, ?string $id): string
    {
        if (!$id) { return ''; }
        return $medicineMap[$id] ?? $id;
    }

    /**
     * Generate and save CSV for a single record. Returns [storagePath, downloadName].
     */
    public static function saveCsv(CommonDisease $record): array
    {
        $base = self::generateBaseFilename($record);
        $downloadName = $base . '.csv';
        $storagePath = 'exports/' . $downloadName;
        $contents = self::generateCsv($record);

        Storage::disk('local')->put($storagePath, $contents);
        return [$storagePath, $downloadName];
    }

    /**
     * Generate CSV contents in-memory for a single record.
     */
    public static function generateCsv(CommonDisease $record): string
    {
        $medicineMap = Medicine::get(['_id','name'])
            ->mapWithKeys(function ($m) { return [(string) $m->_id => $m->name]; })
            ->all();

        $stream = fopen('php://temp', 'w+');
        fputcsv($stream, ['Name','Category','Physician','Age','Gender','Village','Commune','Updated At','Drug Diagnosis']);
        fputcsv($stream, [
            (string) ($record->name ?? ''),
            (string) ($record->category ?? ''),
            (string) ($record->physician ?? ''),
            (string) ($record->age ?? ''),
            (string) ($record->gender ?? ''),
            (string) ($record->village ?? ''),
            (string) ($record->commune ?? ''),
            optional($record->updated_at)->format('Y-m-d H:i:s'),
            (string) ($record->drug_diagnosis ?? ''),
        ]);

        $prescriptions = $record->prescriptions ?? [];
        if (!empty($prescriptions) && is_array($prescriptions)) {
            fputcsv($stream, []);
            fputcsv($stream, ['Prescriptions']);
            fputcsv($stream, ['Medicine','Total Day','Total Medicine','Morning (M)','Afternoon (A)','Evening (E)']);
            foreach ($prescriptions as $p) {
                $mid = (string) ($p['medicine_id'] ?? '');
                $mname = self::resolveMedicineName($medicineMap, $mid);
                $times = $p['times'] ?? [];
                fputcsv($stream, [
                    $mname,
                    $p['total_day'] ?? '',
                    $p['total_medicine'] ?? '',
                    $times['M']['qty'] ?? '',
                    $times['A']['qty'] ?? '',
                    $times['E']['qty'] ?? '',
                ]);
            }
        }

        rewind($stream);
        $contents = stream_get_contents($stream);
        fclose($stream);
        return $contents;
    }

    /**
     * Generate and save PDF by rendering the given Blade view. Returns [storagePath, downloadName].
     */
    public static function savePdf(CommonDisease $record, string $view, array $data = []): array
    {
        $base = self::generateBaseFilename($record);
        $downloadName = $base . '.pdf';
        $storagePath = 'exports/' . $downloadName;

        $bytes = self::generatePdf($record, $view, $data);
        Storage::disk('local')->put($storagePath, $bytes);
        return [$storagePath, $downloadName];
    }

    /**
     * Generate PDF bytes in-memory for a single record using Dompdf.
     */
    public static function generatePdf(CommonDisease $record, string $view, array $data = []): string
    {
        // Ensure logo is embedded as base64 to avoid path/permission issues in Dompdf
        if (!isset($data['logoBase64'])) {
            $logoPath = public_path('IMG/samaky.png');
            if (is_file($logoPath)) {
                $data['logoBase64'] = base64_encode(file_get_contents($logoPath));
                $data['logoMime'] = 'image/png';
            }
        }

        $html = view($view, $data)->render();
        $dompdf = new Dompdf();
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option('defaultFont', 'DejaVu Sans');
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->output();
    }
}


