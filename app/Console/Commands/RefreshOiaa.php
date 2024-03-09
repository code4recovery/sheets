<?php

namespace App\Console\Commands;

use App\Http\Controllers\OiaaController;
use Illuminate\Console\Command;

class RefreshOiaa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'oiaa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the OIAA feed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        OiaaController::oiaa();
        $this->info('done!');
        return 0;
    }
}
