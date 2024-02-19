<?php
include_once "connection.php";
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_usuario.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $user_id = $_SESSION['user_id'];

    $query = "DELETE FROM agendamentos WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$id, $user_id]);

    header("Location: home.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
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
    <title>Excluir Agendamento</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Excluir Agendamento</h5>
                    </div>
                    <div class="card-body">
                        <p>Você tem certeza que deseja excluir este agendamento?</p>
                        <form action="excluir_agendamento.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <button type="submit" class="btn btn-danger">Sim, excluir</button>
                            <a href="home.php" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
