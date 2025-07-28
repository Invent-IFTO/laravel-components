<?php

namespace Invent\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;

class VersionSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:version-create {tipo : Tipo de versionamento (major, minor, patch)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza a versão do sistema no .env e cria uma tag no Git';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tipo = $this->argument('tipo');
        $changelogPath = storage_path('app/changelogs/');
        $pendingPath = storage_path('app/pending-changes.json');

        // 1. Verificar mudanças pendentes
        if (!file_exists($pendingPath) || empty($pending = json_decode(file_get_contents($pendingPath), true))) {
            $this->error('Nenhuma mudança pendente encontrada. Adicione mudanças com app:add-change.');
            return 1;
        }

        // 2. Garantir pasta changelogs existe
        if (!is_dir($changelogPath))
            mkdir($changelogPath, 0755, true);

        // 3. Listar arquivos existentes para descobrir última versão
        $arquivos = glob($changelogPath . 'v*.json');
        $ultimaVersao = '0.0.0';

        if (!empty($arquivos)) {
            usort($arquivos, function ($a, $b) {
                return version_compare(basename($a, '.json'), basename($b, '.json'));
            });
            $ultimoArquivo = end($arquivos);
            $ultimaVersao = ltrim(basename($ultimoArquivo, '.json'), 'v');
        }

        if (!preg_match('/(\d+)\.(\d+)\.(\d+)/', $ultimaVersao, $matches)) {
            $this->error("Última versão inválida: $ultimaVersao");
            return 1;
        }

        [, $major, $minor, $patch] = $matches;

        // 4. Incrementar versão
        switch ($tipo) {
            case 'major':
                $major++;
                $minor = 0;
                $patch = 0;
                break;
            case 'minor':
                $minor++;
                $patch = 0;
                break;
            case 'patch':
                $patch++;
                break;
            default:
                $this->error('Tipo inválido. Use: major, minor ou patch.');
                return 1;
        }
        $novaVersao = "$major.$minor.$patch";

        // 5. Gerar changelog em arquivo separado
        $novaEntrada = [
            'version' => $novaVersao,
            'date' => now()->toDateString(),
            'changes' => $pending,
        ];

        file_put_contents(
            $changelogPath . "v$novaVersao.json",
            json_encode($novaEntrada, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        // 6. Limpar mudanças pendentes
        unlink($pendingPath);

        $this->info("Versão v$novaVersao criada com " . count($pending) . " mudanças.");
        exec("git add . ");
        exec("git commit -m 'Adicionado documentação da versão $novaVersao ao projeto.'");
        exec("git tag v$novaVersao");
        $this->info("Tag git v$novaVersao criada!");

        return 0;
    }

}
