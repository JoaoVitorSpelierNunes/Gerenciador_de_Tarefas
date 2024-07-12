<?php
session_start();

require_once './Config/Config.php';
require_once './Classes/Administrador.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $codigo = htmlspecialchars(trim($_POST['codigo']));

    $admin = new Administrador($dbProjeto);
    $admin_logado = $admin->login($nome, $codigo);

    if ($admin_logado) {
        $_SESSION['admin_id'] = $admin_logado['id'];
        $_SESSION['admin_nome'] = $admin_logado['nome'];
        header('Location: Admin.php');
        exit();
    } else {
        $login_err = 'Nome ou código incorretos.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Login Administrador</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            border-radius: 9px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            width: 450px;
            background: linear-gradient(0, #120c56, #000000);
        }

        h2 {
            color: #3e6b8f;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            color: #3e6b8f;
            font-size: 1.1em;
            margin-bottom: 8px;
        }

        .form-group input {
            width: calc(100% - 20px);
            /* Ajuste para compensar o padding */
            padding: 10px;
            font-size: 1em;
            border: 1px solid #dfe6eb;
            border-radius: 5px;
            transition: border-color 0.3s ease-in-out;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3e6b8f;
        }

        .form-group .error {
            color: #ff6347;
            font-size: 0.9em;
            margin-top: 4px;
        }

        .form-group input[type="submit"] {
            background-color: #3e6b8f;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1em;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .form-group input[type="submit"]:hover {
            background-color: #2a4b6e;
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
            .container {
                padding: 20px;
            }

            .form-group input {
                font-size: 0.9em;
            }

            .form-group input[type="submit"] {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="stars"></div>
        <div class="stars2"></div>
        <h2>Login Administrador</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="password" id="codigo" name="codigo" required>
            </div>
            <?php if (isset($login_err)) : ?>
                <p style="color: #ff6347;"><?php echo $login_err; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
            <a href="Login.php">Voltar</a>
        </form>
    </div>
</body>

</html>