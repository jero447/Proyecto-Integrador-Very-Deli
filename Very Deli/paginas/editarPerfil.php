<?php
        session_start();
        $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;
        $nombreActual = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : null;
        $dniActual = isset($_SESSION['dni']) ? $_SESSION['dni'] : null;
        $emailActual = isset($_SESSION['email']) ? $_SESSION['email'] : null;
        $nombreUsuarioActual = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;

?>
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
</header>

<main>
    <div class="formulario-login">
        <h2>Datos de usuario</h2>

        <?php
            $msjError = array();
            $msjExito = null;
            $nombreNuevo = "";
            $dniNuevo = "";
            $emailNuevo = "";
            $nombreUsuarioNuevo = "";
            $cambiosNULL = "";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($_POST['nombre'])) {
                $msjError['nombre'] = "El campo nombre es obligatorio.";
            } elseif (!preg_match("/^[A-Za-zÀ-ÿ\s\.,'-]+$/", $_POST['nombre'])) {
                $msjError['nombre'] = "El nombre solo puede contener letras y caracteres especiales.";
            } else {
                $nombreNuevo = $_POST['nombre'];
            }
            

            if (empty($_POST['dni'])) {
                $msjError['dni'] = "El campo DNI es obligatorio.";
            } else {
                $dniNuevo = $_POST['dni'];
            }

            if (empty($_POST['email'])) {
                $msjError['email'] = "El campo correo es obligatorio.";
            } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $msjError['email'] = "El correo no es válido.";
            } else {
                $emailNuevo = $_POST['email'];
            }

            if (empty($_POST['nombreUsuario'])) {
                $msjError['nombreUsuario'] = "El campo nombre de usuario es obligatorio.";
            } else {
                $nombreUsuarioNuevo = $_POST['nombreUsuario'];
            }

            if (($nombreNuevo === $nombreActual) && ($dniNuevo === $dniActual) && ($emailNuevo === $emailActual) && ($nombreUsuarioNuevo === $nombreUsuarioActual)) {
                $msjError['cambiosNULL'] = "No se han realizado cambios.";
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
                
                if ($emailNuevo !== $emailActual) {
                    $sqlEmail = "SELECT COUNT(*) AS count FROM usuario WHERE email = '$emailNuevo'";
                    $resultEmail = $conexion->query($sqlEmail);
                    $rowEmail = $resultEmail->fetch_assoc();
                    
                    if ($rowEmail['count'] > 0) {
                        $msjError['email'] = "El correo ya está en uso.";
                    }
                }

                if ($nombreUsuarioNuevo !== $nombreUsuarioActual) {
                    $sqlUsuario = "SELECT COUNT(*) AS count FROM usuario WHERE nombre_usuario = '$nombreUsuarioNuevo'";
                    $resultUsuario = $conexion->query($sqlUsuario);
                    $rowUsuario = $resultUsuario->fetch_assoc();
                
                    if ($rowUsuario['count'] > 0) {
                        $msjError['nombreUsuario'] = "El nombre de usuario ya está en uso.";
                    }
                }
                
                if ($dniNuevo !== $dniActual) {
                    $sqlDNI = "SELECT COUNT(*) AS count FROM usuario WHERE dni = '$dniNuevo'";
                    $resultDNI = $conexion->query($sqlDNI);
                    $rowDNI = $resultDNI->fetch_assoc();
                    
                    if ($rowDNI['count'] > 0) {
                        $msjError['dni'] = "El DNI ya está en uso.";
                    }    
                }

                if (empty($msjError)) {
                    $sql = "UPDATE usuario SET nombre='$nombreNuevo', email='$emailNuevo', nombre_usuario='$nombreUsuarioNuevo', dni='$dniNuevo' WHERE idUsuario='$idUsuario'";
            
                    if ($conexion->query($sql) === TRUE) {
                        $_SESSION['nombre'] = $nombreNuevo;
                        $_SESSION['email'] = $emailNuevo;
                        $_SESSION['nombreUsuario'] = $nombreUsuarioNuevo;
                        $_SESSION['dni'] = $dniNuevo;
                        $nombreActual = $nombreNuevo;
                        $dniActual = $dniNuevo;
                        $emailActual = $emailNuevo;
                        $nombreUsuarioActual = $nombreUsuarioNuevo;
                        $msjExito = "Cambios guardados con exito.";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conexion->error;
                    }
                }

                $conexion->close();
            }
        }
        ?>
        <form action="editarPerfil.php" method="post">
            <div class="contenedor-correo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombreActual); ?>">
                <?php if (isset($msjError['nombre'])) { echo "<span class='msjError'>{$msjError['nombre']}</span>"; } ?>
            </div>

            <div class="contenedor-correo">
                <label for="dni">DNI:</label>
                <input type="number" id="dni" name="dni" min=10000000 max=99999999 value="<?php echo htmlspecialchars($dniActual); ?>">
                <?php if (isset($msjError['dni'])) { echo "<span class='msjError'>{$msjError['dni']}</span>"; } ?>
            </div>

            <div class="contenedor-correo">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($emailActual); ?>">
                <?php if (isset($msjError['email'])) { echo "<span class='msjError'>{$msjError['email']}</span>"; } ?>
            </div>

            <div class="contenedor-correo">
                <label for="nombreUsuario">Nombre de Usuario:</label>
                <input type="text" id="nombreUsuario" name="nombreUsuario" value="<?php echo htmlspecialchars($nombreUsuarioActual); ?>">
                <?php if (isset($msjError['nombreUsuario'])) { echo "<span class='msjError'>{$msjError['nombreUsuario']}</span>"; } ?>
            </div>

            <div>
                <input type="submit" value="Guardar">
                <a href="editarClave.php">
                    <input type="button" value="Cambiar Contraseña">
                </a>
                <br><br>
                <?php if (isset($msjError['cambiosNULL'])) { echo "<span class='msjError'>{$msjError['cambiosNULL']}</span>"; } ?>
                <?php if (isset($msjExito)) { echo "<span class='msjExito'>{$msjExito}</span>"; } ?>
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