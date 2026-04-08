<?php
session_start();

// CONFIGURACIÓN DE TU ACCESO (Cámbialo aquí)
$usuario_admin = "adminCCTV";
$password_admin = "Corporation2026"; // Esta será tu contraseña para entrar

// Lógica de Login
if (isset($_POST['login'])) {
    if ($_POST['user'] == $usuario_admin && $_POST['pass'] == $password_admin) {
        $_SESSION['admin_auth'] = true;
    } else {
        $error = "Acceso denegado.";
    }
}

// Lógica de Logout
if (isset($_GET['logout'])) { session_destroy(); header("Location: admin.php"); }

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control - CCTV</title>
    <style>
        body { background: #0f0f1a; color: white; font-family: sans-serif; padding: 50px; }
        .login-box { max-width: 300px; margin: 100px auto; background: #161625; padding: 30px; border-radius: 10px; border: 1px solid #a27cff; }
        input { width: 100%; padding: 10px; margin: 10px 0; background: #000; border: 1px solid #333; color: white; }
        button { width: 100%; padding: 10px; background: #a27cff; border: none; color: white; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 12px; text-align: left; }
        th { background: #a27cff; }
    </style>
</head>
<body>

<?php if (!isset($_SESSION['admin_auth'])): ?>
    <div class="login-box">
        <h3>Admin CCTV</h3>
        <?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="user" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit" name="login">Entrar al Panel</button>
        </form>
    </div>
<?php else: ?>
    <h2>Panel de Registrados <a href="?logout=1" style="color:red; font-size:12px;">[Cerrar Sesión]</a></h2>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Gamertag</th>
            <th>Email</th>
            <th>Plataforma</th>
            <th>Modos</th>
            <th>Fecha</th>
        </tr>
        <?php
        // Aquí iría la conexión para listar los datos
        $conexion = mysqli_connect("localhost", "root", "", "the_feast_db");
        if ($conexion) {
            $resultado = mysqli_query($conexion, "SELECT * FROM usuarios ORDER BY id DESC");
            while($fila = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                        <td>{$fila['id']}</td>
                        <td>{$fila['gamertag']}</td>
                        <td>{$fila['email']}</td>
                        <td>{$fila['plataforma']}</td>
                        <td>{$fila['modo_juego']}</td>
                        <td>{$fila['fecha_registro']}</td>
                      </tr>";
            }
        }
        ?>
    </table>
<?php endif; ?>

</body>
</html>