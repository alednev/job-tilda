<?php

return [
    'environment'       => 'development', // might be development|production
    'system'            => [
        'timeZone'   => 'Europe/Moscow',
        'timeFormat' => 'F j, Y, g:i a e O',
    ],
    'uploadPath'        => './certs',
    'uploadMaxFilesize' => 4096, // 4 KiB
    'certFile'          => [
        'extension' => [
            '.pem',
            '.crt',
            '.cer',
        ],
        'mimeType'  => [
            'application/x-x509-user-cert',
            'application/x-pem-file',
        ],
    ],
    'privateFile'       => [
        'extension' => [
            '.key',
        ],
    ],
    'nginx'             => [
        'configDirectory' => './etc/nginx/sites-available',
        'templateConfig'  => 'default',
        'sslDirectory'    => './etc/ssl',
        'checkCommand'    => 'nginx -t',
        'restartCommand'  => 'systemctl reload nginx',
    ],
];
