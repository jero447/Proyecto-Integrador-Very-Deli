<?php

    require("./conexionBD.php");
    $conexion = mysqli_connect($db_host,$db_usuario,$db_contra,$db_nombre);
            
    if(mysqli_connect_errno()){
        echo "Fallo al conectar con la base de datos";
        exit();
    }

    $idUsuario = $_SESSION['idUsuario'];

    $sql = "SELECT idPublicacion, volumen, peso, origen, destino, titulo, descripcion
            FROM publicacion
            WHERE idUsuario = ?";

    $stmt = $conn->prepare($sql);
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
            echo "<p><strong>Origen:</strong> " . $row['origen'] . "</p>";
            echo "<p><strong>Destino:</strong> " . $row['destino'] . "</p>";
            echo "</div>";
        }
    
        echo "</div>"; 
    } else {
        echo "No se encontraron publicaciones.";
    }

?>