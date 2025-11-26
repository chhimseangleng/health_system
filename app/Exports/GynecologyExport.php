<?php

namespace App\Exports;

use App\Models\Gynecology;
use App\Models\Medicine;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GynecologyExport
{
    protected static function generateBaseFilename(Gynecology $record): string
    {
        $name = (string) ($record->disease_name ?? $record->name ?? 'record');
        $slug = Str::slug($name, '_');
        return 'gynecology_' . $slug . '_' . (string) ($record->_id ?? 'id');
    }

    protected static function resolveMedicineName(array $medicineMap, ?string $id): string
    {
        if (!$id) { return ''; }
        return $medicineMap[$id] ?? $id;
    }

    public static function savePdf(Gynecology $record, string $view, array $data = []): array
    {
        $base = self::generateBaseFilename($record);
        $downloadName = $base . '.pdf';
        $storagePath = 'exports/' . $downloadName;

        $bytes = self::generatePdf($record, $view, $data);
        Storage::disk('local')->put($storagePath, $bytes);
        return [$storagePath, $downloadName];
    }

    public static function generatePdf(Gynecology $record, string $view, array $data = []): string
    {
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


