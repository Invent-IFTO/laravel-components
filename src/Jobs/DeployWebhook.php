<?php

namespace Invent\LaravelComponents\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeployWebhook implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    public function handle(): void
    {
        $data = json_decode($this->payload, true);
        $repository = env('WEBHOOK_REPOSITORY');

        $githubRepo = $data['repository']['name'] ?? null;

        if (!$githubRepo || $repository !== $githubRepo) {
            \Log::warning("Repositório '{$githubRepo}' não reconhecido.");
            return;
        }

        $path = base_path();
        $php = env('PHP_PATH', '/usr/local/bin/php');
        $composer_path = env('COMPOSER_PATH', '/usr/local/bin/composer');
        $composer_home = env('COMPOSER_HOME', '~/tmp');
        $composer = "$php $composer_path";
        $timestamp = now()->format('Y-m-d_H-i-s');
        $log_path = "{$path}/storage/logs/deploy_{$timestamp}.log";

        $remove = (bool) env('COMPOSER_REMOVE_LOCAL', true);
        $removelocal = "";
        if($remove){
            $removelocal = "&& {$composer} dev:remove-local";    
        }

        $composerCommand = "cd {$path} && export HOME={$composer_home} && export COMPOSER_HOME={$composer_home} && (git restore . && git pull $removelocal && {$composer} update && {$php} artisan migrate --force && {$php} artisan php artisan optimize:clear) >> $log_path 2>&1 &";

        file_put_contents($log_path, "===== Deploy {$repository} - {$timestamp} =====\n\n exec {$composerCommand} \n\n");
        exec($composerCommand);
    }
}
