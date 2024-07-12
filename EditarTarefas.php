<?php
session_start();

require_once './Config/Config.php';
require_once './Classes/Usuario.php';
require_once './Classes/Administrador.php';
require_once './Classes/Tarefa.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: Login.php');
    exit();
}

$usuario = new Usuario($dbProjeto);
$tarefa = new Tarefa($dbProjeto);

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $user = $tarefa->lerPorId($id);
    if (!$user) {
        header('Location: ListarTarefas.php');
        exit();
    }
} else {
    header('Location: ListaTarefa.php');
    exit();
}

$progresso_err = $anotacao_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $progresso = htmlspecialchars(trim($_POST['progresso']));
    $anotacao = htmlspecialchars(trim($_POST['anotacao']));

    $edicao = $tarefa->atualizar($id, $progresso, $anotacao);
    if ($edicao) {
        header('Location: ListarTarefas.php');
        exit();
    } else {
        echo 'Erro ao editar a Tarefa.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Progresso da Tarefa</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #000428, #004e92);
            /* Gradiente galáctico */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(30, 30, 60, 0.8);
            /* Fundo semi-transparente */
            border-radius: 9px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        h2 {
            color: #ffcc00;
            /* Amarelo galáctico */
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            color: #ffffff;
            /* Texto branco */
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .form-group input,
        .form-group select {
            width: calc(100% - 20px);
            /* Ajuste para compensar o padding */
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease-in-out;
            background: rgba(255, 255, 255, 0.1);
            /* Fundo semi-transparente */
            color: #ffffff;
            /* Texto claro */
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ffcc00;
            /* Amarelo galáctico */
        }

        .form-group .error {
            color: #ff0000;
            font-size: 0.9em;
            margin-top: 4px;
        }

        .form-group input[type="submit"] {
            background-color: #4b0082;
            /* Roxo galáctico */
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .form-group input[type="submit"]:hover {
            background-color: #7200b8;
            /* Roxo mais claro */
        }

        /* Estilos específicos para dispositivos móveis */
        @media screen and (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h2 {
                font-size: 1.5em;
            }

            .form-group label {
                font-size: 1em;
            }

            .form-group input,
            .form-group select {
                font-size: 0.9em;
            }

            .form-group input[type="submit"] {
                font-size: 0.9em;
                padding: 10px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Editar Progresso da Tarefa</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id); ?>" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo isset($nome) ? $nome : $user['nome']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" value="<?php echo isset($descricao) ? $descricao : $user['descricao']; ?>" disabled>
            </div>
            <div class="form-group">
                <label for="progresso">Progresso:</label>
                <select id="progresso" name="progresso">
                    <option value="pendente">Pendente</option>
                    <option value="em andamento">Em andamento</option>
                    <option value="concluida">Concluída</option>
                </select>
            </div>
            <div class="form-group">
                <label for="anotacao">Anotações:</label>
                <textarea name="anotacao" id="anotacao"><?php echo isset($anotacao) ? $anotacao : $user['anotacao']; ?></textarea>
                <span class="error"><?php echo $anotacao_err; ?></span>
            </div>

            <div class="form-group">
                <input type="submit" value="Salvar" class="btn">
            </div>
            <a href="ListarTarefas.php" class="voltar-link">Voltar</a>
        </form>
    </div>
</body>

</html>