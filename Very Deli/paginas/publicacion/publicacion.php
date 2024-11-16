<?php
    session_start();
    $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

    if (!$idUsuario) {
        header("Location: ../../index.php");
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
                        <a href="../perfil-usuario/editarPerfil.php"><i class="fas fa-user"></i>Mi perfil</a>
                        <a href="../creacion-postulacion/miPostulaciones.php"><i class="fas fa-briefcase"></i>Mis postulaciones</a>
                        <a href="../publicaciones-filtradas.php"><i class="fas fa-book"></i>Mis publicaciones</a>
                        <a href="../registroVehiculo.php"><i class="fas fa-car"></i>Registrar vehiculo</a>
                        <a href="../salir.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
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
            $idPublicacion = $_GET["idPublicacion"];
            $idUsuarioSeleccionado = 0;
            $_SESSION["idPublicacion"] = $idPublicacion;
            if (isset($_GET["idPublicacion"])) {
                $idPublicacion = $_GET["idPublicacion"];
            } else {
                header("Location: " . "../publicaciones-filtradas.php");
                exit();
            }

            $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

            if(mysqli_connect_errno()){
                echo "Fallo al conectar con la base de datos";
                exit();
            }
            mysqli_set_charset($conexion,"utf8");

            $consultaEstado = "SELECT estado,estado_envio FROM publicacion WHERE idPublicacion = $idPublicacion";
            $resultado = mysqli_query($conexion,$consultaEstado);
            $fila = mysqli_fetch_array($resultado);
            if($fila["estado"] == "no resuelta"){
                $consulta = "SELECT titulo,descripcion,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,volumen,peso,imagen FROM publicacion WHERE idPublicacion = $idPublicacion";
                $resultado = mysqli_query($conexion,$consulta);
                if($fila = mysqli_fetch_array($resultado)){
                    echo "<h1>" . $fila["titulo"] . "</h1>";
                    echo "<div class='contenedor-datos'>";
                    echo    "<div class='contenedor-imagen'>";
                    echo        "<img src='../../". $fila["imagen"] ."' class='imagen-publicacion'>";
                    echo    "</div>";
                    echo    "<div class='contenedor-info'>";
                    echo        "<h3>Descripción: " . $fila["descripcion"] ."</h3>";
                    echo        "<h3>Peso: " . $fila["peso"] ." KG</h3>";
                    echo        "<h3>Volumen: " . $fila["volumen"] ." Metros</h3>";
                    echo        "<h3>Provincia de origen : " . $fila["provincia_origen"] ."</h3>";
                    echo        "<h3>Localidad de origen : " . $fila["localidad_origen"] ."</h3>";
                    echo        "<h3>Calle origen : " . $fila["calle_origen"] ."</h3>";
                    echo        "<h3>Provincia de destino : " . $fila["provincia_destino"] ."</h3>";   
                    echo        "<h3>Localidad de destino : " . $fila["localidad_destino"] ."</h3>";
                    echo        "<h3>Calle destino : " . $fila["calle_destino"] ."</h3>";
                    echo    "</div>";
                    echo "</div>";

                    echo "<div class='postulantes'>";
                    echo    "<h2>Lista de postulantes</h2>";
                    echo    "<table class='contenedor-lista-postulantes'>";
                    echo        "<tr>";
                    echo            "<th>Nombre</th>";
                    echo            "<th>Monto</th>";
                    echo            "<th>Puntuacion</th>";
                    echo            "<th>Estado</th>";
                    echo            "<th></th>";
                    echo        "</tr>";

                    $consultaPostulantes = "SELECT postulacion.idPostulacion,postulacion.idUsuario, usuario.nombre, postulacion.monto, usuario.promedio_puntuacion FROM postulacion JOIN usuario ON postulacion.idUsuario = usuario.idUsuario WHERE postulacion.idPublicacion = $idPublicacion";
                    $resultadoConsulta = mysqli_query($conexion,$consultaPostulantes);
                    
                    while($fila = mysqli_fetch_array($resultadoConsulta)){
                        echo "<tr class='info-candidatos'>";
                        echo    "<td>". $fila["nombre"] ."</td>";
                        echo    "<td>". $fila["monto"] ."</td>";
                        echo    "<td>". $fila["promedio_puntuacion"] ."</td>";
                        if($fila["promedio_puntuacion"] >= 3.5){
                            echo  "<td>Responsable</td>";
                        }else{
                            echo  "<td>No responsable</td>";
                        }
                        echo    "<td>";
                        echo        "<form action='seleccionCandidato.php'  method='POST'>";
                        echo            "<button class='btn-elegir'>Elegir candidato</button>";
                        echo            "<input type='hidden' name='idPostulacion' value='" . $fila["idPostulacion"] ."'>";
                        echo            "<input type='hidden' name='idPublicacion' value='" . $idPublicacion . "'>";
                        echo            "<input type='hidden' name='idUsuarioDueño' value='" . $idUsuario . "'>";
                        echo            "<input type='hidden' name='idSeleccionado' value='" . $fila["idUsuario"] . "'>";
                        echo        "</form>";
                        echo    "</td>";
                        echo "</tr>";
                    }
                    echo    "</table>";
                    echo    "</div>";
                }
            }elseif($fila["estado_envio"] == "finalizada"){

                $consulta = "SELECT * FROM calificacion JOIN usuario AS usuario_calificado ON calificacion.idUsuarioCalificado = usuario_calificado.idUsuario JOIN usuario AS usuario_calificador ON calificacion.idUsuarioCalificador = usuario_calificador.idUsuario JOIN publicacion ON calificacion.idPublicacion = publicacion.idPublicacion WHERE calificacion.idUsuarioCalificador = $idUsuario AND calificacion.idPublicacion = $idPublicacion";
                $resultado = mysqli_query($conexion,$consulta);
                if(mysqli_num_rows($resultado) > 0){

                    $consulta = "SELECT titulo,descripcion,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,volumen,peso,imagen FROM publicacion WHERE idPublicacion = $idPublicacion";
                    $resultado = mysqli_query($conexion,$consulta);

                    if($fila = mysqli_fetch_array($resultado)){
                        $imagen = $fila["imagen"];
                        echo "<h1>" . $fila["titulo"] . "</h1>";
                        echo "<h2 class='cartel-finalizada'>Finalizada</h2>";
                        echo "<div class='contenedor-datos'>";
                        echo    "<div class='contenedor-info'>";
                        echo        "<h3>Descripcion: " . $fila["descripcion"] ."</h3>";
                        echo        "<h3>Peso: " . $fila["peso"] ." KG</h3>";
                        echo        "<h3>Volumen: " . $fila["volumen"] ." Metros</h3>";
                        echo        "<h3>Provincia de origen : " . $fila["provincia_origen"] ."</h3>";
                        echo        "<h3>Localidad de origen : " . $fila["localidad_origen"] ."</h3>";
                        echo        "<h3>Calle origen : " . $fila["calle_origen"] ."</h3>";
                        echo        "<h3>Provincia de destino : " . $fila["provincia_destino"] ."</h3>";   
                        echo        "<h3>Localidad de destino : " . $fila["localidad_destino"] ."</h3>";
                        echo        "<h3>Calle destino : " . $fila["calle_destino"] ."</h3>";
                        echo    "</div>";
                    }
                    $consulta = "SELECT usuario.nombre,usuario.idUsuario FROM candidato_seleccionado JOIN usuario ON candidato_seleccionado.idUsuarioSeleccionado = usuario.idUsuario WHERE idPublicacion = $idPublicacion";
                    $resultado = mysqli_query($conexion,$consulta);
                    if($fila = mysqli_fetch_array($resultado)){
                        $idUsuarioSeleccionado = $fila["idUsuario"];
                        echo "<div class='usuario-seleccionado'>";
                        echo "<h3>Usuario Seleccionado: " . $fila["nombre"] . "</h3>";
                        echo "<div class='contenedor-imagen'>";
                        echo    "<img src='../../$imagen' class='imagen-publicacion'>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                    echo '<div class="calidicar-finalizada">';
                    echo '    <h2>Calificar transportista</h2>';
                    echo '    <h4>Ya has calificado en esta publicacion</h4>';
                    echo "</div>";
                }else{
                    $consulta = "SELECT titulo,descripcion,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,volumen,peso,imagen FROM publicacion WHERE idPublicacion = $idPublicacion";
                    $resultado = mysqli_query($conexion,$consulta);

                    if($fila = mysqli_fetch_array($resultado)){
                        $imagen = $fila["imagen"];
                        echo "<h1>" . $fila["titulo"] . "</h1>";
                        echo "<h2 class='cartel-finalizada'>Finalizada</h2>";
                        echo "<div class='contenedor-datos'>";
                        echo    "<div class='contenedor-info'>";
                        echo        "<h3>Descripcion: " . $fila["descripcion"] ."</h3>";
                        echo        "<h3>Peso: " . $fila["peso"] ." KG</h3>";
                        echo        "<h3>Volumen: " . $fila["volumen"] ." Metros</h3>";
                        echo        "<h3>Provincia de origen : " . $fila["provincia_origen"] ."</h3>";
                        echo        "<h3>Localidad de origen : " . $fila["localidad_origen"] ."</h3>";
                        echo        "<h3>Calle origen : " . $fila["calle_origen"] ."</h3>";
                        echo        "<h3>Provincia de destino : " . $fila["provincia_destino"] ."</h3>";   
                        echo        "<h3>Localidad de destino : " . $fila["localidad_destino"] ."</h3>";
                        echo        "<h3>Calle destino : " . $fila["calle_destino"] ."</h3>";
                        echo    "</div>";
                    }
                    $consulta = "SELECT usuario.nombre,usuario.idUsuario FROM candidato_seleccionado JOIN usuario ON candidato_seleccionado.idUsuarioSeleccionado = usuario.idUsuario WHERE idPublicacion = $idPublicacion";
                    $resultado = mysqli_query($conexion,$consulta);
                    if($fila = mysqli_fetch_array($resultado)){
                        $idUsuarioSeleccionado = $fila["idUsuario"];
                        echo "<div class='usuario-seleccionado'>";
                        echo "<h3>Usuario Seleccionado: " . $fila["nombre"] . "</h3>";
                        echo "<div class='contenedor-imagen'>";
                        echo    "<img src='../../$imagen' class='imagen-publicacion'>";
                        echo "</div>";
                        echo "</div>";
                    }
                    
                    echo "</div>";
                    echo '<div>';
                    echo '    <h2>Calificar transportista</h2>';
                    echo '    <form action="../calificacion/inserciones-calificaciones.php" method="POST">';
                    echo '        <input type="hidden" name="idPublicacion" value="' . $idPublicacion . '">';
                    echo '        <input type="hidden" name="idUsuarioCalificado" value="' . $idUsuarioSeleccionado . '">';
                    echo '        <div class="contenedor-calificacion">';
                    echo '          <div class="contenedor-estrellas-all">';
                    echo '              <div class="contenedor-estrellas">';
                    echo '                 <input type="radio" id="estrella-1" name="calificacion" value="1" >';
                    echo '                 <label class="estrella" for="estrella-1">&#9733;</label>';
                    echo '              </div>';
                    echo '              <div class="contenedor-estrellas">';
                    echo '                 <input type="radio" id="estrella-2" name="calificacion" value="2" >';
                    echo '                 <label class="estrella" for="estrella-2">&#9733;&#9733;</label>';
                    echo '              </div>';
                    echo '              <div class="contenedor-estrellas">';
                    echo '                 <input type="radio" id="estrella-3" name="calificacion" value="3" >';
                    echo '                 <label class="estrella" for="estrella-3">&#9733;&#9733;&#9733;</label>';
                    echo '              </div>';
                    echo '              <div class="contenedor-estrellas">';
                    echo '                 <input type="radio" id="estrella-4" name="calificacion" value="4" >';
                    echo '                 <label class="estrella" for="estrella-4">&#9733;&#9733;&#9733;&#9733;</label>';
                    echo '              </div>';
                    echo '              <div class="contenedor-estrellas">';
                    echo '                 <input type="radio" id="estrella-5" name="calificacion" value="5" >';
                    echo '                 <label class="estrella" for="estrella-5">&#9733;&#9733;&#9733;&#9733;&#9733;</label>';
                    echo '              </div>';
                    echo '          </div>';
                    echo '          <div class="contenedor-comentario">';
                    echo '              <label>Escribe algun comentario</label>';
                    echo '              <textarea name="comentario"></textarea>';
                    echo '              <input type="submit" value="Enviar calificacion">';
                    echo '          </div>';
                    echo '        </div>';
                    
                    echo '    </form>';
                    echo '</div>';
                }   
            }else{
                $consulta = "SELECT titulo,descripcion,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,volumen,peso,imagen FROM publicacion WHERE idPublicacion = $idPublicacion";
                $resultado = mysqli_query($conexion,$consulta);

                if($fila = mysqli_fetch_array($resultado)){
                    $imagen = $fila["imagen"];
                    echo "<h1>" . $fila["titulo"] . "</h1>";
                    echo "<div class='contenedor-datos'>";
                    echo    "<div class='contenedor-info'>";
                    echo        "<h3>Descripcion: " . $fila["descripcion"] ."</h3>";
                    echo        "<h3>Peso: " . $fila["peso"] ." KG</h3>";
                    echo        "<h3>Volumen: " . $fila["volumen"] ." Metros</h3>";
                    echo        "<h3>Provincia de origen : " . $fila["provincia_origen"] ."</h3>";
                    echo        "<h3>Localidad de origen : " . $fila["localidad_origen"] ."</h3>";
                    echo        "<h3>Calle origen : " . $fila["calle_origen"] ."</h3>";
                    echo        "<h3>Provincia de destino : " . $fila["provincia_destino"] ."</h3>";   
                    echo        "<h3>Localidad de destino : " . $fila["localidad_destino"] ."</h3>";
                    echo        "<h3>Calle destino : " . $fila["calle_destino"] ."</h3>";
                    echo    "</div>";
                }
                $consulta = "SELECT usuario.nombre FROM candidato_seleccionado JOIN usuario ON candidato_seleccionado.idUsuarioSeleccionado = usuario.idUsuario WHERE idPublicacion = $idPublicacion";
                $resultado = mysqli_query($conexion,$consulta);
                if($fila = mysqli_fetch_array($resultado)){
                    echo "<div class='usuario-seleccionado'>";
                    echo "<h3>Usuario Seleccionado: " . $fila["nombre"] . "</h3>";
                    echo "<div class='contenedor-imagen'>";
                    echo    "<img src='../../$imagen' class='imagen-publicacion'>";
                    echo "</div>";
                    echo "</div>";
                }
                
                echo "</div>";
            }
                ?>
           <div class="seccion-mensajes">
                <h2>Mensajes</h2>
                <?php

                    $consulta = "SELECT COUNT(*) AS mensajesTotales FROM mensajes WHERE mensajes.idPublicacion = $idPublicacion";
                    $resultado = mysqli_query($conexion,$consulta);
                    if($fila = $fila = mysqli_fetch_array($resultado)){
                        echo "<h3>" . $fila["mensajesTotales"] . " comentarios</h3>";
                    }
                
                ?>
                <div>
                    <form action="./enviarMensaje.php" method="POST">
                        <input type="hidden" name="idPublicacion" value="<?php echo $idPublicacion; ?>">
                        <input type="text" name="mensaje">
                        <input type="submit" value="Enviar Mensaje">
                    </form>
                </div>
                <div class="contenedor-mensajes">
                    <?php
                    
                        $consulta = "SELECT usuario.nombre,publicacion.idUsuario as idDueño,contenido, mensajes.idUsuario FROM mensajes JOIN usuario ON mensajes.idUsuario = usuario.idUsuario JOIN publicacion ON mensajes.idPublicacion = publicacion.idPublicacion WHERE mensajes.idPublicacion = $idPublicacion";
                        $resultado = mysqli_query($conexion,$consulta);

                        while($fila = $fila = mysqli_fetch_array($resultado)){
                            if($fila["idDueño"] == $fila["idUsuario"]){
                                echo   "<div class='mensaje'>";
                                echo       "<p>Dueño de la publicacion</p>";
                                echo       "<h3>" . $fila["nombre"] . "</h3>";
                                echo       "<p>" . $fila["contenido"] . "</p>";
                                echo   "</div>";
                            }else{
                                echo   "<div class='mensaje'>";
                                echo       "<h3>" . $fila["nombre"] . "</h3>";
                                echo       "<p>" . $fila["contenido"] . "</p>";
                                echo   "</div>";
                            }
                        }

                    ?>
                </div>
           </div>
        </div>
    </main>
</body>
</html>