<?php

namespace Invent\LaravelComponents\Http\Controllers\Api;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Invent\LaravelComponents\Jobs\DeployWebhook;

class WebhookController extends BaseController
{

    use AuthorizesRequests, ValidatesRequests;

    public function index(Request $request)
    {
        if (env('WEBHOOK_SECRET') === null) {
            return $this->handle('WEBHOOK_SECRET não configurado.', 500);
        }

        $repository = env('WEBHOOK_REPOSITORY');
        if (is_null($repository)) {
            return $this->handle('WEBHOOK_REPOSITORY não configurado.', 500);
        }

        $headers = getallheaders();
        $signature = $headers['X-Hub-Signature-256'] ?? '';
        $payload = file_get_contents('php://input');
        $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, env('WEBHOOK_SECRET'));

        if (!hash_equals($expectedSignature, $signature)) {
            return $this->handle('Assinatura inválida.', 403);
        }

        // Despacha o job para a fila
        DeployWebhook::dispatch($payload);

        return $this->handle('Deploy enviado para fila.');
    }

    private function handle($msg, $code = 200)
    {
        if ($code !== 200) {
            http_response_code($code);
        }
        header('Content-Type: application/json');
        return json_encode(['status' => "$msg"]);
    }
}
