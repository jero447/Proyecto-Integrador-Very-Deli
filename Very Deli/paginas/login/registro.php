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
<main>
        <?php
            session_start();
            $msjError = array();
            $nombre = "";
            $dni = "";
            $email = "";
            $nombreUsuario = "";
            $clave = "";
            $confirmClave = "";

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
            if (empty($_POST['confirmClave'])) {
                $msjError['confirmClave'] = "Por favor repita la contraseña.";
            } elseif ($clave !== ($_POST['confirmClave'])) {
                $msjError['confirmClave'] = "Las contraseñas no coinciden.";
            } else {
                $confirmClave = $_POST['confirmClave'];
            }

            if (empty($msjError)) {
                require("../../conexionBD.php");
                $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

                if(mysqli_connect_errno()){
                    die("Fallo al conectar con la base de datos");
                }
                mysqli_set_charset($conexion,"utf8");

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
                        $idUsuario = $conexion->insert_id;
                        $_SESSION['idUsuario'] = $idUsuario;
                        $_SESSION["nombre"] = $nombre;
                        $_SESSION["email"] = $email;
                        $_SESSION["nombreUsuario"] = $nombreUsuario;
                        $_SESSION["dni"] = $dni;
                        $_SESSION['clave'] = $clave;
                        header("Location: ../../index.php");
                        exit();
                    } else {
                        echo "Error: " . $sql . "<br>" . $conexion->error;
                    }
                }

                $conexion->close();
            }
        }
        ?>
    <div class="overlay-panel overlay-left">
            <h1>¡Bienvenido!</h1>
            <p>
              Inicia sesión con tu cuenta
            </p>
            <a href="./inicio.php"><button class="ghost" id="signIn">Inicia sesión</button></a>
        </div>
    <div class="form-container sign-up-container">
        <form action="registro.php" method="post">
          <img src="./iconos/LogoDery.png" class="img-user">
          <h1>Crea tu Cuenta</h1>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
                <?php if (isset($msjError['nombre'])) { echo "<span class='msjError'>{$msjError['nombre']}</span>"; } ?>

            <input type="number" id="dni" name="dni" min=10000000 max=99999999 placeholder="Número de DNI" value="<?php echo htmlspecialchars($dni); ?>">
                <?php if (isset($msjError['dni'])) { echo "<span class='msjError'>{$msjError['dni']}</span>"; } ?>

            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($msjError['email'])) { echo "<span class='msjError'>{$msjError['email']}</span>"; } ?>

            <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre de usuario" value="<?php echo htmlspecialchars($nombreUsuario); ?>">
                <?php if (isset($msjError['nombre_usuario'])) { echo "<span class='msjError'>{$msjError['nombre_usuario']}</span>"; } ?>

            <input type="password" placeholder="Contraseña" id="clave" name="clave" minlength="8" 
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial" 
                value="<?php echo htmlspecialchars($clave); ?>">
                <?php if (isset($msjError['clave'])) { echo "<span class='msjError'>{$msjError['clave']}</span>"; } ?>

            <input type="password" placeholder="Repita la contraseña" id="confirmClave" name="confirmClave" minlength="8"
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial"
                value="<?php echo htmlspecialchars($confirmClave); ?>">
                <?php if (isset($msjError['confirmClave'])) { echo "<span class='msjError'>{$msjError['confirmClave']}</span>"; } ?>

          <button id="lila" class="btn-registrar">Registrar</button>
        </form>
      </div>
</main>

</body>
</html>