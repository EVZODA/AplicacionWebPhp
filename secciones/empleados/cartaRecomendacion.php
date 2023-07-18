<?php
include("../../db.php");
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("SELECT *,(SELECT nombredelpuesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto FROM tbl_empleados WHERE `tbl_empleados`.`id` =:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $primernombre = $registro["primernombre"];
    $segundonombre = $registro["segundonombre"];
    $primerapellido = $registro["primerapellido"];
    $segundoapellido = $registro["segundoapellido"];

    $nombreCompleto=  $primernombre." ".$segundonombre." ".$primerapellido." ".$segundoapellido;
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $puesto = $registro["puesto"];
    $fechadeingeso = $registro["fechadeingreso"];
    $fechaInicio=new DateTime($fechadeingeso);
    $fechaFin=new DateTime(date('Y-m-d'));
    $diferencia=date_diff($fechaInicio,$fechaFin);
   
}
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendacion</title>
</head>
<body>
    <h1>Carta de recomendacion Laboral</h1>
    <br/><br/>
    Merida Yucatan, Mexico a <strong><?php echo date('d / m / y')?></strong>
    <br/><br/>
    Reciba un saludo cordial
    <br/><br/>
    A travez de estas lineas deseo hacer de su conocimiento que sr(a) <strong><?php echo $nombreCompleto;?></strong>,
    quien ejercicio en mi organizacion durante <strong><?php echo $diferencia->y?> año(s)</strong>
    es un ciudadano con una conducta intachable. Ha demostrado ser un excelente gran trabajador, comprometido, fiel y gran cumplidor de sus tareas.
    Siempre ha manifestado por mejorar sus conocimientos y seguir capacitandose.
    <br/><br/>
    Durante estos años se ha desempeñado como <strong><?php echo $puesto?></strong>
    Es por ello que le sugiero la recomendacion y que siempre estara a la altura de dichos compromisos
    <br/><br/>
    Saludos Atte 
    <br/>
    ing. Juan Martinez
</body>
</html>

<?php
$HTML=ob_get_clean();
require_once('../../libs/autoload.inc.php');
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));
$dompdf->setOptions($opciones);
$dompdf->loadHTML($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf",array("attachment"=>false));
?>