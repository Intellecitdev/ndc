<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Symfony\Component\Process\Process;

/*
 | Database backup: storage/app/backups/<db>-YYYYmmdd-His.sql.gz, keeping the newest
 | BACKUP_KEEP (default 14). Runs daily through the scheduler
 | (`php artisan schedule:run` every minute from cron / Windows Task Scheduler).
 */
Artisan::command('db:backup', function () {
    $db = config('database.connections.mysql');
    $dir = storage_path('app/backups');
    if (! is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    $file = $dir.'/'.$db['database'].'-'.now()->format('Ymd-His').'.sql';

    // Credentials go in a temporary option file, not on the command line (visible in the process list).
    $credentials = tempnam(storage_path('app'), 'dump');
    file_put_contents($credentials, "[client]\nuser=\"".addcslashes($db['username'], '"\\')."\"\npassword=\"".addcslashes((string) $db['password'], '"\\')."\"\n");
    @chmod($credentials, 0600);

    try {
        $process = new Process([
            config('backup.mysqldump'), '--defaults-extra-file='.$credentials,
            '--single-transaction', '--routines', '--no-tablespaces',
            '-h', $db['host'], '-P', (string) $db['port'],
            '--result-file='.$file, $db['database'],
        ]);
        $process->setTimeout(600)->run();
    } finally {
        @unlink($credentials);
    }
    if (! $process->isSuccessful()) {
        $this->error('Backup failed: '.$process->getErrorOutput());

        return 1;
    }

    file_put_contents($file.'.gz', gzencode(file_get_contents($file), 9));
    unlink($file);

    collect(glob($dir.'/*.sql.gz'))->sort()->reverse()->slice(config('backup.keep'))->each(fn ($old) => unlink($old));
    $this->info('Backup written: '.$file.'.gz');
})->purpose('Dump the MySQL database to storage/app/backups');

Schedule::command('db:backup')->dailyAt('02:00');
