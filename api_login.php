<?php 
$host = 'www.thyagoquintas.com.br';
$db   = 'engenharia_16';
$user = 'engenharia_16';
$pass = 'canariodaterra';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Recebe os dados via GET
    $usuario = isset($_GET['usuario']) ? $_GET['usuario'] : '';
    $senha = isset($_GET['senha']) ? $_GET['senha'] : '';

    // Consulta SQL para buscar o usuário
    $sql = "SELECT usuarioNome, usuarioEmail, usuarioSenha, usuarioCpf 
            FROM usuarios 
            WHERE usuarioEmail = :usuario AND usuarioSenha = :senha";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['usuario' => $usuario, 'senha' => $senha]);

    $usuarios = $stmt->fetchAll();

    // Retorna os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($usuarios);

} catch (\PDOException $e) {
    // Em caso de erro, você pode retornar um JSON com a mensagem de erro
    header('Content-Type: application/json');
    echo json_encode(['error' => "Erro de conexão: " . $e->getMessage()]);
    exit;
}
?>
