<?php
namespace Invent\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;

class InventLocalMod extends Command
{
    //comando esperado php artisan invent:local --remove
    protected $signature = 'invent:local {--remove : Remove a configuração local}';
    protected $description = 'Cria um diretorio local para o desenvolvimento do pacote laravel-components ou remove a configuração local';

    public function handle()
    {
        if ($this->option('remove')) {
            $this->info('Removendo configuração local...');
            exec('composer config --unset repositories.local');
            exec('composer update');
            $this->info('Configuração local removida com sucesso!');
        } else {
            $this->info('Ativando modo local...');
            //criar pasta packages/invent-IFTO se não existir
            if (!file_exists(base_path('packages/invent-IFTO'))) {
                mkdir(base_path('packages/invent-IFTO'), 0755, true);
            }
            //clonar o repositório do laravel-components na pasta packages/invent-IFTO
            if (!file_exists(base_path('packages/invent-IFTO/laravel-components'))) {
                exec('git clone https://github.com/invent-IFTO/laravel-components.git ' . base_path('packages/invent-IFTO/laravel-components'));
            }else{
                //executar o pull no projeto para atualizar o código
                exec('cd ' . base_path('packages/invent-IFTO/laravel-components') . ' && git pull');
            }
            // Configurar repositório local
            exec('composer config repositories.local path "./packages/invent-IFTO/laravel-components" --file=composer.json');
            
            // Adicionar opção symlink editando o composer.json diretamente
            $composerPath = base_path('composer.json');
            $composerContent = file_get_contents($composerPath);
            $composer = json_decode($composerContent, true);
            
            // Adicionar a opção symlink
            if (isset($composer['repositories']['local'])) {
                $composer['repositories']['local']['options'] = ['symlink' => true];
                file_put_contents($composerPath, json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
            }
            
            exec('composer update');
            $this->info('Modo local ativado com sucesso!');
        }       
        return 0;
    }
}
