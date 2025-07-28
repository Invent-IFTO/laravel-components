<?php

namespace Invent\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;

class RevertLastVersion extends Command
{
    protected $signature = 'app:version-revert';
    protected $description = 'Reverte a última versão criada, restaurando as mudanças para edição';

    public function handle()
    {
        $changelogPath = storage_path('app/changelogs/');
        $pendingPath = storage_path('app/pending-changes.json');

        // 1) Garantir que existam changelogs
        if (!is_dir($changelogPath)) {
            $this->error('Nenhuma versão criada até agora.');
            return 1;
        }

        // 2) Listar arquivos de changelog e pegar o último pela versão
        $arquivos = glob($changelogPath . 'v*.json');
        if (empty($arquivos)) {
            $this->error('Nenhuma versão encontrada em changelogs.');
            return 1;
        }

        usort($arquivos, function ($a, $b) {
            // Ordena do maior para o menor (última versão primeiro)
            return version_compare(basename($b, '.json'), basename($a, '.json'));
        });
        $ultimoArquivo = $arquivos[0];

        // 3) Ler conteúdo do changelog para restaurar mudanças
        $conteudo = json_decode(file_get_contents($ultimoArquivo), true);
        if (empty($conteudo['changes'])) {
            $this->error('O último changelog não possui alterações registradas.');
            return 1;
        }

        // 4) Carregar pendências já existentes para mesclar
        $pendentesExistentes = file_exists($pendingPath)
            ? json_decode(file_get_contents($pendingPath), true)
            : [];

        // Mesclar mudanças antigas com as revertidas
        $novasPendencias = array_merge($pendentesExistentes, $conteudo['changes']);

        // 5) Salvar lista atualizada em pending-changes.json
        file_put_contents(
            $pendingPath,
            json_encode($novasPendencias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // 6) Remover changelog do disco
        unlink($ultimoArquivo);

        // 7) Remover tag git local
        $tag = 'v' . $conteudo['version'];
        exec("git tag -d {$tag}");

        // Opcional: se quiser também excluir do remoto, descomente abaixo:
        // exec("git push origin :refs/tags/{$tag}");

        $this->info("Versão {$conteudo['version']} revertida com sucesso!");
        $this->info("Alterações restauradas para pending-changes.json");
        $this->info("Tag {$tag} removida do Git local.");

        return 0;
    }
}
