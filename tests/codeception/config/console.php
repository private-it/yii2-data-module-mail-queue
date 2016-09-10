<?php
return array_replace(
    require __DIR__ . '/main.php',
    [
        'bootstrap' => ['mailQueue'],
    ]
);