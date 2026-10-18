<?php

// `php artisan db:backup` (read through config so it also works after config:cache).
return [
    'mysqldump' => env('MYSQLDUMP_PATH', 'mysqldump'),
    'keep' => (int) env('BACKUP_KEEP', 14),
];
