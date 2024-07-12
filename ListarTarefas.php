<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: Login.php");
    exit();
}



require_once './Config/Config.php';
require_once './Classes/Usuario.php';
require_once './Classes/Tarefa.php';

$tarefa = new Tarefa($dbProjeto);
$usuario = new Usuario($dbProjeto);

$verifica = $usuario->verificarFerias($_SESSION['usuario_id']);

$ferias = implode(" ",$verifica);

if (($_SESSION['usuario_id'])) {
    if($ferias){
        header("Location: Ferias.php");
        exit();
    }
}

$grupo = $usuario->getGrupoById($_SESSION['usuario_id']);



$grupo_id = implode(" ", $grupo);

$tarefas = $tarefa->lerIdgrupo($grupo_id);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.2/html2pdf.bundle.min.js" integrity="sha512-MpDFIChbcXl2QgipQrt1VcPHMldRILetapBl5MPCA9Y8r7qvlwx1/Mc9hNTzY+kS5kX6PdoDq41ws1HiVNLdZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="script.js" defer></script>   
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #1c1c3f;
            /* Fundo galáxia */
            color: #e0e0e0;
            /* Texto claro */
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #2b2b56;
            /* Container galáxia */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            font-family: 'Georgia', serif;
            font-size: 28px;
            color: #ffcc00;
            /* Cor de destaque */
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #444;
            /* Borda escura */
        }

        table th {
            background-color: #5c5c88;
            /* Cabeçalho com tom galáctico */
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #3d3d56;
            /* Linhas pares */
        }

        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: normal;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            border-radius: 4px;
            color: #fff;
            background-color: #5c5c88;
            /* Botão com tom galáctico */
            border-color: #4b4b76;
        }

        .btn:hover {
            background-color: #4b4b76;
            /* Hover do botão */
            border-color: #3d3d56;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
        }

        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }

        .action-buttons {
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div id="content">
    <div class="container">
        
        <h1>Lista de Tarefas</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Progresso</th>
                    <th>Anotação</th>
                    <th>Grupo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $user) : ?>
                    <tr>
                        <td><?php echo $user['idtarefa']; ?></td>
                        <td><?php echo $user['nome']; ?></td>
                        <td><?php echo $user['descricao']; ?></td>
                        <td><?php echo $user['progresso']; ?></td>
                        <td><?php echo $user['anotacao']; ?></td>
                        <td><?php echo $user['nome']; ?></td>
                        <td class="action-buttons">
                            <form method="post" style="display: inline-block;">
                                <a href="EditarTarefas.php?id=<?php echo $user['idtarefa']; ?>" class="btn btn-primary">Editar</a>
                            </form>
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        
    </div>
    </div>
    <button id="generate-pdf">Gerar PDF</button>
        <br><br>
        
        <a href="Login.php" class="voltar-link">Sair</a>
</body>

</html>