<?php
session_start();

require_once './Config/Config.php';
require_once './Classes/Usuario.php';
require_once './Classes/Administrador.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: Login.php');
    exit();
}

$usuario = new Usuario($dbProjeto);

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $user = $usuario->getUsuarioById($id);
    if (!$user) {
        header('Location: ListaUsu.php');
        exit();
    }
} else {
    header('Location: ListaUsu.php');
    exit();
}

$nome_err = $sexo_err = $fone_err = $email_err = $cargo_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $sexo = $_POST['sexo'];
    $fone = htmlspecialchars(trim($_POST['fone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $cargo = htmlspecialchars(trim($_POST['cargo']));
    $ferias = $_POST['ferias'];

    if (empty($nome)) {
        $nome_err = 'Por favor, insira o nome.';
    }

    if (empty($nome_err) && empty($sexo_err) && empty($fone_err) && empty($email_err) && empty($cargo_err)) {
        $edicao = $usuario->editarUsuario($id, $nome, $sexo, $fone, $email, $cargo, $ferias);
        if ($edicao) {
            header('Location: ListaUsu.php');
            exit();
        } else {
            echo 'Erro ao editar o usuário.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
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

        h2 {
            margin-bottom: 20px;
            text-align: center;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        .form-group label {
            font-weight: bold;
            color: #00ffcc;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #444;
            background-color: rgba(200, 200, 255, 0.1);
            color: #ffffff;
        }

        .form-group input[type="submit"] {
            background-color: #00ffcc;
            color: #000;
            border: none;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background-color: #00e6b3;
        }

        .error {
            color: #ff00ff;
            font-size: 0.9em;
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

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                width: 100%;
            }

            h2 {
                font-size: 24px;
            }

            .form-group input, .form-group select {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Usuário</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id); ?>" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo isset($nome) ? $nome : $user['nome']; ?>">
                <span class="error"><?php echo $nome_err; ?></span>
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo">
                    <option value="M" <?php if (isset($sexo) && $sexo === 'M') echo 'selected'; ?>>Masculino</option>
                    <option value="F" <?php if (isset($sexo) && $sexo === 'F') echo 'selected'; ?>>Feminino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fone">Telefone:</label>
                <input type="text" id="fone" name="fone" value="<?php echo isset($fone) ? $fone : $user['fone']; ?>">
                <span class="error"><?php echo $fone_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($email) ? $email : $user['email']; ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" value="<?php echo isset($cargo) ? $cargo : $user['cargo']; ?>">
                <span class="error"><?php echo $cargo_err; ?></span>
            </div>
            <div class="form-group">
                <label for="ferias">ferias:</label>
                <select id="ferias" name="ferias">
                    <option value="0" <?php if (isset($ferias) && $ferias === false) echo 'selected'; ?>>Não</option>
                    <option value="1" <?php if (isset($ferias) && $ferias === true) echo 'selected'; ?>>Sim</option>
                </select>
            </div>
            <div class="form-group">
                <input type="submit" value="Salvar" class="btn">
            </div>
            <a href="ListaUsu.php" class="voltar-link">Voltar</a>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>