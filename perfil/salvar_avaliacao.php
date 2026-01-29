<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$avaliacao = filter_input(INPUT_POST, 'avaliacao', FILTER_VALIDATE_INT);
$comentario = filter_input(INPUT_POST, 'comentario', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$avaliacao || $avaliacao < 1 || $avaliacao > 5 || empty($comentario)) {
    header('Location: perfil.php?avaliacao=erro');
    exit;
}

$novaAvaliacao = [
    'avaliacao' => $avaliacao,
    'comentario' => $comentario,
    'data' => date('d/m/Y H:i')
];

$arquivo = 'avaliacoes.json';

$avaliacoes = file_exists($arquivo)
    ? json_decode(file_get_contents($arquivo), true)
    : [];

if (!is_array($avaliacoes)) {
    $avaliacoes = [];
}

$avaliacoes[] = $novaAvaliacao;

file_put_contents(
    $arquivo,
    json_encode($avaliacoes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

header('Location: perfil.php?avaliacao=sucesso');
exit;
