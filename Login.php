<?php
require_once './Config/Config.php';
require_once './Classes/Usuario.php';

$usuario = new Usuario($dbProjeto);
$email = $senha = '';
$email_err = $senha_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    if (empty($email)) {
        $email_err = 'Por favor, insira o endereço de email.';
    }
    if (empty($senha)) {
        $senha_err = 'Por favor, insira a senha.';
    }
    if (empty($email_err) && empty($senha_err)) {
        $usuario_logado = $usuario->login($email, $senha);
        if ($usuario_logado) {
            session_start();
            $_SESSION['usuario_id'] = $usuario_logado['id'];
            $_SESSION['usuario_nome'] = $usuario_logado['nome'];
            $_SESSION['usuario_cargo'] = $usuario_logado['cargo'];
            header('Location: ListarTarefas.php');
            exit();
        } else {
            $login_err =  'Email ou senha incorretos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;

            .container {
                border-radius: 9px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                padding: 30px;
                max-width: 400px;
                width: 90%;
                text-align: center;
                width: 350px;

            }
        }

        body {
            font-family: Arial, sans-serif;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            border-radius: 9px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            width: 450px;
            background: linear-gradient(0, #120c56, #000000);
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: white;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group .error {
            color: #ff0000;
            font-size: 14px;
        }

        .submit-btn {
            width: 100%;
            padding: 10px;
            background-color: #4B0082;
            border: none;
            color: #fff;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #120c56;
        }

        .stars {
            width: 3px;
            height: 3px;
            border-radius: 50%;
            box-shadow: 50px 30px white,
                100px 80px white,
                80px 120px white,
                300px 20px white,
                250px 130px white,
                200px 50px white,
                150px 100px white,
                320px 100px white;
            animation: anim-stars 10s linear infinite;
        }

        .stars::after {
            content: " ";
            width: 3px;
            height: 3px;
            border-radius: 50%;
            box-shadow: 50px 30px white,
                100px 80px white,
                80px 120px white,
                300px 20px white,
                250px 130px white,
                200px 50px white,
                150px 100px white,
                320px 100px white;
            content: " ";
            position: absolute;
            top: 180px;
            width: 3px;
        }

        .stars2 {
            position: relative;
            width: 1px;
            height: 1px;
            border-radius: 50%;
            box-shadow: 15px 15px white,
                125px 35px white,
                50px 80px white,
                10px 120px white,
                275px 90px white,
                230px 10px white,
                120px 130px white,
                300px 130px white,
                220px 115px white;
            animation: anim-stars 20s linear infinite;
        }

        .stars2::after {
            content: " ";
            position: absolute;
            top: 150px;
            width: 1px;
            height: 1px;
            border-radius: 50%;
            box-shadow: 15px 15px white,
                125px 35px white,
                50px 80px white,
                10px 120px white,
                275px 90px white,
                230px 10px white,
                120px 130px white,
                300px 130px white,
                220px 115px white;
        }

        @keyframes anim-stars {
            from {
                transform: translateY(0px);
            }

            to {
                transform: translateY(-150px);
            }
        }

        /* Estilos específicos para dispositivos móveis */
        @media screen and (max-width: 600px) {
            .form-container {
                width: 100%;
                padding: 10px;
            }

            .form-group input {
                font-size: 14px;
            }

            .submit-btn {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="stars"></div>
        <div class="stars2"></div>
        <h2>Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha">
                <span class="error"><?php echo $senha_err; ?></span>
            </div>
            <?php if (isset($login_err)) : ?>
                <p style="color: #ff6347;"><?php echo $login_err; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <input type="submit" value="Login" class="submit-btn">
            </div>
            <br><br>
            <a href="LoginAdmin.php">Administrador</a>
        </form>
    </div>
</body>

</html>