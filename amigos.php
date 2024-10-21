<?php
session_start();
include 'php/conexion_be.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: php/login_usuario_be.php"); // Redirigir a la página de inicio de sesión si no está autenticado
    exit();
}

// Obtener la lista de amigos (suponiendo que tienes una tabla de amigos)
$query = "SELECT nombre_completo FROM usuarios WHERE correo != '{$_SESSION['usuario']}'";
$result = mysqli_query($conexion, $query);

if (!$result) {
    die('Consulta fallida: ' . mysqli_error($conexion)); // Mostrar error si la consulta falla
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/estilos_inicio.css">
    <title>Amigos</title>
</head>
<body>
    <header>
        <div class="logo">
        <img src="assets/images/bg3.jpg" alt="Logo">
        <h1>Chat App</h1>
    </div>

        <nav>
            <a href="bienvenida.php">Inicio</a>
            <a href="php/cerrar_sesion.php">Cerrar Sesión</a>
        </nav>
    </header>

    <div class="sidebar">
        <h2>Lista de Amigos</h2>
        <div class="users-list">
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <a href="#" class="user-button" onclick="openChat('<?php echo $row['nombre_completo']; ?>')">
                    <?php echo htmlspecialchars($row['nombre_completo']); ?>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <div class="content">
        <!-- Aquí puedes agregar contenido adicional -->
    </div>

    <!-- Ventana de chat -->
    <div id="chat-window" style="display: none;"> <!-- Oculto por defecto -->
        <header>
            <span id="chat-user-name">Nombre del Usuario</span>
            <button onclick="closeChat()">X</button>
        </header>
        <div class="chat-box" id="chat-box">
            <!-- Los mensajes se cargarán aquí -->
        </div>
        <div class="typing-area">
            <form id="send-message-form" onsubmit="sendMessage(event)">
                <input type="text" id="message-input" placeholder="Escribe un mensaje..." required>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <script>
        function openChat(userName) {
            document.getElementById('chat-user-name').innerText = userName;
            document.getElementById('chat-window').style.display = 'block';
            loadMessages(userName);
        }

        function closeChat() {
            document.getElementById('chat-window').style.display = 'none';
        }

        function loadMessages(userName) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "php/get_messages.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                document.getElementById('chat-box').innerHTML = this.responseText;
            };
            xhr.send("nombre_destino=" + encodeURIComponent(userName));
        }

        function sendMessage(event) {
            event.preventDefault();
            const messageInput = document.getElementById('message-input');
            const userName = document.getElementById('chat-user-name').innerText;

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "php/send_message.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                messageInput.value = ''; // Limpiar el campo de entrada
                loadMessages(userName); // Recargar los mensajes
            };
            xhr.send("nombre_destino=" + encodeURIComponent(userName) + "&mensaje=" + encodeURIComponent(messageInput.value));
        }
    </script>
</body>
</html>
