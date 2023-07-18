<?php
include("../../db.php");

if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    //buscar el archivo relacionado con el empleado
    $sentencia = $conexion->prepare("SELECT foto,cv FROM `tbl_empleados` WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registrorecuperado = $sentencia->fetch(PDO::FETCH_LAZY);



    if (isset($registrorecuperado["foto"]) && $registrorecuperado["foto"] != "") {
        if (file_exists("./" . $registrorecuperado["foto"])) {
            unlink("./" . $registrorecuperado["foto"]);
        }
    }




    if (isset($registrorecuperado["cv"]) && $registrorecuperado["cv"] != "") {
        if (file_exists("./" . $registrorecuperado["cv"])) {
            unlink("./" . $registrorecuperado["cv"]);
        }
    }



    $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE `tbl_empleados`.`id` =:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje="Registro eliminado";
    header("location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * , (SELECT nombredelpuesto FROM tbl_puestos WHERE tbl_puestos.id=tbl_empleados.idpuesto limit 1) as puesto FROM `tbl_empleados`");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);


?>



<?php include("../../templates/header.php") ?>


<br />
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">agregar registro</a>
    </div>
    <div class="card-body">

        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Cv</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_empleados as $registro) { ?>
                        <tr class="">
                            <td><?php echo $registro['id'] ?></td>
                            <td scope="row">
                                <?php echo $registro["primernombre"]  ?>
                                <?php echo $registro["segundonombre"]  ?>
                                <?php echo $registro["primerapellido"]  ?>
                                <?php echo $registro["segundoapellido"]  ?>
                            </td>
                            <td>
                                <img width="50" src="<?php echo $registro["foto"]  ?>" class="img-fluid rounded" alt="">

                            </td>
                            <td><a href=""><?php echo $registro["cv"]  ?></a></td>
                            <td><?php echo $registro["puesto"]  ?></td>
                            <td><?php echo $registro["fechadeingreso"]  ?></td>
                            <td>
                                <a name="" id="" class="btn btn-primary" href="cartaRecomendacion.php?txtID=<?php echo $registro['id'] ?>" role="button">carta</a>
                                | <a name="" id="" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id'] ?>" role="button">Editar</a>
                                |<a name="" id="" class="btn btn-danger"  href="javascript:borrar(<?php echo $registro['id'] ?>);" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


    </div>
</div>



<?php include("../../templates/footer.php"); ?>