<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: LoginAdmin.php"); 
    exit();
}

require_once './Config/Config.php';
require_once './Classes/Grupo.php';

$grupo = new Grupo($dbProjeto);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = htmlspecialchars($_POST['delete_id']);
    $delete_result = $grupo->excluirGrupo($delete_id);
    echo '<script>window.location.href = "ListarGrupos.php";</script>';
    exit();
}

$grupos = $grupo->listarGrupos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Grupos</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            background: rgba(18, 18, 18, 0.9);
            max-width: 95%;
            width: 800px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #444;
        }

        th {
            background-color: #00ffcc;
            color: #000;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .voltar-link {
            color: #ffffff;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            text-align: center;
        }

        .voltar-link:hover {
            color: #ff00ff;
        }

        button {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 100%;
            }

            h1 {
                font-size: 24px;
            }

            table {
                font-size: 14px;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                padding: 8px;
            }

            .action-buttons {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Grupos</h1>
        <table>
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
                        <td class="action-buttons">
                            <a href="ListaUsuGrupo.php?grupo_id=<?php echo $grupo['id']; ?>" class="btn btn-info btn-sm">Listar Usuários</a>
                            <form method="post" style="display: inline-block;">
                                <input type="hidden" name="delete_id" value="<?php echo $grupo['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <form action="AdicionarUsuarios.php" method="post">
            <input type="hidden" name="grupo_id" value="<?php echo $grupo['id']; ?>">
            <button type="submit" class="btn btn-success">Adicionar Usuários aos Grupos</button>
        </form>
        <br>
        <a href="Admin.php" class="voltar-link">Voltar</a>
    </div>
</body>
</html>