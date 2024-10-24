<?php
        session_start();
        $idUsuario = $_SESSION["idUsuario"] ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    
    $monto = $_POST["monto"];
    $idPublicacion = $_POST["idPublicacion"];

    require("../../conexionBD.php");
    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la base de datos";
        exit();
    }
    mysqli_set_charset($conexion,"utf8");
    $consulta = "INSERT INTO postulacion (monto,idPublicacion,idUsuario) VALUES ('$monto','$idPublicacion',$idUsuario)";
    $resultado = mysqli_query($conexion,$consulta);
    
    if($resultado = false){
        echo "Error en la consulta";
    }else{
        header("Location: ../../index.php");
        exit();
    }

    mysqli_close($conexion);

    ?>
</body>
</html>