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

$msg_cadastro = '';
$resultado = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $membros = $_POST['membros'];

    // Verificar se o grupo já existe
    if ($grupo->grupoExiste($nome)) {
        $msg_cadastro = "Erro: Já existe um grupo com esse nome.";
    } else {
        $resultado = $grupo->cadastrarGrupo($nome, $membros);

        if ($resultado) {
            $msg_cadastro = "Grupo cadastrado com sucesso!";
        } else {
            $msg_cadastro = "Ops! Houve um erro ao cadastrar o grupo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Grupo</title>
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
            padding: 30px;
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            background: rgba(18, 18, 18, 0.8);
            max-width: 90%;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        label {
            color: #00ffcc;
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #00ffcc;
            color: #000;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #ffcc00;
        }

        .msg {
            color: #00ffcc;
            margin-top: 20px;
        }

        .msg-error {
            color: #ff0000;
            margin-top: 20px;
        }

        .voltar-link {
            color: #ffffff;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        .voltar-link:hover {
            color: #ff00ff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="admin-info">
            <span><?php echo $admin_nome; ?></span><br>
            <span><?php echo $admin_cargo; ?></span>
        </div>
        <h1>Cadastro de Grupo</h1>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="nome">Nome do Grupo:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="membros">Número de Membros:</label>
            <input type="number" id="membros" name="membros" required>

            <input type="submit" value="Cadastrar">

            <?php if (!empty($msg_cadastro)) : ?>
                <p class="<?php echo $resultado ? 'msg' : 'msg-error'; ?>">
                    <?php echo $msg_cadastro; ?>
                </p>
            <?php endif; ?>

            <p><a href="Admin.php" class="voltar-link">Voltar</a></p>
        </form>
    </div>
</body>
</html>