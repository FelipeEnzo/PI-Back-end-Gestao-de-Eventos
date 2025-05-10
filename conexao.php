<?php
// Fazer a conexão ao banco de dados MySQL
// Placeholder
$servername = "localhost"; // Tipo de servidor
$usuario = "seu_usuario";
$senha =  "sua_senha";
$dbname = "seu_banco_de_dados"; //Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $usuario, $senha, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>