<?php
if (isset($_POST['linha'])) {
    $linhaParaExcluir = (int)$_POST['linha'];
    $arquivo = 'clientes.txt';

    if (file_exists($arquivo)) {
        $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (isset($linhas[$linhaParaExcluir])) {
            unset($linhas[$linhaParaExcluir]);
            file_put_contents($arquivo, implode("\n", $linhas));
        }
    }
}

header('Location: index.php');
exit;
?>
