

<?php
     session_start();
     $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
 
     if (!$idUsuario) {
         header("Location: ../index.php");
         exit();
     }
     $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;

    if(isset($_POST["calificacion"]) && isset($_POST["idUsuarioCalificado"]) && isset($_POST["comentario"]) ){
        $calificacion = $_POST["calificacion"];
        $idUsuarioCalificado = $_POST["idUsuarioCalificado"];
        $idPublicacion = $_POST["idPublicacion"];
        $comentario = $_POST["comentario"];
        $resultadoCalificacion = "";
        require("../../conexionBD.php");
        $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
        if(mysqli_connect_errno()){
            echo "Fallo al conectar con la base de datos";
            exit();
        }
        mysqli_set_charset($conexion,"utf8");

        if($calificacion > 3){
            $resultadoCalificacion = "positiva" ;
        }elseif($calificacion == 3){
            $resultadoCalificacion = "regular";
        }else{
            $resultadoCalificacion = "negativa";
        }

        $consulta = "INSERT INTO calificacion(comentario,valor,idUsuarioCalificado,idUsuarioCalificador,resultado,idPublicacion) VALUES ('$comentario','$calificacion','$idUsuarioCalificado','$idUsuario','$resultadoCalificacion','$idPublicacion')";
        mysqli_query($conexion,$consulta);

        $consultaPromedio = "SELECT AVG(valor) AS promedio_calificacion FROM calificacion WHERE idUsuarioCalificado = $idUsuarioCalificado";
        $resultadoPromedio = mysqli_query($conexion,$consultaPromedio);
        $fila = mysqli_fetch_array($resultadoPromedio);

        $promedio = $fila["promedio_calificacion"];
        $consultaActualizarAvg = "UPDATE usuario SET promedio_puntuacion = $promedio WHERE idUsuario = $idUsuarioCalificado";
        $resultado = mysqli_query($conexion, $consultaActualizarAvg);
        
        if($resultado){
            mysqli_close($conexion);
            header("Location: ../publicaciones-filtradas.php");
        }else{
            echo "Error al hacer la consulta";
        }
    }

?>