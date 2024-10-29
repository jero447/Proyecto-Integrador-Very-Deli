<?php
        session_start();
        $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

        if (!$idUsuario) {
            header("Location: ../../index.php");
            exit();
        }

        $claveSesion = isset($_SESSION['clave']) ? $_SESSION['clave'] : null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link rel="stylesheet" href="./estilos-editar.css">
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
</header>
<main>
    <div class="formulario-login">
        <h2>Cambiar Contraseña</h2>

        <?php 
            $msjError = array();
            $msjExito = null;
            $claveActual = "";
            $claveNueva = "";
            $confirmClave = "";            

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                if (empty($_POST['claveActual'])) {
                    $msjError['claveActual'] = "Campo obligatorio.";
                } elseif (!password_verify($_POST['claveActual'], $claveSesion)) {
                    $msjError['claveActual'] = "Contraseña incorrecta.";
                }else {
                    $claveActual = $_POST['claveActual'];
                }

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
                    require("../../conexionBD.php");
                    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
            
                    if(mysqli_connect_errno()){
                        die("Fallo al conectar con la base de datos");
                    }
                    mysqli_set_charset($conexion,"utf8");
                    
                    $claveNuevaHashed = password_hash($claveNueva, PASSWORD_DEFAULT);
                    $sql = "UPDATE usuario SET clave='$claveNuevaHashed' WHERE idUsuario='$idUsuario'";
            
                    if ($conexion->query($sql) === TRUE) {
                        $_SESSION['clave'] = $claveNuevaHashed;
                        $claveActual = "";
                        $claveNueva = "";
                        $confirmClave = "";
                        $msjExito = "Contraseña cambiada con exito.";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conexion->error;
                    }

                    $conexion->close();

                }
            }

        ?>
            <br>
            <form action="editarClave.php" method="post">
                <div class="contenedor-contraseña">
                    <label for="claveActual">Contraseña actual:</label>
                    <input type="password" id="claveActual" name="claveActual" minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial"
                        value="<?php echo htmlspecialchars($claveActual); ?>">
                    <?php if (isset($msjError['claveActual'])) { echo "<span class='msjError'>{$msjError['claveActual']}</span>"; } ?>
                </div>

                <div class="contenedor-contraseña">
                    <label for="claveNueva">Nueva contraseña:</label>
                    <input type="password" id="claveNueva" name="claveNueva" minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial"
                        value="<?php echo htmlspecialchars($claveNueva); ?>">
                    <?php if (isset($msjError['claveNueva'])) { echo "<span class='msjError'>{$msjError['claveNueva']}</span>"; } ?>
                </div>

                <div class="contenedor-contraseña">
                    <label for="confirmClave">Confirmar nueva contraseña:</label>
                    <input type="password" id="confirmClave" name="confirmClave" minlength="8"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}"
                        title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial"
                        value="<?php echo htmlspecialchars($confirmClave); ?>">
                    <?php if (isset($msjError['confirmClave'])) { echo "<span class='msjError'>{$msjError['confirmClave']}</span>"; } ?>
                </div>
                <input type="submit" value="Guardar">
                <br><br>
                <?php if (isset($msjExito)) { echo "<span class='msjExito'>{$msjExito}</span>"; } ?>
            </form>
    </div>
</body>
</html>