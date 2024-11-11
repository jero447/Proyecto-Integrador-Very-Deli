<?php

session_start();
$idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

if (!$idUsuario) {
    header("Location: ../index.php");
    exit();
}
$nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;

require("./conexionBD.php"); 

$responsable = false;

$conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

if(mysqli_connect_errno()){
    echo "Fallo al conectar con la base de datos";
    exit();
}
mysqli_set_charset($conexion,"utf8");

$consulta = "SELECT promedio_puntuacion,postulaciones_activas FROM usuario WHERE idUsuario = $idUsuario";
$resultado = mysqli_query($conexion,$consulta);
$fila = mysqli_fetch_array($resultado);
$promedio = $fila["promedio_puntuacion"];
$cantPostActivas = $fila["postulaciones_activas"];

if($promedio >= 3.5){
    $responsable = true;
}elseif($cantPostActivas == 0 ){
    $responsable =true;
}
mysqli_close($conexion);

header("Content-Type: application/json");
echo json_encode(["responsable" => $responsable]);
?>