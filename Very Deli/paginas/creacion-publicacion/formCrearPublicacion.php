<?php
        session_start();
        $nombreUsuario = isset($_SESSION['correoUser']) ? $_SESSION['correoUser'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="estilosCrearPublicacion.css">
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
                            <a href="./paginas/salir.php">Salir</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="animated-button-login" href="./paginas/inicio.php">Iniciar Sesión</a>
                    <a class="animated-button-login" href="./paginas/registro.php">Registrarse</a>
                <?php endif; ?>
            </div>
    </header>
    <main>
    
    <form action= "insertarPublicacion.php" method = 'POST' class='formularioCreacion'>
        <div class="titulo-crear">
            <h3>Crear Publicacion</h3>
        </div>
        <div>
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
                    <input type='text' name='prov-origen'>
                </div>
                <div class="cont-input">
                    <label>Provincia de destino</label>
                    <input type='text' name='prov-destino'>
                </div>
            </div>
            <div class="cont-campos-par">
                <div class="cont-input">
                    <label>Localidad de origen</label>
                    <input type='text' name='local-origen'>
                </div>
                <div class="cont-input">
                    <label>Localidad de destino</label>
                    <input type='text' name='local-destino'>
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