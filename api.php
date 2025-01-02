<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['plano'])) {
    $cpf = isset($_GET['cpf']) ? $_GET['cpf'] : '';
    $plano = $_GET['plano'];
    $celular = isset($_GET['celular']) ? $_GET['celular'] : '';
    $email = isset($_GET['email']) ? $_GET['email'] : '';

    // Se não houver CPF, gera um CPF aleatório
    if (empty($cpf)) {
        $cpf = str_pad(rand(0, 99999999999), 11, '0', STR_PAD_LEFT);
    }

    // Verifica se o CPF é válido (apenas números e 11 dígitos)
    if (!preg_match('/^\d{11}$/', $cpf)) {
        echo 'CPF inválido. Deve conter apenas 11 dígitos.';
        exit;
    }

    // Verifica se o celular e o e-mail estão presentes
    if (empty($celular) || empty($email)) {
        echo 'Celular ou e-mail não fornecido. Não foi possível criar o cliente.';
        exit;
    }

    // Verifica se o celular é válido (apenas números)
    if (!preg_match('/^\d+$/', $celular)) {
        echo 'Celular inválido. Deve conter apenas números.';
        exit;
    }

    // Verifica se o e-mail é válido
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'E-mail inválido.';
        exit;
    }

    // A senha será os 5 primeiros dígitos do CPF
    $senha_padrao = substr($cpf, 0, 5);
    $status = 1;

    // Definindo a data de validade com base no plano
    $data_atual = new DateTime();
    switch ($plano) {
        case '1': // Plano mensal
            $data_atual->modify('+30 days');
            break;
        case '2': // Plano trimestral
            $data_atual->modify('+90 days');
            break;
        case '3': // Plano semestral
            $data_atual->modify('+180 days');
            break;
        case '4': // Plano anual
            $data_atual->modify('+365 days');
            break;
        default:
            echo 'Plano inválido. Use 1 (mensal), 2 (trimestral), 3 (semestral) ou 4 (anual).';
            exit;
    }
    $data_validade = $data_atual->format('d/m/Y');

    // Nome do arquivo
    $arquivo = 'clientes.txt';

    // Criando a nova linha para adicionar ao arquivo
    $nova_linha = "$cpf,$senha_padrao,$status,$data_validade,$celular,$email";

    // Verificando se o arquivo já tem uma linha em branco no final
    $conteudo = file_get_contents($arquivo);
    if (substr($conteudo, -1) !== "\n") {
        // Se a última linha não terminar com uma nova linha, adiciona a nova linha
        if (file_put_contents($arquivo, "\n", FILE_APPEND | LOCK_EX) === false) {
            echo 'Erro ao adicionar a quebra de linha no arquivo.';
            exit;
        }
    }

    // Adicionando a nova linha ao arquivo clientes.txt
    if (file_put_contents($arquivo, $nova_linha . "\n", FILE_APPEND | LOCK_EX)) {
        echo 'Novo cliente adicionado com sucesso.';
    } else {
        echo 'Erro ao adicionar o cliente.';
    }
} else {
    echo 'Requisição inválida. Use o método GET com os parâmetros plano, cpf, celular e email.';
}
