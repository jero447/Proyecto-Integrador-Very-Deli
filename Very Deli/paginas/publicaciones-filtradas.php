<?php
    session_start();
    $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

    if (!$idUsuario) {
        header("Location: ../index.php");
        exit();
    }
    $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./estilos-publicacionFiltrada.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <a href="../index.php" class = "vinculo-home">
        <div class="contenedor-logo">
            <img src="../imagenes/LogoDery.png" alt="logo" class="logo">  
        </div>
        </a>
        <div class="btns-login">
            <?php if ($nombreUsuario): ?>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlspecialchars($nombreUsuario); ?></button>
                    <div class="dropdown-content">
                        <a href="./perfil-usuario/editarPerfil.php"><i class="fas fa-user"></i>Mi perfil</a>
                        <a href="./creacion-postulacion/miPostulaciones.php"><i class="fas fa-briefcase"></i>Mis postulaciones</a>
                        <a href="./registroVehiculo.php"><i class="fas fa-car"></i>Registrar vehiculo</a>
                        <a href="./salir.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="animated-button-login" href="./paginas/inicio.php">Iniciar Sesión</a>
                <a class="animated-button-login" href="./paginas/registro.php">Registrarse</a>
            <?php endif; ?>
        </div>       
    </header>
<main>
<div class="contenedor-lista">

    <h2>Mis publicaciones</h2>
    <?php

    require("../conexionBD.php");
    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la base de datos";
        exit();
    }
    mysqli_set_charset($conexion,"utf8");


    $consulta = "SELECT idPublicacion,titulo, descripcion,provincia_origen, provincia_destino, localidad_origen,localidad_destino,imagen FROM publicacion WHERE idUsuario = $idUsuario AND estado_envio = 'no finalizada'";
    $resultado = mysqli_query($conexion,$consulta);

while($fila = mysqli_fetch_array($resultado)){
        $idPublicacion = $fila["idPublicacion"]; 
        echo "<a href='./publicacion/publicacion.php?idPublicacion=" . urlencode($idPublicacion) . "' class = 'enlacePostulacion'>";
            echo "<div class='publicacion'>";
            echo    "<div class='imagen-publicacion-container'>"; 
            echo "<img src='../" . $fila["imagen"] . "' class='imagen-publicacion'>";
            echo    "</div>";
            echo    "<div class='titulo-desc'>";
            echo        "<h3>" . $fila["titulo"] . "</h3>";
            echo        "<h4>Descripción:</h4>";
            echo        "<p>" . $fila["descripcion"] ."</p>";
            echo    "</div>";
            echo    "<div class='datos-publicacion'>";
            echo        "<div>";
            echo            "<p>Provincia de origen: " . $fila["provincia_origen"] . "</p>";
            echo            "<p>Provincia de destino: " . $fila["provincia_destino"] ."</p>";
            echo        "</div>";
            echo        "<div>";
            echo            "<p>Localidad de origen: " . $fila["localidad_origen"] . "</p>";
            echo            "<p>Localidad de destino: " . $fila["localidad_destino"] ."</p>";
            echo        "</div>";
            echo    "</div>";
            echo "</div>";
        echo "</a>";
}



    ?>
    <div class="contenedor-publicaciones-finalizadas">
        <h2>Mis publicaciones finalizadas</h2>
        <?php
            $consulta = "SELECT idPublicacion,titulo, descripcion,provincia_origen, provincia_destino, localidad_origen,localidad_destino,imagen FROM publicacion WHERE idUsuario = $idUsuario AND estado_envio = 'finalizada'";
            $resultado = mysqli_query($conexion,$consulta);
            while($fila = mysqli_fetch_array($resultado)){
                $idPublicacion = $fila["idPublicacion"];
                echo "<a href='./publicacion/publicacion.php?idPublicacion=" . urlencode($idPublicacion) . "' class = 'enlacePostulacion'>";
                    echo "<div class='publicacion'>";
                    echo    "<div class='titulo-desc'>";
                    echo        "<img src='../". $fila["imagen"] ."' class='imagen-publicacion'>";
                    echo        "<div>";
                    echo             "<h3>" . $fila["titulo"] . "</h3>";
                    echo             "<h4>Descripcion:</h4>";
                    echo             "<p>" . $fila["descripcion"] ."</p>";
                    echo        "</div>";
                    echo    "</div>";
                    echo    "<div class='datos-publicacion'>";
                    echo        "<div>";
                    echo            "<p>Provincia de origen: " . $fila["provincia_origen"] . "</p>";
                    echo            "<p>Provincia de destino: " . $fila["provincia_destino"] ."</p>";
                    echo        "</div>";
                    echo        "<div>";
                    echo            "<p>Localidad de origen: " . $fila["localidad_origen"] . "</p>";
                    echo            "<p>Localidad de destino: " . $fila["localidad_destino"] ."</p>";
                    echo        "</div>";
                    echo    "</div>";
                    echo "</div>";
                echo "</a>";
        }
            mysqli_close($conexion);
        ?>
    </div>
</div>

</main>
</body>
<script>
function confirmDelete() {
    return confirm("¿Estás seguro de que deseas eliminar esta publicación?");
}
</script>
</html>