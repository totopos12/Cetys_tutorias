<?php
session_start();
include "php/conexion_be.php";

$user_id = $_GET['user_id'];
$current_user = $_SESSION['nombre_completo']; // Usuario actual

// Consulta para obtener los mensajes entre los dos usuarios
$sql = "SELECT * FROM messages 
        WHERE (incoming_msg_id = '$user_id' AND outgoing_msg_id = '$current_user')
        OR (incoming_msg_id = '$current_user' AND outgoing_msg_id = '$user_id')
        ORDER BY msg_id ASC";
$query = mysqli_query($conexion, $sql);

$output = '<div class="chat-area">
    <header>
        <a href="bienvenida.php" class="back-icon">←</a>
        <img src="assets/images/user.jpg" alt="user-img">
        <div class="details">
            <span>'.htmlspecialchars($user_id).'</span>
        </div>
    </header>
    <div class="chat-box" id="chat-box">';

// Mostrar los mensajes
if (mysqli_num_rows($query) > 0) {
    while ($row = mysqli_fetch_assoc($query)) {
        if ($row['outgoing_msg_id'] === $current_user) {
            // Mensaje saliente
            $output .= '<div class="chat outgoing">
                <div class="details">
                    <p>'.htmlspecialchars($row['msg']).'</p>
                </div>
            </div>';
        } else {
            // Mensaje entrante
            $output .= '<div class="chat incoming">
                <img src="assets/images/other-user.jpg" alt="user-img">
                <div class="details">
                    <p>'.htmlspecialchars($row['msg']).'</p>
                </div>
            </div>';
        }
    }
} else {
    $output .= '<div class="text">No hay mensajes aún</div>';
}

$output .= '</div>
    <div class="typing-area">
        <input id="message-input" type="text" placeholder="Escribe un mensaje...">
        <button onclick="sendMessage(\''.$user_id.'\')" class="active">Enviar</button>
    </div>
</div>';

echo $output;
