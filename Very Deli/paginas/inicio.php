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
            <a class="btn-registrarse" href="./registro.php">Registrarse</a>
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
                        $servername = "localhost";
                        $username_db = "user_delivery";
                        $password_db = "user";
                        $dbname = "delivery";
        
                        $conexion = new mysqli($servername, $username_db, $password_db, $dbname);
        
                        if ($conexion->connect_error) {
                            die("Conexión fallida: " . $conexion->connect_error);
                        }

                            $sqlLOG = "SELECT COUNT(*) AS count FROM usuario WHERE email = '$correoUser' OR nombre_usuario = '$correoUser'";
                            $result = $conexion->query($sqlLOG);
                            $row = $result->fetch_assoc();

                        if ($row['count'] == 0) {
                                $msjError['correoUser'] = "Email o nombre de usuario no existente.";
                        }else {
                            $sqlClave = "SELECT clave FROM usuario WHERE email = '$correoUser' OR nombre_usuario = '$correoUser'";
                            $resultClave = $conexion->query($sqlClave);
                            $rowClave = $resultClave->fetch_assoc();
                        
                            if (password_verify($claveLogin, $rowClave['clave'])) {
                                $_SESSION['correoUser'] = $correoUser;
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
            </form>
            
        </div>
    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>