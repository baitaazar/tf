<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['novo_usuario'];
    $senha = $_POST['nova_senha'];
    $status = $_POST['status'];
    $data_validade = $_POST['data_validade'];

    // Converte a data do formato aaaa-mm-dd para dd/mm/aaaa
    $data_validade_formatada = date("d/m/Y", strtotime($data_validade));

    // Abre o arquivo para adicionar o novo cliente
    $arquivo = 'clientes.txt';
    $linha = "$usuario,$senha,$status,$data_validade_formatada\n";

    // Verifica se o arquivo já tem uma linha em branco no final
    $conteudo = file_get_contents($arquivo);
    if (substr($conteudo, -1) !== "\n") {
        // Se a última linha não terminar com uma nova linha, adiciona uma quebra de linha
        if (file_put_contents($arquivo, "\n", FILE_APPEND | LOCK_EX) === false) {
            echo 'Erro ao adicionar a quebra de linha no arquivo.';
            exit;
        }
    }

    // Adiciona a nova linha ao arquivo clientes.txt
    if (file_put_contents($arquivo, $linha, FILE_APPEND | LOCK_EX)) {
        // Redireciona ou exibe uma mensagem de sucesso
        header("Location: index.php");
        exit();
    } else {
        echo 'Erro ao adicionar o cliente.';
    }
}
?>
