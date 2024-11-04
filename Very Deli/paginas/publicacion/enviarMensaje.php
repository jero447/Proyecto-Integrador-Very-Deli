<?php
    session_start();
    $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

    if (!$idUsuario) {
        header("Location: ../index.php");
        exit();
    }
    $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;


    $idPublicacion = $_POST["idPublicacion"];
    echo $idPublicacion;
    $mensaje = $_POST["mensaje"];
    
    require("../../conexionBD.php");


    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la base de datos";
        exit();
    }
    mysqli_set_charset($conexion,"utf8");


    $consulta = "INSERT INTO mensajes (idPublicacion, idUsuario, contenido) VALUES ('$idPublicacion', '$idUsuario', '$mensaje')";
    $resultado = mysqli_query($conexion,$consulta);

    if($resultado = false){
        echo "Error en la consulta";
    }else{
        header("Location: ./publicacion.php");
        exit();
    }
    

?>


