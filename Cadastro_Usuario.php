<?php
require_once './Config/Config.php';
require_once './Classes/Usuario.php';

$usuario = new Usuario($dbProjeto);

$nome = $sexo = $fone = $email = $senha = $cargo = '';
$nome_err = $fone_err = $email_err = $senha_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $sexo = $_POST['sexo'];
    $fone = htmlspecialchars(trim($_POST['fone']));
    $email = htmlspecialchars(trim($_POST['email']));
    $senha = $_POST['senha'];
    $cargo = htmlspecialchars(trim($_POST['cargo']));

    // Validação do nome
    if (empty($nome)) {
        $nome_err = 'Por favor, insira o nome.';
    }

    // Validação do e-mail
    if (empty($email)) {
        $email_err = 'Por favor, insira o endereço de email.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Formato de email inválido.';
    }

    // Validação da senha
    if (empty($senha)) {
        $senha_err = 'Por favor, insira a senha.';
    } elseif (strlen($senha) < 8) {
        $senha_err = 'A senha deve ter pelo menos 8 caracteres.';
    } elseif (!preg_match('/[A-Z]/', $senha)) {
        $senha_err = 'A senha deve conter pelo menos uma letra maiúscula.';
    } elseif (!preg_match('/[a-z]/', $senha)) {
        $senha_err = 'A senha deve conter pelo menos uma letra minúscula.';
    } elseif (!preg_match('/\d/', $senha)) {
        $senha_err = 'A senha deve conter pelo menos um número.';
    } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senha)) {
        $senha_err = 'A senha deve conter pelo menos um caractere especial.';
    }

    // Se não houver erros de validação, continuar
    if (empty($nome_err) && empty($email_err) && empty($senha_err)) {
        $registro = $usuario->registrar($nome, $sexo, $fone, $email, $senha, $cargo);
        if ($registro) {
            header('Location: Cadastro_Usuario.php');
            exit();
        } else {
            echo 'Erro ao registrar o usuário.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Meta viewport para responsividade -->
    <title>Cadastro de Usuário</title>
    <!-- Bootstrap CSS -->
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
            max-width: 90%; /* Largura máxima responsiva */
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        .form-group label {
            color: #00ffcc;
        }

        .error {
            color: #ff0000;
            font-size: 0.9em;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        select {
            width: 100%; /* Campo de entrada em 100% */
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #00ffcc;
            color: #000;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #ffcc00;
        }

        a {
            color: #ffffff;
            margin-top: 20px;
            display: inline-block;
            text-decoration: none;
        }

        a:hover {
            color: #ff00ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>">
                <span class="error"><?php echo $nome_err; ?></span>
            </div>
            <div class="form-group">
                <label for="sexo">Sexo:</label>
                <select id="sexo" name="sexo">
                    <option value="M" <?php if ($sexo === 'M') echo 'selected'; ?>>Masculino</option>
                    <option value="F" <?php if ($sexo === 'F') echo 'selected'; ?>>Feminino</option>
                </select>
            </div>
            <div class="form-group">
                <label for="fone">Telefone:</label>
                <input type="text" id="fone" name="fone" value="<?php echo htmlspecialchars($fone); ?>">
                <span class="error"><?php echo $fone_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha">
                <span class="error"><?php echo $senha_err; ?></span>
                <small>A senha deve ter pelo menos 8 caracteres, uma letra maiúscula, uma letra minúscula, um número e um caractere especial.</small>
            </div>
            <div class="form-group">
                <label for="cargo">Cargo:</label>
                <input type="text" id="cargo" name="cargo" value="<?php echo htmlspecialchars($cargo); ?>">
            </div>
            <div class="form-group">
                <input type="submit" value="Cadastrar">
            </div>
            <a href="Admin.php">Voltar</a>
        </form>
    </div>
</body>
</html>