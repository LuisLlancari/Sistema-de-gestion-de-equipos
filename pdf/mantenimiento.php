  <?php
  require '../vendor/autoload.php';
  //2. Namespaces
  use Spipu\Html2Pdf\Html2Pdf; //CORE
  use Spipu\Html2Pdf\Exception\Html2PdfException;  //EXCEPCIONES
  use Spipu\Html2Pdf\Exception\ExceptionFormatter; //FORMATEAR
  
  
  try {
    //Intentar => acciones que deceamos ejecutar
  
    //3. Instancia
    //constructor(Orientacíon, tipopapel, idioma, )
    $reporte = new Html2Pdf("P","A4","es",true,"UTF-8",array(15,5,15,5 ));
    $reporte -> setDefaultFont("Arial");
  
    //Actualizacion
    //Ahora nuestro archivo e contenido recibira datos dinamicos
    $desarrollador= "Luis Llancari";

    $dataTable = [
      ["sede" => "Chincha", "Carrera"=>"Ignieria de Software"],
      ["sede" => "Pisco", "Carrera"=>"Mecanica Automotriz"],
      ["sede" => "Ica", "Carrera"=>"Mecanica Industrial"]
    ];
  
  
  
  
  
    //Inicia la lectura del archivo
    ob_start();
    // include './estilos.html';
    include './mantenimiento-contenido.php';
  
    $contenido = ob_get_clean();
  
    $reporte -> writeHTML($contenido);
  
    $reporte -> output("SENATI.pdf");
    
  
  
  
  } catch (Html2PdfException $e) {
    //ERROR => debemos realizar alguna accion
    $reporte->clean();
    $datosError = new ExceptionFormatter($e);
  
  
    echo $datosError->getHtmlMessage();
  }


  ?>