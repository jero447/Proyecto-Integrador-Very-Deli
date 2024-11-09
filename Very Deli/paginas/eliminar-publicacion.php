<?php
require("../conexionBD.php");
$conexion = mysqli_connect($db_host, $db_usuario, $db_contra, $db_nombre);

if (isset($_GET['id'])) {
    $idPublicacion = intval($_GET['id']);
    $consulta = "DELETE FROM publicacion WHERE idPublicacion = $idPublicacion";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado) {
        echo "Publicación eliminada.";
    } else {
        echo "Error al eliminar la publicación.";
    }
}
header("Location: ./publicaciones-filtradas.php");
exit();
?>
