<?php
namespace Invent\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;

class AddChange extends Command
{
    protected $signature = 'app:add-change {descricao : Descrição da mudança}';
    protected $description = 'Adiciona uma mudança pendente para a próxima versão';

    public function handle()
    {
        $changeFile = storage_path('app/pending-changes.json');
        $changes = file_exists($changeFile) ? json_decode(file_get_contents($changeFile), true) : [];

        $changes[] = $this->argument('descricao');

        file_put_contents($changeFile, json_encode($changes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('Mudança adicionada com sucesso!');
        return 0;
    }
}
