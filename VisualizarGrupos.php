<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: LoginAdmin.php");
    exit();
}

$admin_nome = $_SESSION['admin_nome'];
$admin_cargo = "Administrador";

require_once './Config/Config.php';
require_once './Classes/Grupo.php';

$grupo = new Grupo($dbProjeto);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_grupo'])) {
    $grupo_id = $_POST['excluir_grupo'];
    $resultado = $grupo->excluirGrupo($grupo_id);

    if ($resultado) {
        $msg_excluir = "Grupo excluído com sucesso.";
    } else {
        $msg_excluir = "Erro ao excluir o grupo.";
    }
}

$grupos = $grupo->listarGrupos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Grupos</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .admin-info {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 14px;
            text-align: right;
        }
        .grupo-list {
            margin-top: 20px;
            border-collapse: collapse;
            width: 100%;
        }
        .grupo-list th, .grupo-list td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .grupo-list th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
        }
        .btn-danger {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="admin-info">
        <p><?php echo "Nome: " . $admin_nome; ?></p>
        <p><?php echo "Cargo: " . $admin_cargo; ?></p>
        <p><a href="LoginAdmin.php">Voltar para Login de Administrador</a></p>
    </div>
    <h1>Grupos Cadastrados</h1>

    <?php if (isset($msg_excluir)) : ?>
        <p><?php echo $msg_excluir; ?></p>
    <?php endif; ?>

    <table class="grupo-list">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Membros</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($grupos as $grupo) : ?>
                <tr>
                    <td><?php echo $grupo['id']; ?></td>
                    <td><?php echo $grupo['nome']; ?></td>
                    <td><?php echo $grupo['membros']; ?></td>
                    <td>
                        <form action="AdicionarUsuarios.php" method="post">
                            <input type="hidden" name="grupo_id" value="<?php echo $grupo['id']; ?>">
                            <button type="submit" class="btn">Adicionar Usuários</button>
                        </form>
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                            <input type="hidden" name="excluir_grupo" value="<?php echo $grupo['id']; ?>">
                            <button type="submit" class="btn btn-danger">Excluir Grupo</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>