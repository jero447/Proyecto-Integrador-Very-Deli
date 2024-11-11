<?php
        session_start();
        $idUsuario = $_SESSION["idUsuario"] ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    

<?php
$titulo = $_POST["titulo"];
$descripcion = $_POST["descripcion"];
$volumen = $_POST["volumen"];
$peso = $_POST["peso"];
$prov_origen = $_POST["prov-origen"];
$prov_destino = $_POST["prov-destino"];
$local_origen = $_POST["local-origen"];
$local_destino = $_POST["local-destino"];
$calle_origen = $_POST["calle-origen"];
$calle_destino = $_POST["calle-destino"];

$urlImagen = "";

if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $archivoTemporal = $_FILES['imagen']['tmp_name'];
    $imagen = $_FILES["imagen"]["name"];
    $directorio_destino = __DIR__ . '/../../uploads/';
    $rutaDestino = $directorio_destino . $imagen;

    move_uploaded_file($archivoTemporal, $rutaDestino);
    $urlImagen = "uploads/" . $imagen;
}


require("../../conexionBD.php");
$conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
if(mysqli_connect_errno()){
    echo "Fallo al conectar con la base de datos";
    exit();
}
mysqli_set_charset($conexion,"utf8");
$consulta = "INSERT INTO publicacion (titulo,descripcion,volumen,peso,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,idUsuario, imagen) VALUES ('$titulo','$descripcion','$volumen','$peso','$prov_origen','$prov_destino','$local_origen','$local_destino','$calle_origen','$calle_destino','$idUsuario','$urlImagen')";
mysqli_query($conexion,$consulta);

$consulta_publiActivas = "UPDATE usuario SET publicaciones_activas = publicaciones_activas + 1 WHERE idUsuario = $idUsuario";
$resultado = mysqli_query($conexion,$consulta_publiActivas);

if($resultado == false){
    echo "Error en la consulta";
}else{
    header("Location: ../../index.php");
    exit();
}

mysqli_close($conexion);

?>


</body>
</html>

