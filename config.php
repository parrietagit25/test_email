<?php
// Configuración del sistema de correos
return [
    'sendgrid' => [
        'api_key' => $_ENV['SENDGRID_API_KEY'] ?? 'SG.your-api-key-here',
        'from_email' => $_ENV['FROM_EMAIL'] ?? 'noreply@tuempresa.com',
        'from_name' => $_ENV['FROM_NAME'] ?? 'Sistema de Correos'
    ]
];
