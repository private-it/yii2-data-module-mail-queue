<?php

$migrations = [
    '@app/src/migrations' => 'migration_mail_queue',
];

$migrateController = new \yii\console\controllers\MigrateController('migrate', Yii::$app);

foreach ($migrations as $path => $table) {
    $migrateController->migrationPath = $path;
    $migrateController->migrationTable = $table;
    $migrateController->runAction('up', ['interactive' => 0]);
}
