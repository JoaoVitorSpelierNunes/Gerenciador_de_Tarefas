<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: LoginAdmin.php"); 
    exit();
}

require_once './Config/Config.php';
require_once './Classes/Usuario.php';

$usuario = new Usuario($dbProjeto);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = htmlspecialchars($_POST['delete_id']);
    $delete_result = $usuario->excluirUsuario($delete_id);
    echo '<script>window.location.href = "ListaUsu.php";</script>';
    exit();
}

$usuarios = $usuario->listarUsuarios();

// Limitar a exibição a 5 usuários
$usuarios_limitados = array_slice($usuarios, 0, 5);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuários</title>
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
                width: 100%; /* Largura 100% para telas pequenas */
            }

            h1 {
                font-size: 24px; /* Tamanho menor para o título */
            }

            table {
                font-size: 14px; /* Tamanho da fonte menor para a tabela */
                display: block; /* Tabela se torna um bloco para rolagem */
                overflow-x: auto; /* Habilitar rolagem horizontal */
                white-space: nowrap; /* Impede quebra de linha nas células */
            }

            th, td {
                padding: 8px; /* Reduzir padding nas células */
            }

            .action-buttons {
                flex-direction: column; /* Colocar botões em coluna */
                align-items: flex-start; /* Alinhar à esquerda */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista de Usuários</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Sexo</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Cargo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios_limitados as $user) : ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['nome']; ?></td>
                        <td><?php echo $user['sexo']; ?></td>
                        <td><?php echo $user['fone']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['cargo']; ?></td>
                        <td class="action-buttons">
                            <form method="post" style="display: inline-block;">
                                <a href="EditarUsu.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Editar</a>
                                <input type="hidden" name="delete_id" value="<?php echo $user['id']; ?>">
                                <br><br>
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="Admin.php" class="voltar-link">Voltar</a></p>
    </div>
</body>
</html>