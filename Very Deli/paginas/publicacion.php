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
    <link rel="stylesheet" href="estilos-publicacion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="contenedor-logo">
            <img src="../imagenes/LogoDery.png" alt="logo" class="logo">
            <h1>Very Deli</h1>  
        </div>       
        <div class="btns-login">
        <div class="btns-login">
        <?php if ($nombreUsuario): ?>
            <div class="dropdown">
                <button class="dropbtn"><?php echo htmlspecialchars($nombreUsuario); ?></button>
                <div class="dropdown-content">
                    <a href="./salir.php">Salir</a>
                </div>
            </div>
        <?php else: ?>
            <a class="btn-iniciar" href="./inicio.php">Iniciar Sesión</a>
            <a class="btn-registrarse" href="./registro.php">Registrarse</a>
        <?php endif; ?>
    </div>
        </div>
    </header>
    <main>
        <div class="contenedor-publicacion">
            <h2>Nombre Necesidad</h2>
            <div class="info-publicacion">
                <div>
                    <h4>Usuario dueño de la publicacion</h4>
                    <p>Informacion de la publicacion:</p>
                    <p>Lugar de origen: ...</p>
                    <p>Lugar de destino: ...</p>
                    <p>Volumen: ...</p>
                    <p>Peso: ...</p>
                </div>
                <div class="btns-publicacion">
                    <button class="btn">Postularme</button>
                    <button class="btn">Enviar Mensjae al dueño</button>
                    <button class="btn">Calificar al dueño</button>
                </div>
            </div>
            <h4>Lista de postulantes</h4>
            <div class="lista-postulantes">
                <a href="">
                    <div class="postulante">
                        <h5>Nombre Postulante</h5>
                        <p>Monto de cobro</p>
                    </div>
                </a>
                <a href="">
                    <div class="postulante">
                        <h5>Nombre Postulante</h5>
                        <p>Monto de cobro</p>
                    </div>
                </a>
                <a href="">
                    <div class="postulante">
                        <h5>Nombre Postulante</h5>
                        <p>Monto de cobro</p>
                    </div>
                </a>
                <a href="">
                    <div class="postulante">
                        <h5>Nombre Postulante</h5>
                        <p>Monto de cobro</p>
                    </div>
                </a>
                <a href="">
                    <div class="postulante">
                        <h5>Nombre Postulante</h5>
                        <p>Monto de cobro</p>
                    </div>
                </a>
                <a href="">
                    <div class="postulante">
                        <h5>Nombre Postulante</h5>
                        <p>Monto de cobro</p>
                    </div>
                </a>
            </div>
        </div>
    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>