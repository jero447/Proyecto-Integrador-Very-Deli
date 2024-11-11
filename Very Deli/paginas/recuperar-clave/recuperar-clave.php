<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="./estilos-recuperar-clave.css">
    <link rel="icon" href="../login/iconos/logoFondoBlanco.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
<main>
    <div class="formulario-login">
        <h2>Recuperar Contraseña</h2>

        <?php

            $msjError = array();
            $msjExito = null;
            $token = isset($_GET['token']) ? $_GET['token'] : '';
            $claveNueva = '';
            $confirmClave = '';

            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['claveNueva']) && isset($_POST['confirmClave'])) {

                require("../../conexionBD.php");

                $conexion = mysqli_connect($db_host, $db_usuario, $db_contra, $db_nombre);

                if (mysqli_connect_errno()) {
                    die("Fallo al conectar con la base de datos: " . mysqli_connect_error());
                }

                mysqli_set_charset($conexion, "utf8");

                $claveNueva = $_POST['claveNueva'];
                $confirmClave = $_POST['confirmClave'];
                $token = mysqli_real_escape_string($conexion, $_POST['token']);

                if (empty($_POST['claveNueva'])) {
                    $msjError['claveNueva'] = "Campo obligatorio.";
                } elseif (strlen($_POST['claveNueva']) < 8 || !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])/', $_POST['claveNueva'])) {
                    $msjError['claveNueva'] = "La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
                } else {
                    $claveNueva = $_POST['claveNueva'];
                }

                if (empty($_POST['confirmClave'])) {
                    $msjError['confirmClave'] = "Campo obligatorio.";
                } elseif (($_POST['claveNueva']) !== ($_POST['confirmClave'])) {
                    $msjError['confirmClave'] = "Las contraseñas no coinciden.";
                }else {
                    $confirmClave = $_POST['confirmClave'];
                }

                if (empty($msjError)) {

                    $consultaToken = "SELECT email FROM reset_clave WHERE token = '$token' AND vencimiento > NOW()";
                    $resultadoToken = mysqli_query($conexion, $consultaToken);

                    if (mysqli_num_rows($resultadoToken) === 1) {

                        $fila = mysqli_fetch_assoc($resultadoToken);
                        $email = $fila['email'];

                        $claveNuevaHash = password_hash($claveNueva, PASSWORD_DEFAULT);

                        $consultaUpdate = "UPDATE usuario SET clave = '$claveNuevaHash' WHERE email = '$email'";
                        $resultadoUpdate = mysqli_query($conexion, $consultaUpdate);

                        if ($resultadoUpdate) {
                            $msjExito = "Contraseña restablecida correctamente.";
                            
                            $consultaDeleteToken = "DELETE FROM reset_clave WHERE token = '$token'";
                            mysqli_query($conexion, $consultaDeleteToken);
                        } else {
                            $msjError['password'] = "Error al actualizar la contraseña.";
                        }
                    } else {
                        $msjError['password'] = "El token es inválido o ha expirado.";
                    }

                    $conexion->close();
                }
            } elseif (empty($token)) {
                $msjError['password'] = "Token no proporcionado.";
            }
        ?>
        <br>
        <form action="recuperar-clave.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <div class="contenedor-contraseña">
                    <input type="password" placeholder="Nueva Contraseña" id="claveNueva" name="claveNueva" minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial"
                        value="<?php echo htmlspecialchars($claveNueva); ?>">
                    <?php if (isset($msjError['claveNueva'])) { echo "<span class='msjErrorGeneral'>{$msjError['claveNueva']}</span>"; } ?>
                </div>

                <div class="contenedor-contraseña">
                    <input type="password" placeholder="Repita la Contraseña" id="confirmClave" name="confirmClave" minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial"
                        value="<?php echo htmlspecialchars($confirmClave); ?>">
                    <?php if (isset($msjError['confirmClave'])) { echo "<span class='msjErrorGeneral'>{$msjError['confirmClave']}</span>"; } ?>
                </div>
            <div><input type="submit" value="Establecer Contraseña"></div>
            <br>
            <?php 
                if (isset($msjError['password'])) { echo "<span class='msjErrorGeneral'>{$msjError['password']}</span>"; }
                if ($msjExito) { echo "<span class='msjExito'>{$msjExito}</span>"; }
            ?>
        </form>
    </div>
</body>
</html>