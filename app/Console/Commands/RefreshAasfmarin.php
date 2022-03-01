<?php

namespace App\Console\Commands;

use App\Http\Controllers\AirtableController;
use Illuminate\Console\Command;

class RefreshAasfmarin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aasfmarin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the AASF/Marin feed';

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

        AirtableController::aasfmarin();
        $this->info('done!');
        return 0;
    }
}
