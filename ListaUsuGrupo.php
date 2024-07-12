<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: LoginAdmin.php");
    exit();
}

require_once './Config/Config.php';
require_once './Classes/Usuario.php';

$admin_nome = $_SESSION['admin_nome'];
$admin_cargo = "Administrador";

$grupo_id = null;
if (isset($_GET['grupo_id'])) {
    $grupo_id = $_GET['grupo_id'];
} else {
    header("Location: ListarGrupos.php");
    exit();
}

$usuario = new Usuario($dbProjeto);
$usuariosNoGrupo = $usuario->listarUsuariosPorGrupo($grupo_id);

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Usuários neste Grupo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #5e4b8c; /* Cor única roxa */
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            padding: 20px;
            margin: 0;
        }

        .admin-info {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 10px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #444;
        }

        th {
            background-color: #6f2c91;
            color: #ffffff;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        a {
            color: #ffffff;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        a:hover {
            color: #ff00ff;
        }
    </style>
</head>

<body>
    <div class="admin-info">
        <p><?php echo "Nome: " . $admin_nome; ?></p>
        <p><?php echo "Cargo: " . $admin_cargo; ?></p>
    </div>
    <h1>Listagem de Usuários por Grupo</h1>

    <h2>Grupo: <?php echo $grupo_id; ?></h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Sexo</th>
                <th>Email</th>
                <th>Cargo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuariosNoGrupo as $usuario) : ?>
                <tr>
                    <td><?php echo $usuario['id']; ?></td>
                    <td><?php echo $usuario['nome']; ?></td>
                    <td><?php echo $usuario['sexo']; ?></td>
                    <td><?php echo $usuario['email']; ?></td>
                    <td><?php echo $usuario['cargo']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p><a href="ListarGrupos.php">Voltar</a></p>
</body>

</html>