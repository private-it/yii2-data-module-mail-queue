<?php
return array_replace_recursive(
    [
        'id' => 'test',
        'basePath' => realpath(__DIR__ . '/../../'),
        'runtimePath' => realpath(__DIR__ . '/../../_output'),
        'components' => [
            'db' => require __DIR__ . '/db.php',
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'useFileTransport' => true,
            ],
        ],
        'modules' => [
            'mailQueue' => [
                'class' => 'PrivateIT\modules\mailQueue\MailQueueModule',
            ],
        ]
    ],
    file_exists(__DIR__ . '/main-local.php') ? require __DIR__ . '/main-local.php' : []
);