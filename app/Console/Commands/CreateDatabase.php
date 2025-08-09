<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create the database for this project';

    public function handle()
    {
        $database = Config::get('database.connections.mysql.database');
        $charset = Config::get('database.connections.mysql.charset', 'utf8mb4');
        $collation = Config::get('database.connections.mysql.collation', 'utf8mb4_unicode_ci');

        Config::set('database.connections.mysql.database', null);

        DB::statement("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET $charset COLLATE $collation");

        Config::set('database.connections.mysql.database', $database);

        $this->info("Database `$database` created successfully.");
    }
}
