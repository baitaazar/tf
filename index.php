<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #6a11cb, #2575fc);
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        h2 {
            margin-top: 20px;
        }
        form {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 30px;
            width: 300px;
        }
        label, input {
            display: block;
            width: 100%;
            text-align: left;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="submit"], button, input[type="date"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-top: 5px;
        }
        input[type="submit"], button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover, button:hover {
            background-color: #45a049;
        }
        .form-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .scrollable {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 10px;
            max-height: 200px;
            overflow-y: auto;
            margin-top: 30px;
            text-align: left;
        }
        table {
            width: 100%;
            color: #fff;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #555;
        }
    </style>
</head>
<body>
    <h2>Gerenciamento de Clientes</h2>
    <div class="form-container">
        <form action="alterar_data.php" method="post">
            <h3>Alterar Data do Cliente</h3>
            <label for="usuario">Usuário:</label>
            <input type="text" name="usuario" id="usuario" required>
            <label for="nova_data">Nova Data:</label>
            <input type="date" name="nova_data" id="nova_data" required>
            <input type="submit" value="Alterar Data">
        </form>

        <form action="adicionar_cliente.php" method="post">
            <h3>Adicionar Novo Cliente</h3>
            <label for="novo_usuario">Usuário:</label>
            <input type="text" name="novo_usuario" id="novo_usuario" required>
            <label for="nova_senha">Senha:</label>
            <input type="text" name="nova_senha" id="nova_senha" required>
            <label for="status">Status (0 ou 1):</label>
            <input type="text" name="status" id="status" required>
            <label for="data_validade">Data de Validade:</label>
            <input type="date" name="data_validade" id="data_validade" required>
            <input type="submit" value="Adicionar Cliente">
        </form>
    </div>

    <div class="scrollable">
        <h3>Clientes Cadastrados</h3>
        <table>
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Senha</th>
                    <th>Status</th>
                    <th>Data de Validade</th>
                    <th>Celular</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $arquivo = 'clientes.txt';
                if (file_exists($arquivo)) {
                    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    foreach ($linhas as $index => $linha) {
                        $dados = explode(',', $linha);
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($dados[0]) . '</td>';
                        echo '<td>' . htmlspecialchars($dados[1]) . '</td>';
                        echo '<td>' . htmlspecialchars($dados[2]) . '</td>';
                        echo '<td>' . htmlspecialchars($dados[3]) . '</td>';
                        // Verifica se existem campos de celular e e-mail
                        echo '<td>' . (isset($dados[4]) ? htmlspecialchars($dados[4]) : 'N/A') . '</td>';
                        echo '<td>' . (isset($dados[5]) ? htmlspecialchars($dados[5]) : 'N/A') . '</td>';
                        echo '<td>
                            <form action="excluir_cliente.php" method="post" style="display:inline;">
                                <input type="hidden" name="linha" value="' . $index . '">
                                <button type="submit">Excluir</button>
                            </form>
                        </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7">Nenhum cliente encontrado.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
