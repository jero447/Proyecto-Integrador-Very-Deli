<?php

if (isset($_POST["idPublicacion"])) {
    require("../../conexionBD.php");
    $idPublicacion = $_POST["idPublicacion"];
    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la base de datos";
        exit();
    }
    mysqli_set_charset($conexion,"utf8");

    $consulta = "UPDATE publicacion SET estado_envio = 'finalizada' WHERE idPublicacion = $idPublicacion";
    $resultado = mysqli_query($conexion,$consulta);

    $consultaUsuarioDueño = "SELECT publicacion.idUsuario FROM publicacion JOIN usuario ON publicacion.idUsuario = usuario.idUsuario WHERE idPublicacion = $idPublicacion";
    $resultado = mysqli_query($conexion,$consultaUsuarioDueño);
    $fila = mysqli_fetch_array($resultado);

    $idUsuarioDueño = $fila["idUsuario"];
    $consulta = "UPDATE usuario SET publicaciones_activas= publicaciones_activas - 1 WHERE idUsuario = $idUsuarioDueño";
    $resultado = mysqli_query($conexion,$consulta);

    if($resultado){
        mysqli_close($conexion);
        header("Location: ../publicaciones-filtradas.php");
    }else{
        echo "Error al hacer la consulta";
    }
}

        
?>