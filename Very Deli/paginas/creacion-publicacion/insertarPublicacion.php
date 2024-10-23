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
<<<<<<< HEAD
$prov_origen = $_POST["prov-origen"];
$prov_destino = $_POST["prov-destino"];
$local_origen = $_POST["local-origen"];
$local_destino = $_POST["local-destino"];
$calle_origen = $_POST["calle-origen"];
$calle_destino = $_POST["calle-destino"];
=======
$origen = $_POST["origen"];
$destino = $_POST["destino"];
>>>>>>> Development

require("../../conexionBD.php");
$conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
if(mysqli_connect_errno()){
    echo "Fallo al conectar con la base de datos";
    exit();
}
mysqli_set_charset($conexion,"utf8");
<<<<<<< HEAD
$consulta = "INSERT INTO publicacion (titulo,descripcion,volumen,peso,provincia_origen,provincia_destino,localidad_origen,localidad_destino,calle_origen,calle_destino,idUsuario) VALUES ('$titulo','$descripcion','$volumen','$peso','$prov_origen','$prov_destino','$local_origen','$local_destino','$calle_origen','$calle_destino','$idUsuario')";
=======
$consulta = "INSERT INTO publicacion (titulo,descripcion,volumen,peso,origen,destino,idUsuario) VALUES ('$titulo','$descripcion','$volumen','$peso','$origen','$destino','$idUsuario')";
>>>>>>> Development
$resultado = mysqli_query($conexion,$consulta);


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




<!-- function ejecuta_insersion($volumen, $peso, $origen, $destino){

require("../conexionBD.php");
$conexion = mysqli_connect($db_host,$db_usuario,$db_contra);
if(mysqli_connect_errno()){
    echo "Fallo al conectar con la BD";
    exit();
}

mysqli_set_charset($conexion,"utf8");
$consulta = "INSERT INTO publicacion (volumen,peso,origen,destino) VALUES ('$volumen', '$peso','$origen','$destino')" ;
$resultado = mysqli_query($conexion,$consulta);

if($resultado == false){
    echo "Error en la consulta";
}else{
    echo "Registro guardado";
}
mysqli_close($conexion);
} -->