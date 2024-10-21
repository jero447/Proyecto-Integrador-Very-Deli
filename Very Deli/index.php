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
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="contenedor-logo">
            <img src="./imagenes/LogoDery.png" alt="logo" class="logo">
            <h1>Very Deli</h1>  
        </div>       
        <div class="btns-login">
<<<<<<< HEAD
        <div class="btns-login">
        <?php if ($nombreUsuario): ?>
            <div class="dropdown">
                <button class="dropbtn"><?php echo htmlspecialchars($nombreUsuario); ?></button>
                <div class="dropdown-content">
                    <a href="./paginas/salir.php">Salir</a>
                </div>
            </div>
        <?php else: ?>
            <a class="animated-button-login" href="./paginas/inicio.php">Iniciar Sesion</a>
            <a class="animated-button-login" href="./paginas/registro.php">Registrarse</a>
        <?php endif; ?>
    </div>
=======
            
>>>>>>> 61cd729615004d50abca553162240815836e31e6
        </div>
    </header>
    <div class="contenedor-main">
            HOLA
    </div>
    <main>
        <div class="contenedor-filtro">
            <h3>Buscar publicacion por:</h3>
            <div class="filtro-zona">
                <label for="">Zona:</label>
                <select name="" id="">
                    <option value="" selected disabled>Seleccione una zona</option>
                </select>
            </div>
            <div class="filtro-descripcion">
                <label for="">Descripcion:</label>
                <input type="text" name="" id="" placeholder="Ingrese la descripcion">
            </div>
        </div>
        <div class="contenedor-lista">
            <a href="./paginas/publicacion.php">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
            <a href="">
                <div class="publicacion">
                    <h4>Nombre Necesidad</h4>
                    <p>Descripcion</p>
                </div>
            </a>
        </div>
    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>