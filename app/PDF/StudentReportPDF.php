<?php

namespace App\PDF;

use Dompdf\Dompdf;

class StudentReportPDF
{
    protected $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
    }

    public function generate($content)
    {
        $this->dompdf->loadHtml($content);
        $this->dompdf->setPaper('A4', 'portrait');
        $this->dompdf->render();
        $this->dompdf->stream('student_report.pdf');
    }
}
