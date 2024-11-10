<?php
        session_start();
        $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Very Deli</title>
    <link rel="stylesheet" href="./styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">


    <?php
    
        function filtrarPublicaciones($prov_origen,$prov_destino,$local_origen,$local_destino){
            require("./conexionBD.php");
            $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
            
            if(mysqli_connect_errno()){
                echo "Fallo al conectar con la base de datos";
                exit();
            }
            mysqli_set_charset($conexion,"utf8");

            $consulta = "SELECT idPublicacion,titulo,descripcion,volumen,peso,provincia_origen,provincia_destino,localidad_origen,localidad_destino FROM publicacion WHERE provincia_origen = '$prov_origen' AND provincia_destino = '$prov_destino'";
            $resultado = mysqli_query($conexion,$consulta);
        }

    ?>
</head>
<body>
    <header>
            <img src="./imagenes/LogoDery.png" alt="logo" class="logo">
        <div class="btns-login">
            <?php if ($nombreUsuario): ?>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlspecialchars($nombreUsuario); ?></button>
                    <div class="dropdown-content">
                        <a href="./paginas/perfil-usuario/editarPerfil.php"><i class="fas fa-user"></i>Mi perfil</a>
                        <a href="./paginas/publicaciones-filtradas.php"><i class="fas fa-book"></i>Mis publicaciones</a>
                        <a href="./paginas/creacion-postulacion/miPostulaciones.php"><i class="fas fa-briefcase"></i>Mis postulaciones</a>
                        <a href="./paginas/registroVehiculo.php"><i class="fas fa-car"></i>Registrar vehiculo</a>
                        <a href="./paginas/salir.php"><i class="fas fa-sign-out-alt"></i>Salir</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="animated-button-login" href="./paginas/login/inicio.php">Ingresar</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
        <div class="div-main">
            <div class="text-container">
                <h1 class="titulo">Lo pedis y lo dejamos en la puerta de tu casa</h1>
            </div>
            <div class="image-container">
                <img src="./imagenes/delivery.png" alt="Descripción de la imagen" class="img-main">
            </div>
        </div>
        <h2 style="text-align:center;">Todo lo que quieras</h2>
        <div class= "div-info">
            <div class="div-logos">    
                <img class="img-logos" src="./imagenes/logo1.png" alt="camion">
                <h3>Entrega rápida</h3>
                <p>Si lo que pides esta en tu ciudad <span class="highlight">recíbelo en minutos</span></p>
            </div>
            <div class="div-logos">
                <img class="img-logos" src="./imagenes/logo2.png" alt="argentina">
                <h3>En toda Argentina</h3>
                <p>Pide o envia <span class="highlight">desde cualquier parte del pais</span></p>
            </div>
        </div>
        <div class="contenedor-principal">
            <div class="contenedor-filtro">
                <form method="POST">
                    <h3>Buscar publicacion por zona:</h3>
                    <div class="filtro-zona">
                        <label>Provincia:</label>
                        <select id="provincia" onchange="cargarLocalidades()" name="provincia" >
                            <option value="" selected disabled>Seleccione una provincia</option>
                        </select>
                    </div>
                    <div class="filtro-zona">
                        <label>Localidad:</label>
                        <select id="localidad" name="localidad">
                            <option value="" selected disabled>Seleccione una localidad</option>
                        </select>
                    </div>
                    <input type="submit" value="Filtrar" name="filtrar" class="btn-filtrar">
                </form>

                <form method="POST">
                    <h3>Buscar publicacion por descripcion</h3>
                    <div class="filtro-desc">
                        <label for="">Descripcion</label>
                        <input type="text" name="descripcion" placeholder="Ingrese su descripcion">
                    </div>
                    <div class="contendor-btn-filtro">
                        <input type="submit" value="Filtrar" name="filtrar-desc" class="btn-filtrar">
                        <input type="submit" value="Mostrar todas las publicaciones" name="mostrar" class="btn-mostrar">
                    </div>
                </form>
                
                <script>
                    const API_BASE_URL = "https://apis.datos.gob.ar/georef/api";

                    function cargarProvincias() {
                        fetch(`${API_BASE_URL}/provincias`)
                            .then(response => response.json())
                            .then(data => {
                                const provincias = data.provincias;
                                const provinciasSelect = document.getElementById("provincia");

                                provincias.forEach(provincia => {
                                    const option = document.createElement("option");
                                    option.value = provincia.nombre;
                                    option.textContent = provincia.nombre;
                                    provinciasSelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error("Error al cargar las provincias:", error));
                    }

                    function cargarLocalidades() {
                        const provincia = document.getElementById("provincia").value;
                        const localidadSelect = document.getElementById("localidad");

                        localidadSelect.innerHTML = "<option>Seleccione una localidad</option>";

                        if (provincia) {
                            fetch(`${API_BASE_URL}/localidades?provincia=${encodeURIComponent(provincia)}&max=100`)
                                .then(response => response.json())
                                .then(data => {
                                    const localidades = data.localidades;

                                    localidades.forEach(localidad => {
                                        const option = document.createElement("option");
                                        option.value = localidad.nombre;
                                        option.textContent = localidad.nombre;
                                        localidadSelect.appendChild(option);
                                    });
                                })
                                .catch(error => console.error("Error al cargar localidades:", error));
                        }
                    }

                    window.onload = cargarProvincias;
                </script>
            </div>
            <div class="contenedor-lista">
                <?php
                require("./conexionBD.php");
                $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
                
                if(mysqli_connect_errno()){
                    echo "Fallo al conectar con la base de datos";
                    exit();
                }

                mysqli_set_charset($conexion,"utf8");

                $where = "WHERE estado = 'no resuelta'";

                if(isset($_POST["filtrar"])){
                    $provincia = isset($_POST["provincia"]) ? mysqli_real_escape_string($conexion, $_POST["provincia"]) : "";
                    $localidad = isset($_POST["localidad"]) ? mysqli_real_escape_string($conexion, $_POST["localidad"]) : "";
                    if ($provincia && $localidad) {
                        $where .= " AND provincia_origen = '$provincia' AND localidad_origen = '$localidad'";
                    }
                }
                if(isset($_POST["filtrar-desc"])){
                    $descripcion = isset($_POST["descripcion"]) ? mysqli_real_escape_string($conexion, $_POST["descripcion"]) : "";
                    if($descripcion){
                        $where .= " AND (titulo LIKE '%$descripcion%' OR descripcion LIKE '%$descripcion%')";
                    }
                }   
                if(isset($_POST["mostrar"])){
                    $where = "WHERE estado = 'no resuelta'";
                }

                $consulta = "SELECT idPublicacion,titulo,descripcion,volumen,peso,provincia_origen,provincia_destino,localidad_origen,localidad_destino,imagen FROM publicacion  $where";
                $resultado = mysqli_query($conexion,$consulta);

                while($fila = mysqli_fetch_array($resultado)){
                    echo "<div class='publicacion'>";
                    echo    "<div class='imagen-publicacion-container'>"; // Contenedor para la imagen
                    echo        "<img src='./". $fila["imagen"] ."' class='imagen-publicacion'>";
                    echo    "</div>";
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
                    if($nombreUsuario){
                        echo    "<div>";
                        echo        "<form class='form-monto' method='POST' action='./paginas/creacion-postulacion/insertar-postulacion.php'>";
                        echo            "<label>Monto de cobro</label>";
                        echo            "<input type='text' name='monto'>";
                        echo            "<input type='hidden' name='idPublicacion' value='" . $fila['idPublicacion'] . "'>";
                        echo            "<input type='submit' value='Postularme'>";
                        echo        "</form>";
                        echo    "</div>";
                    }
                    echo "</div>";
                }
                mysqli_close($conexion);

                ?>
                <?php
                    if($nombreUsuario){
                        echo " <a href='./paginas/creacion-publicacion/formCrearPublicacion.php'>
                        <div class='crear'>
                        <h4>Crear publicacion</h4>
                        </div>
                        </a>";
                    }
                ?>
            
            </div>
        </div>
    </main>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-row">
                <div class="footer-links">
                    <h4>Compania</h4>
                    <ul>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Nuestros servicios</a></li>
                        <li><a href="#">Politicas de privacidad</a></li>
                        <li><a href="#">Trabaja con nosotros</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Ayuda</h4>
                    <ul>
                        <li><a href="#">Preguntas</a></li>
                        <li><a href="#">Envios</a></li>
                        <li><a href="#">Estado de orden</a></li>
                        <li><a href="#">Pago</a></li>
                        <li><a href="#">verydeli2024@gmail.com</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Integrantes</h4>
                    <ul>
                        <li><a href="#">Enzo Rodriguez</a></li>
                        <li><a href="#">Jeronimo Sturniolo</a></li>
                        <li><a href="#">Ramiro Caceres</a></li>
                    </ul>
                </div>
                <div class="footer-links">
                    <h4>Seguinos!</h4>
                    <div class="footer-social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>  
    </footer>
</body>
</html>