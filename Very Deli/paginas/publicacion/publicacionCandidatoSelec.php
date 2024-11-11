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
    <title>Candidatos</title>
    <link rel="stylesheet" href="estilos-publicacion.css">
    <link rel="icon" href="../login/iconos/logoFondoBlanco.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <a href="../../index.php" class = "vinculo-home">
        <div class="contenedor-logo">
            <img src="../../imagenes/LogoDery.png" alt="logo" class="logo">
            <h1>Very Deli</h1>  
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

    <div class="contenedor-publicacion">
           <?php
           
            require("../../conexionBD.php");
            $idPublicacion = $_SESSION["idPublicacion"];

            $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

            if(mysqli_connect_errno()){
                echo "Fallo al conectar con la base de datos";
                exit();
            }
            mysqli_set_charset($conexion,"utf8");
            $consulta = "SELECT titulo,descripcion,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,volumen,peso,imagen FROM publicacion WHERE idPublicacion = $idPublicacion";
            $resultado = mysqli_query($conexion,$consulta);

            if($fila = mysqli_fetch_array($resultado)){
                echo "<h1>" . $fila["titulo"] . "</h1>";
                echo "<div class='contenedor-datos'>";
                echo    "<div class='contenedor-imagen'>";
                echo        "<img src='../../". $fila["imagen"] ."' class='imagen-publicacion'>";
                echo    "</div>";
                echo    "<div class='contenedor-info'>";
                echo        "<h3>Descripcion: " . $fila["descripcion"] ."</h3>";
                echo        "<h3>Peso: " . $fila["peso"] ."</h3>";
                echo        "<h3>Volumen: " . $fila["volumen"] ."</h3>";
                echo        "<h3>Provincia de origen : " . $fila["provincia_origen"] ."</h3>";
                echo        "<h3>Localidad de origen : " . $fila["localidad_origen"] ."</h3>";
                echo        "<h3>Calle origen : " . $fila["calle_origen"] ."</h3>";
                echo        "<h3>Provincia de destino : " . $fila["provincia_destino"] ."</h3>";   
                echo        "<h3>Localidad de destino : " . $fila["localidad_destino"] ."</h3>";
                echo        "<h3>Calle destino : " . $fila["calle_destino"] ."</h3>";
                echo    "</div>";
                
            }
            $consulta = "SELECT usuario.nombre FROM candidato_seleccionado JOIN usuario ON candidato_seleccionado.idUsuarioSeleccionado = usuario.idUsuario";
            $resultado = mysqli_query($conexion,$consulta);
            if($fila = $fila = mysqli_fetch_array($resultado)){
                echo "<h3>Usuario Seleccionado: " . $fila["nombre"] . "</h3>";
            }

            echo "</div>";
           ?>

    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>