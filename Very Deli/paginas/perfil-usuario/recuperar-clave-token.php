<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
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
        <h2>Recuperar contraseña</h2>

    <?php

            $msjError = array();
            $msjExito = null;
            $email = "";
            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            require '../../../vendor/autoload.php';

            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                
                if (empty($_POST['email'])) {
                    $msjError['email'] = "El campo correo es obligatorio.";
                } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                    $msjError['email'] = "El correo no es válido.";
                } else {
                    $email = $_POST['email'];
                }

                if (empty($msjError)) {

                require("../../conexionBD.php");
                $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

                if(mysqli_connect_errno()){
                    die("Fallo al conectar con la base de datos");
                }
                mysqli_set_charset($conexion,"utf8");
                
                $consultaEmail = "SELECT COUNT(*) FROM usuario WHERE email = '$email'";
                $resultadoEmail = mysqli_query($conexion, $consultaEmail);
                $emailExists = mysqli_fetch_row($resultadoEmail)[0] > 0;

                if (!$emailExists) {
                    $msjError['email'] = "Este correo no está registrado.";
                } else {

                    $token = bin2hex(random_bytes(16));
                    $vencimiento = date("Y-m-d H:i:s", strtotime("+1 hour"));
                    $resetLink = "http://localhost:3000/Very%20Deli/paginas/perfil-usuario/recuperar-clave.php?token=" . $token;

                    $consulta = "INSERT INTO reset_clave (email, token, vencimiento) VALUES ('$email', '$token', '$vencimiento')";
                    $resultado = mysqli_query($conexion, $consulta);

                    if ($resultado) {
                        $mail = new PHPMailer(true);
                        $mail->CharSet = 'UTF-8';

                        try {
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->SMTPAuth = true;
                            $mail->Username = 'verydeli2024@gmail.com';
                            $mail->Password = 'tlta vfdp jpzt wycs';
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom('verydeli2024@gmail.com', 'Very Deli');
                            $mail->addAddress($email);
                            $mail->isHTML(true);

                            $mail->Subject = 'Recuperación de contraseña';
                            $mail->Body = "Haz clic en el siguiente enlace para restablecer tu contraseña: <a href='$resetLink'>$resetLink</a>";
                            $mail->AltBody = "Haz clic en el siguiente enlace para restablecer tu contraseña: $resetLink";

                            $mail->send();
                            $msjExito = $msjExito = "Correo enviado a " . htmlspecialchars($email);
                        } catch (Exception $e) {
                            $msjError['errores'] = "Error al enviar el correo. Mailer Error: {$mail->ErrorInfo}";
                        }
                    } else {
                        $msjError['errores'] = "Error al generar el token.";
                    }
                    $conexion->close();
                }
            }
        }
    ?>
        <br>
        <form action="recuperar-clave-token.php" method="post">

            <div class="contenedor-contraseña">
                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <?php if (isset($msjError['email'])) { echo "<span class='msjError'>{$msjError['email']}</span>"; } ?>
            </div>
            <div>
            <input type="submit" value="Recuperar Contraseña">
            </div>
            <?php 
                if (isset($msjError['errores'])) { echo "<span class='msjError'>{$msjError['errores']}</span>"; } 
                if ($msjExito) { echo "<span class='msjExito'>{$msjExito}</span>"; }
            ?>
        </form>
    </div>
</body>
</html>