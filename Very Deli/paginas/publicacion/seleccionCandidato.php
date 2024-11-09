<?php

$idPublicacion = $_POST["idPublicacion"];
$idPostulacion = $_POST["idPostulacion"];
$idUsuarioDueño = $_POST["idUsuarioDueño"];
$idSeleccionado = $_POST["idSeleccionado"];

require("../../conexionBD.php");
$conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
if(mysqli_connect_errno()){
    echo "Fallo al conectar con la base de datos";
    exit();
}
mysqli_set_charset($conexion,"utf8");
$consulta = "INSERT INTO candidato_seleccionado(idPostulacion,idPublicacion,idUsuarioDueño,idUsuarioSeleccionado) VALUES ('$idPostulacion','$idPublicacion','$idUsuarioDueño','$idSeleccionado')";
$resultado = mysqli_query($conexion,$consulta);

if($resultado = false){
    echo "Error en la consulta";
}else{
    $consulta ="UPDATE publicacion SET estado = 'resuelta' WHERE idPublicacion = $idPublicacion";
    $resultado = mysqli_query($conexion,$consulta);
    if($resultado = false){
        echo "Error en la consulta para actualizar";
    }
    header("Location: ./publicacionCandidatoSelec.php");
    exit();
}

mysqli_close($conexion);

?>