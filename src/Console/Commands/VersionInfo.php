<?php

namespace Invent\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;

class VersionInfo extends Command
{
    protected $signature = 'app:version-info';
    protected $description = 'Mostra informações sobre a versão atual do sistema';

    public function handle()
    {
        $changelogPath = storage_path('app/changelogs/');
        if (!is_dir($changelogPath)) {
            $this->error('Nenhuma versão foi criada ainda.');
            return 1;
        }

        $arquivos = glob($changelogPath . 'v*.json');
        if (empty($arquivos)) {
            $this->error('Nenhuma versão encontrada em changelogs.');
            return 1;
        }

        usort($arquivos, function ($a, $b) {
            return version_compare(basename($b, '.json'), basename($a, '.json'));
        });

        $ultimoArquivo = $arquivos[0];
        $conteudo = json_decode(file_get_contents($ultimoArquivo), true);

        if (empty($conteudo['version']) || empty($conteudo['date'])) {
            $this->error('Arquivo da última versão está incompleto.');
            return 1;
        }

        $this->info("Versão atual: v{$conteudo['version']}");
        $this->line("Data do release: {$conteudo['date']}");

        if (!empty($conteudo['changes'])) {
            $this->line("Alterações:");
            foreach ($conteudo['changes'] as $i => $change) {
                $this->line("  " . ($i + 1) . ". {$change}");
            }
        } else {
            $this->line("(Sem alterações registradas)");
        }

        return 0;
    }
}
