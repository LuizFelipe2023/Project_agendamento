<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: login_usuario.php");
    exit();
}


include_once "connection.php";


$registros_por_pagina = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $registros_por_pagina;


$query = "SELECT * FROM agendamento WHERE user_id = ? LIMIT $offset, $registros_por_pagina";
$stmt = $conn->prepare($query);
$stmt->execute([$_SESSION['user_id']]);
$agendamentos = $stmt->fetchAll(PDO::FETCH_ASSOC);


$query_count = "SELECT COUNT(*) AS total FROM agendamento WHERE user_id = ?";
$stmt_count = $conn->prepare($query_count);
$stmt_count->execute([$_SESSION['user_id']]);
$total_agendamentos = $stmt_count->fetchColumn();

$total_paginas = ceil($total_agendamentos / $registros_por_pagina);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
<h2 class="text-center">Project-Agendamento</h2>
<br>
        <div class="row justify-content-between">
            <h2 class="mb-4">Agendamentos</h2> 
            <div class="mb-4">
                <a href="logout.php" class="btn btn-success">Logout</a>
                <a href="cadastro_agendamento.php" class="btn btn-success">Novo Agendamento</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Horário</th>
                        <th scope="col">Data</th>
                        <th scope="col">User ID</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($agendamentos as $agendamento) : ?>
                        <tr>
                            <td><?php echo $agendamento['id']; ?></td>
                            <td><?php echo $agendamento['nome']; ?></td>
                            <td><?php echo $agendamento['telefone']; ?></td>
                            <td><?php echo $agendamento['horario']; ?></td>
                            <td><? echo date('d/m/Y', strtotime($agendamento['data'])); ?></td>
                            <td><?php echo $agendamento['user_id']; ?></td>
                            <td>
                                <a href="edit_agendamento.php?id=<?php echo $agendamento['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <a href="excluir_agendamento.php?id=<?php echo $agendamento['id']; ?>" class="btn btn-danger btn-sm">Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <nav aria-label="Navegação de página">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>

</body>
</html>

</body>

</html>