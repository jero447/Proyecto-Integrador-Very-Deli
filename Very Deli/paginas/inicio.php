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
            <p class="btn-iniciar">Iniciar Sesion</p>
            <a class="btn-registrarse" href="./registro.php">Registrarse</a>
        </div>
    </header>
    <main>
        <div class = "formulario-login">
            <h2>Iniciar Sesion</h2>
            <div class = "contenedor-correo">
                <label for="">Correo Electronico</label>
                <input type="text" placeholder="usuario@gmail.com">
            </div>
            <div class= "contenedor-contraseña">
                <label for="">Contraseña</label>
                <input type="text">
            </div>
            <div>
                <input type="submit" value="Iniciar">
            </div>
            
        </div>
    </main>
    <footer>
        <p>Universidad Nacional de San Luis</p>
        <p>Programacion III</p>
    </footer>
</body>
</html>