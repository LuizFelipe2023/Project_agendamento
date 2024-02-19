<?php
include_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['telefone']) && isset($_POST['cpf'])) {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $telefone = $_POST['telefone'];
        $cpf = $_POST['cpf'];
        if (empty($nome) || empty($email) || empty($senha) || empty($telefone) || empty($cpf)) {
            echo "Preencha todos os campos obrigatórios";
        } else {
            $filtroEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
            if ($filtroEmail === false) {
                echo "Email inválido";
            } else {
                $senhacomHash = password_hash($senha, PASSWORD_BCRYPT);
                $query = "INSERT INTO usuarios (nome, email, senha, telefone, cpf) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $success = $stmt->execute([$nome, $filtroEmail, $senhacomHash, $telefone, $cpf]);
                if ($success) {
                    echo "Usuário criado com sucesso";
                    header("Location: login_usuario.php");
                    exit();
                } else {
                    echo "Erro ao criar o usuário";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Registro</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
<h2 class="text-center">Project-Agendamento</h2>
<br>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Registro de Usuário</h5>
                </div>
                <div class="card-body">
                    <form action="cadastrar_usuario.php" method="POST">
                        <div class="form-group">
                            <label for="nome">Nome:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha:</label>
                            <input type="password" class="form-control" id="senha" name="senha" required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone:</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" required>
                        </div>
                        <div class="form-group">
                            <label for="cpf">CPF:</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
                <div class="card-footer bg-light">
                    <p class="mb-0">Tem uma conta? <a href="login_usuario.php">Logue</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
