<?php
        session_start();
        $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./estilos-postulaciones.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <a href="../../index.php" class="vinculo-home">
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
                        <a href="../perfil-usuario/editarPerfil.php"><i class="fas fa-user"></i>Mi perfil</a>
                        <a href="../publicaciones-filtradas.php"><i class="fas fa-book"></i>Mis publicaciones</a>
                        <a href="../registroVehiculo.php"><i class="fas fa-car"></i>Registrar vehiculo</a>
                        <a href="./paginas/salir.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="animated-button-login" href="./paginas/inicio.php">Iniciar Sesión</a>
                <a class="animated-button-login" href="./paginas/registro.php">Registrarse</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <a href="">
            
        </a>
        <div class="contenedor-lista">
            <?php
            
            require("../../conexionBD.php");
            $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
            
            if(mysqli_connect_errno()){
                echo "Fallo al conectar con la base de datos";
                exit();
            }
            mysqli_set_charset($conexion,"utf8");

            $consulta = "SELECT publicacion.titulo, publicacion.descripcion, publicacion.provincia_origen, publicacion.provincia_destino, publicacion.localidad_origen, publicacion.localidad_destino,publicacion.imagen, monto FROM postulacion JOIN publicacion ON postulacion.idPublicacion = publicacion.idPublicacion";
            $resultado = mysqli_query($conexion,$consulta);

            while($fila = mysqli_fetch_array($resultado)){
                {
                    echo "<a href='' class = 'enlacePostulacion'>";
                    echo "<div class='publicacion'>";
                    echo    "<img src='../../". $fila["imagen"] ."' class='imagen-publicacion'>";
                    echo    "<div class='titulo-desc'>";
                    echo        "<h3>" . $fila["titulo"] . "</h3>";
                    echo        "<h4>Descripcion:</h4>";
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
                    echo    "<div>";
                    echo        "<p>Monto a cobrar: " . $fila["monto"] . "</p>";
                    echo    "</div>";
                    echo "</div>";
                    echo "</a>";
                }
            }
            mysqli_close($conexion);
            
            ?>
        </div>

    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>