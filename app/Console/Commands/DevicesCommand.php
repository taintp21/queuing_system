<?php

namespace App\Console\Commands;

use App\Models\Devices;
use Illuminate\Console\Command;

class DevicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'devices:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ngưng hoạt động lúc 18h mỗi ngày';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Devices::query()->update(['status' => 0]);
    }
}
