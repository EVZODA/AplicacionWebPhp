<?php include ("../../templates/header.php") ?>

<?php

include ("../../db.php");

if ($_POST){
  //recolectamos los datos del datos del metodos del metodo post
$nombredelpuesto=(isset($_POST['nombredelpuesto'])?$_POST['nombredelpuesto']:"");
//preparar la insercicion de los datos
$sentencia=$conexion->prepare("INSERT INTO tbl_puestos(id,nombredelpuesto) VALUES (null, :nombredelpuesto)");
//asignando los valores que vienen del metodo post del formulario
$sentencia->bindParam(":nombredelpuesto",$nombredelpuesto);
$sentencia->execute();
$mensaje="Registro agregado";
header("location:index.php?mensaje=".$mensaje);
}

?>

<br/>

<div class="card">
    <div class="card-header">
        puestos
    </div>
    <div class="card-body">
      <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
          <label for="nombredelpuesto" class="form-label">Nombre del puesto:</label>
          <input type="text"
            class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="nombre del puesto">
        </div>

        <button type="submit" class="btn btn-success">Agregar</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
      </form>
    </div>
</div>

<?php include ("../../templates/footer.php") ;?>