<?php
    session_start();
    $idUsuario = isset($_SESSION['idUsuario']) ? $_SESSION['idUsuario'] : null;

    if (!$idUsuario) {
        header("Location: ../index.php");
        exit();
    }
    $nombreUsuario = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : null;
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
        <a href="../index.php" class = "vinculo-home">
        <div class="contenedor-logo">
            <img src="../imagenes/LogoDery.png" alt="logo" class="logo">
            <h1>Very Deli</h1>  
        </div>
        </a>
        <div class="btns-login">
            <?php if ($nombreUsuario): ?>
                <div class="dropdown">
                    <button class="dropbtn"><?php echo htmlspecialchars($nombreUsuario); ?></button>
                    <div class="dropdown-content">
                        <a href="./perfil-usuario/editarPerfil.php">Editar perfil</a>
                        <a href="./registroVehiculo.php">Registrar vehiculo</a>
                        <a href="./salir.php">Salir</a>
                    </div>
                </div>
            <?php else: ?>
                <a class="animated-button-login" href="./paginas/inicio.php">Iniciar Sesión</a>
                <a class="animated-button-login" href="./paginas/registro.php">Registrarse</a>
            <?php endif; ?>
        </div>       
    </header>

<?php
    require("../conexionBD.php");
    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
            
    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la base de datos";
        exit();
    }

    if (isset($_SESSION['idUsuario']))
        $idUsuario = $_SESSION['idUsuario'];

    $sql = "SELECT idPublicacion, volumen, peso, localidad_origen, localidad_destino, provincia_origen, provincia_destino, calle_origen, calle_destino, titulo, descripcion
            FROM publicacion
            WHERE idUsuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $idUsuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<div style='display: flex; justify-content: space-between;'>"; 
    
        
        while ($row = $result->fetch_assoc()) {
            echo "<div style='border: 1px solid black; padding: 10px; margin: 5px; width: 30%;'>"; 
            echo "<h3>" . $row['titulo'] . "</h3>";
            echo "<p><strong>Descripción:</strong> " . $row['descripcion'] . "</p>";
            echo "<p><strong>Peso:</strong> " . $row['peso'] . "</p>";
            echo "<p><strong>Volumen:</strong> " . $row['volumen'] . "</p>";
            echo "<p><strong>Provincia de origen:</strong> " . $row['provincia_origen'] . "</p>";
            echo "<p><strong>Provincia de destino:</strong> " . $row['provincia_destino'] . "</p>";
            echo "<p><strong>Localidad de origen:</strong> " . $row['localidad_destino'] . "</p>";
            echo "<p><strong>Localidad de destino:</strong> " . $row['destino'] . "</p>";
            echo "<p><strong>Calle de origen:</strong> " . $row['calle_origen'] . "</p>";
            echo "<p><strong>Calle de destino:</strong> " . $row['calle_destino'] . "</p>";
            echo "</div>";
        }
    
        echo "</div>"; 
    } else {
        echo "No se encontraron publicaciones.";
    }

?>