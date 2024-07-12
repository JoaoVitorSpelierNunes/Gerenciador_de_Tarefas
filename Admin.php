<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Adicionado meta viewport -->
    <title>Portal do Administrador</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            text-align: center;
            min-height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        h2 {
            margin-top: 20px;
            text-shadow: 0 0 20px rgba(255, 255, 255, 0.7);
        }

        .container {
            padding: 30px; /* Menor padding para telas pequenas */
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(255, 255, 255, 0.2);
            background: rgba(18, 18, 18, 0.8);
            max-width: 90%; /* Aumenta a largura máxima para telas pequenas */
            text-align: center;
        }

        .voltar-link {
            color: #00ffcc;
            text-decoration: none;
            transition: color 0.3s;
        }

        .voltar-link:hover {
            color: #ffcc00;
            text-shadow: 0 0 10px rgba(255, 204, 0, 0.7);
        }

        a {
            color: #ffffff;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            transition: color 0.3s;
        }

        a:hover {
            color: #ff00ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Portal do Administrador</h2>
        <p><a href="Cadastro_Usuario.php" class="voltar-link">Cadastrar Funcionários</a></p>
        <p><a href="CadastroGrupo.php" class="voltar-link">Cadastrar Grupos</a></p>
        <p><a href="CadastrarTarefas.php" class="voltar-link">Cadastrar Tarefas</a></p>
        <p><a href="ListaUsu.php" class="voltar-link">Usuários</a></p>
        <p><a href="ListarGrupos.php" class="voltar-link">Grupos</a></p>
        <a href="Login.php">Sair</a>
    </div>
</body>
</html>