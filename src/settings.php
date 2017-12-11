<?php
$parts = parse_url(getenv("DATABASE_URL"));

return [
    'settings' => [
        'displayErrorDetails' => (bool)getenv('DISPLAY_ERRORS'), // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db' => [
            'host' => $parts['host'],
            'user' => $parts['user'],
            'pass' => $parts['pass'],
            'dbname' => substr($parts['path'], 1),
        ],
    ],
];
