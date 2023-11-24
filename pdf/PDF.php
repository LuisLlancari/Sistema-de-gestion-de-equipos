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
require_once '../models/Cronograma.php';
require_once '../models/Mantenimiento.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if(isset($_POST["operacion"])){

    $equipoPDF          = new Equipo();
    $cronogramaPDF      = new Cronograma();
    $mantenimientoPDF   = new Mantenimiento();

    switch($_POST["operacion"]){

        case 'pdfCategoriasEquipos':

            try {
                /* $reporte = new Html2Pdf("P","A4","es",true, "UTF-8", array(25,15,15,15));
                $reporte->setDefaultFont("Arial"); */
                
                $registros  = $equipoPDF->categoriasEquiposGR();
                $equipos    = $equipoPDF->listar(); 
                // get the HTML
                ob_start();
                /* include dirname(__FILE__).'/res/example07a.php'; */
                include "./contenidosHTML/categoriasEquipos-content.php";
                $content = ob_get_clean();
            
                $html2pdf = new Html2Pdf('P', 'A4', 'fr',);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('pdfCategoriasEquipos.pdf');
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
            
                $formatter = new ExceptionFormatter($e);
                echo $formatter->getHtmlMessage();
            }

            break;
        case 'pdfEstadosEquipos':
        
            try{
                $registros  = $equipoPDF->estadosequiposGR();
                $equipos    = $equipoPDF->listar(); 
                // get the HTML
                ob_start();
                /* include dirname(__FILE__).'/res/example07a.php'; */
                include "./contenidosHTML/estadosEquipos-content.php";
                $content = ob_get_clean();
        
                $html2pdf = new Html2Pdf('P', 'A4', 'fr',);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('pdfEstadosEquipos.pdf');
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
        
                $formatter = new ExceptionFormatter($e);
                echo $formatter->getHtmlMessage();
            }
            break;
        case 'sectoresEquiposGR':
            try{
                $registros  = $equipoPDF->sectoresEquiposGR();
                $equipos    = $equipoPDF->listar(); 
                // get the HTML
                ob_start();
                /* include dirname(__FILE__).'/res/example07a.php'; */
                include "./contenidosHTML/sectoresEquipos-content.php";
                $content = ob_get_clean();
        
                $html2pdf = new Html2Pdf('P', 'A4', 'fr',);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('sectoresEquiposGR.pdf');
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
        
                $formatter = new ExceptionFormatter($e);
                echo $formatter->getHtmlMessage();
            }
            break;
        case 'listar_cronograma_grafico':
            try{
                $datosEnviar = [
                    "fechainicio"   => $_POST["fechainicio"],
                    "fechafin"      => $_POST["fechafin"],
                ];
                $registros      = $cronogramaPDF->listar_cronograma_grafico($datosEnviar);
                $cronogramas    = $cronogramaPDF->listar_cronogramas(); 
                
                // get the HTML
                ob_start();
                /* include dirname(__FILE__).'/res/example07a.php'; */
                include "./contenidosHTML/estadoCronogramas-content.php";
                $content = ob_get_clean();
        
                $html2pdf = new Html2Pdf('P', 'A4', 'fr',);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('listar_cronograma_grafico.pdf');
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
        
                $formatter = new ExceptionFormatter($e);
                echo $formatter->getHtmlMessage();
            }
            break;
        case 'listar_mantenimiento_grafico':
            try{
                $datosEnviar = [
                    "fechainicio"   => $_POST["fechainicio"],
                    "fechafin"      => $_POST["fechafin"],
                ];
                $registros      = $mantenimientoPDF->listar_mantenimiento_grafico($datosEnviar);
                $mantenimientos = $mantenimientoPDF->listar_mantenimiento_informe(); 
                
                // get the HTML
                ob_start();
                /* include dirname(__FILE__).'/res/example07a.php'; */
                include "./contenidosHTML/estadoManteniminetos-content.php";
                $content = ob_get_clean();
        
                $html2pdf = new Html2Pdf('P', 'A4', 'fr',);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content);
                $html2pdf->output('listar_mantenimiento_grafico.pdf');
            } catch (Html2PdfException $e) {
                $html2pdf->clean();
        
                $formatter = new ExceptionFormatter($e);
                echo $formatter->getHtmlMessage();
            }
            break;
    }
}
    
