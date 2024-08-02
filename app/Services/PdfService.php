<?php

namespace App\Services;

use Mpdf\Mpdf;

class PdfService
{
    public function createPdf($view, $data = [])
    {
        $mpdf = new Mpdf();
        $html = view($view, $data)->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S'); 
    }
}
