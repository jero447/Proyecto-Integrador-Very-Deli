<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./estilos-iniciar-registro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <a href="../index.php" class = "vinculo-home">
            <div class="contenedor-logo">
                <img src="../imagenes/LogoDery.png" alt="logo" class="logo">
                <h1>Very Deli</h1>  
            </div>  
        </a>
             
        <div class="btns-login">
            <a class="animated-button-login" href="./registro.php">Registrarse</a>
        </div>
    </header>
    <main>
        <div class = "formulario-login">
            <h2>Iniciar Sesion</h2>

            <?php 

                session_start();
                $msjError = array();
                $correoUser = "";
                $claveLogin = "";

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (empty($_POST['correoUser'])) {
                        $msjError['correoUser'] = "Ingrese un email o nombre de usuario valido.";
                    } else {
                        $correoUser = $_POST['correoUser'];
                    }
                    
                    if (empty($_POST['claveLogin'])) {
                        $msjError['claveLogin'] = "El campo contraseña es obligatorio.";
                    } elseif (strlen($_POST['claveLogin']) < 8 || !preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_])/', $_POST['claveLogin'])) {
                        $msjError['claveLogin'] = "La contraseña debe contener al menos 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.";
                    } else {
                        $claveLogin = $_POST['claveLogin'];
                    }
        
                    if (empty($msjError)) {
                        require("../conexionBD.php");
                        $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

                        if(mysqli_connect_errno()){
                            die("Fallo al conectar con la base de datos");
                        }
                        mysqli_set_charset($conexion,"utf8");

                        $sqlLOG = "SELECT COUNT(*) AS count FROM usuario WHERE email = '$correoUser' OR nombre_usuario = '$correoUser'";
                        $result = $conexion->query($sqlLOG);
                        $row = $result->fetch_assoc();

                        if ($row['count'] == 0) {
                                $msjError['correoUser'] = "Email o nombre de usuario no existente.";
                        }else {
                            $sqlClave = "SELECT idUsuario, nombre, email, nombre_usuario, clave, dni FROM usuario WHERE email = '$correoUser' OR nombre_usuario = '$correoUser'";
                            $resultClave = $conexion->query($sqlClave);
                            $rowClave = $resultClave->fetch_assoc();
                            
                            $idUsuario = $rowClave["idUsuario"];
                            $nombre = $rowClave["nombre"];
                            $email = $rowClave["email"];
                            $nombreUsuario = $rowClave["nombre_usuario"];
                            $dni = $rowClave["dni"];
                            $clave = $rowClave['clave'];
                        
                            if (password_verify($claveLogin, $clave)) {
                                $_SESSION['idUsuario'] = $idUsuario;
                                $_SESSION["nombre"] = $nombre;
                                $_SESSION["email"] = $email;
                                $_SESSION["nombreUsuario"] = $nombreUsuario;
                                $_SESSION["dni"] = $dni;
                                $_SESSION['clave'] = $clave;
                                header("Location: ../index.php");
                                exit();
                            } else {
                                $msjError['claveLogin'] = "Contraseña incorrecta.";
                            }
                        }
                    }
                }
            ?>

            <form action="inicio.php" method="post">

                <div class = "contenedor-correo">
                    <label for="correoUser">Email o Usuario</label>
                    <input type="text" id="correoUser" name="correoUser" placeholder="usuario@gmail.com o usuario" value="<?php echo htmlspecialchars($correoUser); ?>">
                    <?php if (isset($msjError['correoUser'])) { echo "<span class='msjError'>{$msjError['correoUser']}</span>"; } ?>
                </div>
                <div class= "contenedor-contraseña">
                    <label for="claveLogin">Contraseña</label>
                    <input type="password" id="claveLogin" name="claveLogin" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" 
                    title="Debe contener al menos 8 caracteres, una letra mayúscula, una letra minúscula, un número y un carácter especial" 
                    value="<?php echo htmlspecialchars($claveLogin); ?>">
                    <?php if (isset($msjError['claveLogin'])) { echo "<span class='msjError'>{$msjError['claveLogin']}</span>"; } ?>
                </div>
                <div>
                    <input type="submit" value="Siguiente">
                </div>
                <br>
                <a href="./perfil-usuario/recuperar-clave-token.php">
                        <input type="button" value="Recuperar Contraseña">
                </a>
            </form>
            
        </div>
    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>