<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>
    <link rel="stylesheet" href="./estilos-iniciar-registro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>

<header>
    <a href="../index.php" class="vinculo-home">
        <div class="contenedor-logo">
            <img src="../imagenes/LogoDery.png" alt="logo" class="logo">
            <h1>Very Deli</h1>  
        </div>  
    </a>
    <div class="btns-login">
        <a class="animated-button-login" href="./inicio.php">Iniciar Sesión</a>
    </div>
</header>

<main>
    <div class="formulario-login">
        <h2>Crea tu cuenta</h2>

        <!--CAMBIOS: CAMPOS DNI, CAMPO NOMBRE DE USUARIO, CONTROLES DE CAMPOS VACIOS, CONTROLES CORRESPONDIENTES A CADA CAMPO, QUITADO BOTON REGISTRAR DEL HEADER, CONTROL VALORES REPETIDOS(DNI, CORREO, USUARIO) -->

        <?php
            $msjError = array();
            $nombre = "";
            $dni = "";
            $email = "";
            $nombreUsuario = "";
            $clave = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['nombre'])) {
                $msjError['nombre'] = "El campo nombre es obligatorio.";
            } elseif (!preg_match("/^[A-Za-zÀ-ÿ\s\.,'-]+$/", $_POST['nombre'])) {
                $msjError['nombre'] = "El nombre solo puede contener letras y caracteres especiales.";
            } else {
                $nombre = $_POST['nombre'];
            }
            

            if (empty($_POST['dni'])) {
                $msjError['dni'] = "El campo DNI es obligatorio.";
            } else {
                $dni = $_POST['dni'];
            }

            if (empty($_POST['email'])) {
                $msjError['email'] = "El campo correo es obligatorio.";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $msjError['email'] = "El correo no es válido.";
            } else {
                $email = $_POST['email'];
            }

            if (empty($_POST['nombre_usuario'])) {
                $msjError['nombre_usuario'] = "El campo nombre de usuario es obligatorio.";
            } else {
                $nombreUsuario = $_POST['nombre_usuario'];
            }

            if (empty($_POST['clave'])) {
                $msjError['clave'] = "El campo contraseña es obligatorio.";
            } elseif (strlen($_POST['clave']) < 8 || !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])/', $_POST['clave'])) {
                $msjError['clave'] = "La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
            } else {
                $clave = $_POST['clave'];
            }

            if (empty($msjError)) {
                $servername = "localhost";
                $username_db = "user_delivery";
                $password_db = "user";
                $dbname = "delivery";

                $conexion = new mysqli($servername, $username_db, $password_db, $dbname);

                if ($conexion->connect_error) {
                    die("Conexión fallida: " . $conexion->connect_error);
                }

                $sqlEmail = "SELECT COUNT(*) AS count FROM usuario WHERE email = '$email'";
                $resultEmail = $conexion->query($sqlEmail);
                $rowEmail = $resultEmail->fetch_assoc();
                
                if ($rowEmail['count'] > 0) {
                    $msjError['email'] = "El correo ya está en uso.";
                }

                $sqlUsuario = "SELECT COUNT(*) AS count FROM usuario WHERE nombre_usuario = '$nombreUsuario'";
                $resultUsuario = $conexion->query($sqlUsuario);
                $rowUsuario = $resultUsuario->fetch_assoc();
                
                if ($rowUsuario['count'] > 0) {
                    $msjError['nombre_usuario'] = "El nombre de usuario ya está en uso.";
                }

                $sqlDNI = "SELECT COUNT(*) AS count FROM usuario WHERE dni = '$dni'";
                $resultDNI = $conexion->query($sqlDNI);
                $rowDNI = $resultDNI->fetch_assoc();
                
                if ($rowDNI['count'] > 0) {
                    $msjError['dni'] = "El DNI ya está en uso.";
                }

                if (empty($msjError)) {
                    $clave = password_hash($clave, PASSWORD_DEFAULT);
                    $sql = "INSERT INTO usuario (nombre, email, nombre_usuario, clave, dni) VALUES ('$nombre', '$email', '$nombreUsuario', '$clave', '$dni')";
            
                    if ($conexion->query($sql) === TRUE) {
                        header("Location: ../index.php");
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conexion->error;
                    }
                }

                $conexion->close();
            }
        }
        ?>

        <form action="registro.php" method="post">
            <div class="contenedor-correo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" value="<?php echo htmlspecialchars($nombre); ?>">
                <?php if (isset($msjError['nombre'])) { echo "<span class='msjError'>{$msjError['nombre']}</span>"; } ?>
            </div>

            <div class="contenedor-correo">
                <label for="dni">DNI:</label>
                <input type="number" id="dni" name="dni" min=10000000 max=99999999 placeholder="Número de DNI" value="<?php echo htmlspecialchars($dni); ?>">
                <?php if (isset($msjError['dni'])) { echo "<span class='msjError'>{$msjError['dni']}</span>"; } ?>
            </div>

            <div class="contenedor-correo">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" placeholder="usuario@gmail.com" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($msjError['email'])) { echo "<span class='msjError'>{$msjError['email']}</span>"; } ?>
            </div>

            <div class="contenedor-correo">
                <label for="nombre_usuario">Nombre de Usuario:</label>
                <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($nombreUsuario); ?>">
                <?php if (isset($msjError['nombre_usuario'])) { echo "<span class='msjError'>{$msjError['nombre_usuario']}</span>"; } ?>
            </div>

            <div class="contenedor-contraseña">
                <label for="clave">Contraseña:</label>
                <input type="password" id="clave" name="clave" minlength="8" 
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                    title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial" 
                    value="<?php echo htmlspecialchars($clave); ?>">
                <?php if (isset($msjError['clave'])) { echo "<span class='msjError'>{$msjError['clave']}</span>"; } ?>
            </div>

            <div>
                <input type="submit" value="Registrarse">
            </div>
        </form>
    </div>
</main>

<footer>
    <p>Universidad Nacional de San Luis</p>
    <p>Programación III</p>
</footer>

</body>
</html>