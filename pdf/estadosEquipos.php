<?php
/**
 * Html2Pdf Library - example
 *
 * HTML => PDF converter
 * distributed under the OSL-3.0 License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2023 Laurent MINGUET
 */

//1.-Componente COMPOSER
require_once '../vendor/autoload.php';
require_once '../models/Equipo.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if(isset($_POST["operacion"])){

    $equipoPDF = new Equipo();

    switch($_POST["operacion"]){

        case 'pdf1':

            try {
                /* $reporte = new Html2Pdf("P","A4","es",true, "UTF-8", array(25,15,15,15));
                $reporte->setDefaultFont("Arial"); */
                
                $registros  = $equipoPDF->categoriasEquiposGR();
                $equipos    = $equipoPDF->listar(); 
                // get the HTML
                ob_start();
                /* include dirname(__FILE__).'/res/example07a.php'; */
                include 'estadosEquipos-content.php';
                $content = ob_get_clean();
            
                $html2pdf = new Html2Pdf('P', 'A4', 'fr',);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('example07.pdf');
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
            
                $formatter = new ExceptionFormatter($e);
                echo $formatter->getHtmlMessage();
            }

            break;
    }
}
    
