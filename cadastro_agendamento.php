<?php
include_once "connection.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_usuario.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nome']) && isset($_POST['telefone']) && isset($_POST['horario']) && isset($_POST['data'])) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $horario  = $_POST['horario'];
        $data = $_POST['data'];
        $user_id = $_SESSION['user_id'];
        if (empty($nome) || empty($telefone) || empty($horario) || empty($data) || empty($user_id)) {
            echo "Preencha os campos obrigatórios";
        } else {
            $query1 = "SELECT * FROM agendamento WHERE horario = ? AND data = ?";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(1, $horario, PDO::PARAM_STR);
            $stmt1->bindParam(2, $data, PDO::PARAM_STR);
            $stmt1->execute();
            if ($stmt1->rowCount() == 0) {
                $query2 = "INSERT INTO agendamento (nome, telefone, horario, data, user_id) VALUES (?, ?, ?, ?, ?)";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bindParam(1, $nome, PDO::PARAM_STR);
                $stmt2->bindParam(2, $telefone, PDO::PARAM_STR);
                $stmt2->bindParam(3, $horario, PDO::PARAM_STR);
                $stmt2->bindParam(4, $data, PDO::PARAM_STR);
                $stmt2->bindParam(5, $user_id, PDO::PARAM_INT);
                $stmt2->execute();
                header("Location: home.php");
                exit();
            } else {
                echo "Já existe um agendamento para o horário e data especificados.";
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
    <title>Cadastro Agendamento</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Cadastro de Agendamento</h5>
                    </div>
                    <div class="card-body">
                        <form action="cadastro_agendamento.php" method="POST">
                            <div class="form-group">
                                <label for="nome">Nome:</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="form-group">
                                <label for="telefone">Telefone:</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" required>
                            </div>
                            <div class="form-group">
                                <label for="horario">Horário:</label>
                                <input type="datetime" class="form-control" id="horario" name="horario" required>
                            </div>
                            <div class="form-group">
                                <label for="data">Data:</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
