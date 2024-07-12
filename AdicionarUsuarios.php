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
require_once './Classes/Usuario.php';

$grupo = new Grupo($dbProjeto);
$usuario = new Usuario($dbProjeto);

$grupo_id = $_POST['grupo_id'];
$membrosGrupo = $grupo->getMembrosPorGrupo($grupo_id); // Método que retorna a quantidade de membros permitidos
$usuariosNoGrupo = $usuario->listarUsuariosPorGrupo($grupo_id);
$totalUsuarios = count($usuariosNoGrupo);

// Verifica se a quantidade de membros já atingiu o limite
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($totalUsuarios >= $membrosGrupo) {
        echo '<div class="msg-limite">Erro: O grupo já atingiu o limite de membros.</div>';
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grupo_id']) && isset($_POST['usuario_id'])) {
    $grupo_id = $_POST['grupo_id'];
    $usuario_id = $_POST['usuario_id'];

    $resultado = $usuario->adicionarGrupo($usuario_id, $grupo_id);

    if ($resultado) {
        $msg_adicionar = "Usuário adicionado ao grupo com sucesso.";
    } else {
        $msg_adicionar = "Erro ao adicionar o usuário ao grupo.";
    }
}

$grupos = $grupo->listarGrupos();
$usuarios = $usuario->listarUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Usuários ao Grupo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0c0a3e, #4e2a91, #2c1a54);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            padding: 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: auto;
            text-align: center;
            padding: 40px;
            background: rgba(18, 18, 18, 0.9);
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
        }

        h1 {
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        .msg {
            color: #00ffcc;
            margin-bottom: 20px;
        }

        .msg-limite {
            color: #ff0000;
            /* Vermelho */
            background-color: rgba(255, 0, 0, 0.1);
            /* Fundo levemente vermelho */
            border: 1px solid #ff0000;
            /* Borda vermelha */
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }


        .form-group {
            margin-bottom: 20px;
        }

        select {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid #444;
        }

        option {
            background: #2c1a54;
        }

        button {
            background-color: #6f2c91;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #ff00ff;
        }

        a {
            color: #ffffff;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        a:hover {
            color: #ff00ff;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 90%;
            }

            h1 {
                font-size: 24px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="admin-info">
            <p><?php echo "Nome: " . $admin_nome; ?></p>
            <p><?php echo "Cargo: " . $admin_cargo; ?></p>
        </div>
        <h1>Adicionar Usuários ao Grupo</h1>

        <?php if (isset($msg_adicionar)) : ?>
            <div class="msg"><?php echo $msg_adicionar; ?></div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="grupo_id">Selecione o Grupo:</label>
                <select id="grupo_id" name="grupo_id" required>
                    <option value="">Selecione um grupo</option>
                    <?php foreach ($grupos as $grupo) : ?>
                        <option value="<?php echo $grupo['id']; ?>"><?php echo $grupo['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="usuario_id">Selecione o Usuário:</label>
                <select id="usuario_id" name="usuario_id" required>
                    <option value="">Selecione um usuário</option>
                    <?php foreach ($usuarios as $usuario) : ?>
                        <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Adicionar Usuário</button>
            </div>
            <p><a href="ListarGrupos.php">Voltar</a></p>
        </form>
    </div>
</body>

</html>