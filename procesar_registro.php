<?php
// Configuración de la conexión (XAMPP por defecto)
$servidor = "localhost";
$usuario_db = "root";
$password_db = "";
$nombre_db = "the_feast_db";

$conexion = mysqli_connect($servidor, $usuario_db, $password_db, $nombre_db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gamertag = $_POST['gamertag'];
    $email = $_POST['email'];
    // Encriptamos la contraseña por seguridad
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $platform = $_POST['platform'];
    
    // Convertimos los checkboxes en un solo texto
    $modos = isset($_POST['modo']) ? implode(", ", $_POST['modo']) : "";

    $sql = "INSERT INTO usuarios (gamertag, email, password, plataforma, modo_juego) 
            VALUES ('$gamertag', '$email', '$password', '$platform', '$modos')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('¡Registro exitoso! Bienvenido a la beta.'); window.location.href='index.html';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>