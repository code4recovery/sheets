<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Console\Command;

class CleanupFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup files over 30 days old';

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
        $limit = now()->subDays(30)->getTimestamp();

        collect(Storage::disk('public')->files())->filter(function ($file) use ($limit) {
            return Str::endsWith($file, '.json') && Storage::disk('public')->lastModified($file) < $limit;
        })->each(function ($file) {
            Storage::disk('public')->delete($file);
        });
    }
}
