<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
//command to check and expire subscriptions
Artisan::command('AqilGanteng', function () {
    $count = \App\Models\Pabrik::where('Ispaid', true)
        ->whereNotNull('expire')
        ->where('expire', '<=', now())
        ->update([
            'Ispaid' => false,
            'expire' => null,
        ]);

    $this->info("Berhasil mencabut premium: {$count} pabrik(s).");
})->purpose('Cabut akses premium yang sudah lewat waktu (30 hari).');
