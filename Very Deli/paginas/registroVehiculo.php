<?php
        session_start();
        $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

        if (!$idUsuario) {
            header("Location: ../index.php");
            exit();
        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Vehiculo</title>
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
        <?php

        require("../conexionBD.php");
        $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);

        if(mysqli_connect_errno()){
            die("Fallo al conectar con la base de datos");
        }
        mysqli_set_charset($conexion,"utf8");

        $sqlCountVehiculo = "SELECT COUNT(*) AS vehiculo FROM vehiculo WHERE idUsuario = '$idUsuario'";
        $resultCountVehiculo = $conexion->query($sqlCountVehiculo);
        $rowCountVehiculo = $resultCountVehiculo->fetch_assoc();
        $numVehiculo = $rowCountVehiculo['vehiculo'];

            $msjError = array();
            $msjExito = null;
            $idVehiculo = "";
            $matricula = "";
            $modelo = "";
            $color = "";

        if ($numVehiculo >= 2) {
            $msjError['limite'] = "Ha alcanzado el maximo de vehiculos registrados";
        } else {    
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (empty($_POST['matricula'])) {
                    $msjError['matricula'] = "El campo matrícula es obligatorio.";
                } elseif (!preg_match("/^([A-Z]{3} [0-9]{3})|([A-Z]{2} [0-9]{3} [A-Z]{2})$/i", $_POST['matricula'])) {
                    $msjError['matricula'] = "La matrícula debe ser válida (formatos aceptados: 'ABC 123' o 'AB 123 CD').";
                } else {
                    $matricula = $_POST['matricula'];

                    $sqlVehiculo = "SELECT COUNT(*) AS count FROM vehiculo WHERE matricula = '$matricula'";
                    $resultVehiculo = $conexion->query($sqlVehiculo);
                    $rowVehiculo = $resultVehiculo->fetch_assoc();
                    
                    if ($rowVehiculo['count'] > 0) {
                        $msjError['matricula'] = "La matricula ya esta registrada.";
                    }
                }            

                if (empty($_POST['modelo'])) {
                    $msjError['modelo'] = "El campo modelo es obligatorio.";
                } else {
                    $modelo = $_POST['modelo'];
                }

                if (empty($_POST['color'])) {
                    $msjError['color'] = "El campo color es obligatorio.";
                } else {
                    $color = $_POST['color'];
                }

                if (empty($msjError)) {
                    $sql = "INSERT INTO vehiculo (matricula, modelo, color, idUsuario) VALUES ('$matricula', '$modelo', '$color', '$idUsuario')";
                
                    if ($conexion->query($sql) === TRUE) {
                        $matricula = "";
                        $modelo = "";
                        $color = "";
                        $msjExito = "Vehiculo registrado con exito.";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conexion->error;
                    }
                }

                $conexion->close();
            }
        }
        ?>
        <?php if (isset($msjError['limite'])): ?>
            <span class='msjError'><?php echo $msjError['limite']; ?></span>
            <br>
            <a class="animated-button-login" href="../index.php" >Volver</a>
        <?php else: ?>
            <h2>Datos del vehiculo</h2>
            <form action="registroVehiculo.php" method="post">
                <div class="contenedor-correo">
                    <label for="matricula">Matricula:</label>
                    <input type="text" id="matricula" name="matricula" placeholder="Numero de matricula" value="<?php echo htmlspecialchars($matricula); ?>">
                    <?php if (isset($msjError['matricula'])) { echo "<span class='msjError'>{$msjError['matricula']}</span>"; } ?>
                </div>

                <div class="contenedor-correo">
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" placeholder="Modelo de vehiculo" value="<?php echo htmlspecialchars($modelo); ?>">
                    <?php if (isset($msjError['modelo'])) { echo "<span class='msjError'>{$msjError['modelo']}</span>"; } ?>
                </div>

                <div class="contenedor-contraseña">
                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" placeholder="Color de vehiculo" value="<?php echo htmlspecialchars($color); ?>">
                    <?php if (isset($msjError['color'])) { echo "<span class='msjError'>{$msjError['color']}</span>"; } ?>
                </div>

                <div>
                    <input type="submit" value="Registrar">
                </div>
                <?php if (isset($msjExito)) { echo "<span class='msjExito'>{$msjExito}</span>"; } ?>
            </form>
        <?php endif; ?>
    </div>
</main>

<footer>
    <p>Universidad Nacional de San Luis</p>
    <p>Programación III</p>
</footer>

</body>
</html>