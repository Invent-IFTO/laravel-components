<?php

namespace Invent\LaravelComponents\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class GerarManifestIcons extends Command
{
    protected $signature = 'app:generate-icons {image_path}';
    protected $description = 'Gera ícones do manifest a partir de uma imagem original';

    public function handle()
    {
        $caminhoImagem = $this->argument('image_path');

        if (!file_exists($caminhoImagem)) {
            $this->error("Imagem original não encontrada.");
            return 1;
        }

        $destino = public_path('icons');
        File::ensureDirectoryExists($destino);

        $resolucoes = [
            'apple-icon' => [57, 60, 72, 76, 114,120,144, 152, 180],
            'favicon' => [16, 32, 96],
            'android-icon' => [192],
            'ms-icon' => [144],
            'icon'=>[192]

        ];

        $manager = new ImageManager(new Driver());
        foreach ($resolucoes as $tipo => $tamanhos) {
            foreach($tamanhos as $tamanho){
                $image = $manager->read($caminhoImagem);
                $image->scale($tamanho,$tamanho);
                $nomeArquivo = "$tipo-{$tamanho}x{$tamanho}.png";
                $image->toPng()->save("{$destino}/{$nomeArquivo}");
                $this->info("Gerado: {$nomeArquivo}");
            }
        }

        $this->info("Ícones do manifest gerados com sucesso!");
        return 0;
    }
}
