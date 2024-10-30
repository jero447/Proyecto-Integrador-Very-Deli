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
    <link rel="stylesheet" href="./estilos-publicacion.css">
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
                        <a href="./perfil-usuario/editarPerfil.php">Mi perfil</a>
                        <a href="./creacion-postulacion/miPostulaciones.php">Mis postulaciones</a>
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
$conexion = mysqli_connect($db_host, $db_usuario, $db_contra, $db_nombre);

if (mysqli_connect_errno()) {
    echo "Fallo al conectar con la base de datos";
    exit();
}

if (isset($_SESSION['idUsuario'])) {
    $idUsuario = $_SESSION['idUsuario'];
}

$sql = "SELECT idPublicacion, volumen, peso, localidad_origen, localidad_destino, provincia_origen, provincia_destino, calle_origen, calle_destino, titulo, descripcion
        FROM publicacion
        WHERE idUsuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<main>';
        echo '<div class="contenedor-publicacion">';
        echo '<h2>' . $row['titulo'] . '</h2>';
        echo '<div class="info-publicacion">';
        echo '<div>';
        echo '<h4>Usuario dueño de la publicacion</h4>';
        echo '<p><strong>Descripción:</strong> ' . $row['descripcion'] . '</p>';
        echo '<p><strong>Lugar de origen:</strong> ' . $row['provincia_origen'] . ', ' . $row['localidad_origen'] . ', ' . $row['calle_origen'] . '</p>';
        echo '<p><strong>Lugar de destino:</strong> ' . $row['provincia_destino'] . ', ' . $row['localidad_destino'] . ', ' . $row['calle_destino'] . '</p>';
        echo '<p><strong>Volumen:</strong> ' . $row['volumen'] . '</p>';
        echo '<p><strong>Peso:</strong> ' . $row['peso'] . '</p>';
        echo '</div>';
        echo '</div>';
        echo '<h4>Lista de postulantes</h4>';
        echo '<div class="lista-postulantes">';

        // Bucle para mostrar postulantes (ejemplo estático)
        for ($i = 0; $i < 3; $i++) {
            echo '<a href="">';
            echo '<div class="postulante">';
            echo '<h5>Nombre Postulante</h5>';
            echo '<p>Monto de cobro</p>';
            echo '</div>';
            echo '</a>';
        }

        echo '</div>'; // Cierra lista-postulantes

        // Sección de comentarios para esta publicación
        echo '<div class="seccion-comentarios">';
        echo '<h4>Comentarios</h4>';
        
        // Ejemplo de comentario principal y respuestas
        echo '<div class="comentario">';
        echo '<p><strong>Usuario1</strong> - 2024-10-26 10:30</p>';
        echo '<p>Este es un comentario de ejemplo para la publicación.</p>';
        
        echo '<div class="respuestas">';
        echo '<div class="comentario respuesta">';
        echo '<p><strong>Usuario2</strong> - 2024-10-26 10:45</p>';
        echo '<p>Esta es una respuesta al comentario de ejemplo.</p>';
        echo '</div>';
        
        echo '<div class="comentario respuesta">';
        echo '<p><strong>Usuario3</strong> - 2024-10-26 11:00</p>';
        echo '<p>Otra respuesta a este comentario.</p>';
        echo '</div>';
        echo '</div>'; // Cierra respuestas

        // Formulario para responder a un comentario
        echo '<form method="POST" action="agregarComentario.php">';
        echo '<textarea name="comentario" placeholder="Escribe una respuesta..."></textarea>';
        echo '<button type="submit">Responder</button>';
        echo '</form>';
        echo '</div>'; // Cierra comentario principal

        // Formulario para agregar un nuevo comentario
        echo '<form method="POST" action="agregarComentario.php">';
        echo '<textarea name="comentario" placeholder="Escribe un comentario..."></textarea>';
        echo '<button type="submit">Comentar</button>';
        echo '</form>';

        echo '</div>'; // Cierra seccion-comentarios
        echo '</div>'; // Cierra contenedor-publicacion
        echo '</main>'; // Cierra main
    }
} else {
    echo "No se encontraron publicaciones.";
}
?>

