<?php
        session_start();
        $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicacion</title>
    <link rel="stylesheet" href="estilosCrearPublicacion.css">
    <link rel="icon" href="../login/iconos/logoFondoBlanco.png" type="image/x-icon">
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
                <a href="../perfil-usuario/editarPerfil.php"><i class="fas fa-user"></i> Mi perfil</a>
                <a href="../publicaciones-filtradas.php"><i class="fas fa-book"></i> Mis publicaciones</a>
                <a href="./paginas/creacion-postulacion/miPostulaciones.php"><i class="fas fa-briefcase"></i> Mis postulaciones</a>
                <a href="../paginas/registroVehiculo.php"><i class="fas fa-car"></i> Registrar vehículo</a>
                <a href="../salir.php"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
</div>

        <?php else: ?>
            <a class="animated-button-login" href="./paginas/inicio.php">Iniciar Sesión</a>
            <a class="animated-button-login" href="./paginas/registro.php">Registrarse</a>
        <?php endif; ?>
    </div>
</header>
    <main>
    
    <form action= "insertarPublicacion.php" method = 'POST' class='formularioCreacion' enctype="multipart/form-data">
        <div class="titulo-crear">
            <h3>Crear Publicacion</h3>
        </div>
        <div>
        <script>
            const API_BASE_URL = "https://apis.datos.gob.ar/georef/api";

            function cargarProvincias() {
                    fetch(`${API_BASE_URL}/provincias`)
                        .then(response => response.json())
                        .then(data => {
                            const provincias = data.provincias;
                            const provinciasSelect = document.querySelectorAll(".provincias");

                            provincias.forEach(provincia => {
                                const option = document.createElement("option");
                                option.value = provincia.nombre;
                                option.textContent = provincia.nombre;
                                provinciasSelect.forEach(select =>{
                                    select.appendChild(option.cloneNode(true));
                                });
                            });
                        })
                        .catch(error => console.error("Error al cargar las provincias:", error));
                }

            function cargarLocalidadesOrigen(){
                const provinciaOrigen = document.getElementById("prov-origen").value;
                const localidadSelect = document.getElementById("local-origen");

                localidadSelect.innerHTML = "<option>Seleccione una localidad</option>";
                if (provinciaOrigen) {
                        fetch(`${API_BASE_URL}/localidades?provincia=${encodeURIComponent(provinciaOrigen)}&max=100`)
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

            function cargarLocalidadesDestino(){
                const provinciaDestino = document.getElementById("prov-destino").value;
                const localidadSelect = document.getElementById("local-destino");

                localidadSelect.innerHTML = "<option>Seleccione una localidad</option>";
                if (provinciaDestino) {
                        fetch(`${API_BASE_URL}/localidades?provincia=${encodeURIComponent(provinciaDestino)}&max=100`)
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

                function toggleDropdown() {
                    document.querySelector('.dropdown-content').classList.toggle('show');
                }

                // Cierra el menú si se hace clic fuera de él
                window.onclick = function(event) {
                    if (!event.target.matches('.dropbtn')) {
                        const dropdowns = document.querySelectorAll('.dropdown-content');
                        dropdowns.forEach(dropdown => dropdown.classList.remove('show'));
                    }
                }

        </script>
            <div class="cont-campos-par">
                <div class="cont-input">
                    <label for="">Titulo de la publicacion</label>
                    <input type="text" name="titulo">
                </div>
                <div class="cont-input">
                    <label for="">Descripcion</label>
                    <input type="text" name="descripcion">
                </div>
                
            </div>
            <div class="cont-campos-par">
                <div class="cont-input">
                    <label>Volumen del paquete</label>
                    <input type="number" name='volumen' >
                </div>
                <div class="cont-input">
                    <label>Peso del paquete</label>
                    <input type="number" name='peso'>
                </div> 
            </div>
            <div class="cont-campos-par">
                <div class="cont-input">
                    <label>Provincia de origen</label>
                    <select name="prov-origen" class="provincias" id="prov-origen" onchange="cargarLocalidadesOrigen()">
                        <option value="" selected disabled>Seleccione una provincia</option>
                    </select>
                </div>
                <div class="cont-input">
                    <label>Provincia de destino</label>
                    <select name="prov-destino" class="provincias" id="prov-destino" onchange="cargarLocalidadesDestino()">
                        <option value="" selected disabled>Seleccione una provincia</option>
                    </select>
                </div>
            </div>
            <div class="cont-campos-par">
                <div class="cont-input">
                    <label>Localidad de origen</label>
                    <select name="local-origen" id="local-origen">
                        <option value="" selected disabled>Seleccione una localidad</option>
                    </select>
                </div>
                <div class="cont-input">
                    <label>Localidad de destino</label>
                    <select name="local-destino" id="local-destino" >
                        <option value="" selected disabled>Seleccione una localidad</option>
                    </select>
                </div>
            </div>
            <div class="cont-campos-par">
                <div class="cont-input">
                    <label>Calle de origen</label>
                    <input type='text' name='calle-origen'>
                </div>
                <div class="cont-input">
                    <label>Calle de destino</label>
                    <input type='text' name='calle-destino'>
                </div>
            </div>  
            <div>
                <input type="file" name="imagen" id="" accept="image/*">
            </div>           
        </div>
        <input type='submit' value='ENVIAR' class="btn-enviar">

        

    </form>
    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>                 
</body>
</html>