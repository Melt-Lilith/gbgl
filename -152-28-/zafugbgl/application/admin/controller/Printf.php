<?php
namespace app\admin\controller;
use think\Db;
class Printf extends Common
{
    public function index(){
           $f=file_get_contents("http://192.168.20.185/gbgl/public/index.php/admin/article/");
           dump($f);
            vendor('tcpdf.tcpdf'); 
 $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
         $pdf->SetCreator(PDF_CREATOR);
         
          $pdf->SetHeaderData("", 70, 'wanglibao Agreement' . '', '');
         $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
          $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
          $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
         $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
         $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
         $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
         $pdf->AddPage();
         $pdf->setPageMark();
         $pdf->SetFont('stsongstdlight', '', 13);
   
 
         //$pdf->writeHTML($title, true, false, false, false, '');
        $pdf->writeHTML($f, true, 0, true, true);
 //         $pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, 'C', true);
         $pdf->lastPage();
        
$pdf->Output('D:\phpStudy\WWW\gbgl\t1.pdf', 'F');
      
    }
}