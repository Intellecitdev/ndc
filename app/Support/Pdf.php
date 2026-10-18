<?php

namespace App\Support;

use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Symfony\Component\HttpFoundation\Response;

/**
 * Renders a view inside the shared letter-head (resources/views/pdf/layout)
 * and stamps "Page X of Y" in the top-right corner, like the reference PDFs.
 */
class Pdf
{
    public static function stream(string $view, array $data, string $title, string $filename, string $orientation = 'portrait', string $paper = 'a4'): Response
    {
        $pdf = DomPdf::loadView($view, $data + ['pdfTitle' => $title])
            ->setPaper($paper, $orientation)
            ->setOption(['isRemoteEnabled' => false, 'defaultFont' => 'Helvetica']);

        $dompdf = $pdf->getDomPDF();
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('Helvetica');
        $canvas->page_text($canvas->get_width() - 85, 22, 'Page {PAGE_NUM} of {PAGE_COUNT}', $font, 8, [0.2, 0.2, 0.2]);

        return response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'.pdf"',
        ]);
    }
}
