<?php
include_once "connection.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_usuario.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $horario  = $_POST['horario'];
    $data = $_POST['data'];
    $user_id = $_SESSION['user_id'];

    $query = "UPDATE agendamento SET nome = ?, telefone = ?, horario = ?, data = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nome, $telefone, $horario, $data, $id, $user_id]);

    header("Location: home.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM agendamento WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id, $user_id]);
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: home.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agendamento</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Editar Agendamento</h5>
                    </div>
                    <div class="card-body">
                        <form action="editar_agendamento.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $agendamento['id']; ?>">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $agendamento['nome']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $agendamento['telefone']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="horario">Horário:</label>
                                <input type="text" class="form-control" id="horario" name="horario" value="<?php echo $agendamento['horario']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="data">Data:</label>
                                <input type="date" class="form-control" id="data" name="data" value="<?php echo $agendamento['data']; ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                            <a href="home.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
