<?php return
    [
        //trabalhando com a versão do sistema
        'developer' =>
            [
                'name' => env('APP_DEVELOPER', 'INVENT - FITO'),
                'site' => env('APP_DEVELOPER_LINK', 'https://if.app.br'),
                'year' => env('APP_DEVELOPMENT_YEAR', date('Y'))

            ],

        'version' => require __DIR__ . '/version.php',

        //suporte ao modal de confirmação

        'suporte_confirme_modal' => true,

        'suporte_dynamic_modal' => true,

        'suporte_alert_flush_message' => true,
    ];