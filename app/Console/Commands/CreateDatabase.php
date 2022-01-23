<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates empty database';

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
        $path = storage_path('app/database.sqlite');
        touch($path);

        $this->info('Created empty DB at ' . $path);
        return 0;
    }
}
