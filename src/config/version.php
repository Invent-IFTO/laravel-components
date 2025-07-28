<?php


$changelogPath = storage_path('app/changelogs/');
if (!is_dir($changelogPath)) {
    return '0.0.0';
}

$arquivos = glob($changelogPath . 'v*.json');
if (empty($arquivos)) {
    return '0.0.0';
}

usort($arquivos, function ($a, $b) {
    // Ordena do maior para o menor
    return version_compare(basename($b, '.json'), basename($a, '.json'));
});

$ultimoArquivo = $arquivos[0];
$conteudo = json_decode(file_get_contents($ultimoArquivo), true);

return !empty($conteudo['version']) ? $conteudo['version'] : '0.0.0';

