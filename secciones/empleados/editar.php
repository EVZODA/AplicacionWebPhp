<?php
include("../../db.php");
if (isset($_GET['txtID'])) {
    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";
    $sentencia = $conexion->prepare("SELECT * FROM tbl_empleados WHERE `tbl_empleados`.`id` =:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    $primernombre = $registro["primernombre"];
    $segundonombre = $registro["segundonombre"];
    $primerapellido = $registro["primerapellido"];
    $segundoapellido = $registro["segundoapellido"];
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $fechadeingeso = $registro["fechadeingreso"];
    $sentencia = $conexion->prepare("SELECT * FROM `tbl_puestos`");
    $sentencia->execute();
    $lista_tbl_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

if ($_POST) {
    //recolectamos los datos del datos del metodos del metodo post
    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $primernombre = (isset($_POST['primernombre']) ? $_POST['primernombre'] : "");
    $segundonombre = (isset($_POST['segundonombre']) ? $_POST['segundonombre'] : "");
    $primerapellido = (isset($_POST['primerapellido']) ? $_POST['primerapellido'] : "");
    $segundoapellido = (isset($_POST['segundoapellido']) ? $_POST['segundoapellido'] : "");
    $idpuesto = (isset($_POST['idpuesto']) ? $_POST['idpuesto'] : "");
    $fechadeingreso = (isset($_POST['fechadeingreso']) ? $_POST['fechadeingreso'] : "");
    $sentencia = $conexion->prepare("UPDATE `tbl_empleados` SET
     primernombre=:primernombre,
     segundonombre=:segundonombre,
     primerapellido=:primerapellido,
     segundoapellido=:segundoapellido,
     idpuesto=:idpuesto,
     fechadeingreso=:fechadeingreso
     WHERE id=:id");
    $sentencia->bindParam(":primernombre", $primernombre);
    $sentencia->bindParam(":segundonombre", $segundonombre);
    $sentencia->bindParam(":primerapellido", $primerapellido);
    $sentencia->bindParam(":segundoapellido", $segundoapellido);
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje="Registro Editado";
     header("location:index.php?mensaje=".$mensaje);

    $fecha = new DateTime();
    $foto = (isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "");
    $nombrearchivofoto = ($foto != "") ? $fecha->getTimestamp() . "_" . $_FILES['foto']['name'] : "";
    $tmp_foto = $_FILES['foto']['tmp_name'];

    if ($tmp_foto != "") {
        move_uploaded_file($tmp_foto, "./" . $nombrearchivofoto);
        $sentencia = $conexion->prepare("SELECT foto FROM `tbl_empleados` WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registrorecuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registrorecuperado["foto"]) && $registrorecuperado["foto"] != "") {
            if (file_exists("./" . $registrorecuperado["foto"])) {
                unlink("./" . $registrorecuperado["foto"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `tbl_empleados` SET foto=:foto WHERE id=:id");
        $sentencia->bindParam(":foto", $nombrearchivofoto);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $mensaje="Registro editado";
        header("location:index.php?mensaje=".$mensaje);
    }


    $cv = (isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : "");
    $nombrearchivo_cv = ($cv != "") ? $fecha->getTimestamp() . "_" . $_FILES['cv']['name'] : "";
    $tmp_cv = $_FILES['cv']['tmp_name'];
    if ($tmp_cv != "") {
        move_uploaded_file($tmp_cv, "./" . $nombrearchivo_cv);
        $sentencia = $conexion->prepare("SELECT cv FROM `tbl_empleados` WHERE id=:id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $registrorecuperado = $sentencia->fetch(PDO::FETCH_LAZY);
        if (isset($registrorecuperado["cv"]) && $registrorecuperado["cv"] != "") {
            if (file_exists("./" . $registrorecuperado["cv"])) {
                unlink("./" . $registrorecuperado["cv"]);
            }
        }

        $sentencia = $conexion->prepare("UPDATE `tbl_empleados` SET cv=:cv WHERE id=:id");
        $sentencia->bindParam(":cv", $nombrearchivo_cv);
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
        $mensaje="Registro editado";
        header("location:index.php?mensaje=".$mensaje);
    }
}
?>


<?php include("../../templates/header.php") ?>

<br />
<div class="card">
    <div class="card-header">
        datos del empleado
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID ?>" class="form-control" readonly name="txtID" id="txtID" aria-describedby="helpId" placeholder="ID">
            </div>

            <div class="mb-3">
                <label for="primernombre" class="form-label">primer nombre</label>
                <input type="text" value="<?php echo $primernombre ?>" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Primer nombre">
            </div>
            <div class="mb-3">
                <label for="segundonombre" class="form-label">segundo nombre</label>
                <input type="text" value="<?php echo $segundonombre ?>" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Segundo nombre">
            </div>
            <div class="mb-3">
                <label for="primerapellido" class="form-label">primer apellido</label>
                <input type="text" value="<?php echo $primerapellido ?>" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Primer apellido">
            </div>
            <div class="mb-3">
                <label for="segundoapellido" class="form-label">segundo apellido</label>
                <input type="text" value="<?php echo $segundoapellido ?>" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Segundo apellido">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <br />
                <img width="100" src="<?php echo $foto ?>" class="rounded" alt="">
                <br /><br />

                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">
            </div>
            <div class="mb-3">
                <label for="cv" class="form-label">CV(PDF):</label>
                <br />
                <a href=" <?php echo $cv ?>"> <?php echo $cv ?></a>
                <input type="file" class="form-control" name="cv" id="cv" placeholder="CV" aria-describedby="fileHelpId">
            </div>
            <div class="mb-3">
                <label for="idpuesto" class="form-label">puesto:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($lista_tbl_puestos as $registro) { ?>
                        <option <?php echo ($idpuesto == $registro['id']) ? "selected" : "" ?> value="<?php echo $registro['id'] ?>"><?php echo $registro['nombredelpuesto'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de ingreso:</label>
                <input type="date" value="<?php echo $fechadeingeso ?>" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="abc@mail.com">
            </div>
            <button type="submit" class="btn btn-success">Editar registro</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">cancelar</a>
        </form>
    </div>
</div>

<?php include("../../templates/footer.php"); ?>