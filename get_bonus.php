<?php
// Verifica se a URL foi passada via GET
if (isset($_GET['url'])) {
    $googleDocsUrl = $_GET['url'];

    // Converte a URL do Google Docs para uma URL de exportação de HTML
    $exportUrl = str_replace("/edit", "/export?format=html", $googleDocsUrl);

    // Utiliza file_get_contents para obter o conteúdo do Google Docs
    $data = file_get_contents($exportUrl);

    // Verifica se a requisição foi bem-sucedida
    if ($data === FALSE) {
        echo json_encode(["error" => "Não foi possível acessar o Google Docs."]);
        exit();
    }

    // Escapa o conteúdo HTML do Google Docs antes de enviá-lo
    $escapedData = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    // Converte o conteúdo do Google Docs para JSON e envia para o front-end
    header('Content-Type: application/json');
    echo json_encode(["content" => $escapedData]);
} else {
    echo json_encode(["error" => "Nenhuma URL fornecida."]);
}
?>
