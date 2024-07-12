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
require_once './Classes/Tarefa.php';

$grupo = new Grupo($dbProjeto);
$tarefa = new Tarefa($dbProjeto);

$nome = $descricao = '';
$nome_err = $descricao_err = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grupo_id'])) {
    $grupo_id = $_POST['grupo_id'];

    $nome = htmlspecialchars(trim($_POST['nome']));
    $descricao = htmlspecialchars(trim($_POST['descricao']));

    if (empty($nome)) {
        $nome_err = 'Por favor, insira o nome.';
    }

    if (empty($nome_err) && empty($descricao_err)) {
        $registro = $tarefa->criar($grupo_id, $nome, $descricao);

        if ($registro) {
            header('Location: Admin.php');
            exit();
        } else {
            echo 'Erro ao registrar a tarefa.';
        }
    }
}

$grupos = $grupo->listarGrupos();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Tarefas</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0c0a3e, #4e2a91, #2c1a54);
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
            background: rgba(30, 30, 30, 0.9);
            max-width: 95%;
            width: 600px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .error {
            color: #ff00ff;
            font-size: 14px;
        }

        .msg {
            color: #00ffcc;
            margin-bottom: 20px;
            text-align: center;
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

        .btn-purple {
            background-color: #6f2c91;
            border: none;
        }

        .btn-purple:hover {
            background-color: #8e44ad;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 100%;
            }

            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="admin-info text-center">
            <p><?php echo "Nome: " . $admin_nome; ?></p>
            <p><?php echo "Cargo: " . $admin_cargo; ?></p>
        </div>
        <h1>Cadastrar Tarefas</h1>

        <?php if (isset($msg_adicionar)) : ?>
            <div class="msg"><?php echo $msg_adicionar; ?></div>
        <?php endif; ?>
        
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="grupo_id">Selecione o Grupo:</label>
                <select id="grupo_id" name="grupo_id" required class="form-control">
                    <option value="">Selecione um grupo</option>
                    <?php foreach ($grupos as $grupo) : ?>
                        <option value="<?php echo $grupo['id']; ?>"><?php echo $grupo['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo $nome; ?>" class="form-control">
                <span class="error"><?php echo $nome_err; ?></span>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" value="<?php echo $descricao; ?>" class="form-control">
                <span class="error"><?php echo $descricao_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" value="Cadastrar" class="btn btn-purple btn-block">
            </div>
            <p><a href="Admin.php" class="voltar-link">Voltar para Login de Administrador</a></p>
        </form>
    </div>
</body>

</html>