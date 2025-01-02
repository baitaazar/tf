<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $nova_data = $_POST['nova_data'];

    // Converte a nova data do formato aaaa-mm-dd para dd/mm/aaaa
    $nova_data_formatada = date("d/m/Y", strtotime($nova_data));

    // Lógica para atualizar a data do cliente no arquivo clientes.txt
    $arquivo = 'clientes.txt';

    if (!file_exists($arquivo)) {
        die('Arquivo clientes.txt não encontrado.');
    }
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($linhas as $index => $linha) {
        $dados = explode(',', $linha);
        if ($dados[0] === $usuario) {
            $dados[3] = $nova_data_formatada; // Atualiza a data
            $linhas[$index] = implode(',', $dados);
        }
    }

    // Reescreve o arquivo com as mudanças
    file_put_contents($arquivo, implode("\n", $linhas));

    // Redireciona ou exibe uma mensagem de sucesso
    header("Location: index.php");
    exit();
}
?>
