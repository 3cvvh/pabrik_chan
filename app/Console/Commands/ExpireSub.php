<?php

namespace App\Console\Commands;

use App\Models\pabrik;
use Illuminate\Console\Command;

class ExpireSub extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'AqilGanteng';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $expired = pabrik::where('Ispaid', true)
        ->where('expire', '<=', now())
        ->update(['Ispaid' => false, 'sisa_waktu' => null]);
        $this->info("Expired subscriptions updated: " . $expired);
    }
}
