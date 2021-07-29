<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class CreateDefaultDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:default-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create a database if not exists';

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
        $databaseConnections = Config::get('database.connections');
        $databaseName = $databaseConnections['mysql']['database'];
        $query = "CREATE DATABASE IF NOT EXISTS $databaseName CHARACTER SET utf8 COLLATE utf8_bin";
        DB::statement($query);
    }
}
