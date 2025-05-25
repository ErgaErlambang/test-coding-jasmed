<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class CreateDatabase extends Command
{
    protected $signature = 'db:create';
    protected $description = 'Create DB and migrate tables';
    static $tableName = 'jasmed_erga_db_test_junior';

    public function handle()
    {
        $dbName = self::$tableName;
        $pEnv = base_path('.env');

        if (!file_exists($pEnv)) {
            $this->warn('.env not found');
            $cp = copy(base_path(".env.example"),base_path(".env"));
            if(!$cp) {
                $this->error(".env failed to copy");
                return;
            }
        }

        $fileEnv = file_get_contents($pEnv);
        $fileEnv = preg_replace('/^DB_DATABASE=.*$/m', "DB_DATABASE={$dbName}", $fileEnv);

        file_put_contents($pEnv, $fileEnv);
        Artisan::call('key:generate', [], $this->getOutput());

        Artisan::call('config:clear');
        Artisan::call('config:cache');

        Config::set('database.connections.mysql.database', null);
        DB::purge('mysql');
        try {
            // DB::statement("CREATE DATABASE $dbName")
            DB::statement("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

        } catch (\Exception $e) {
            $this->error("crete DB failed : " . $e->getMessage());
            return;
        }
        
        Config::set('database.connections.mysql.database', $dbName);
        DB::purge('mysql');
        DB::reconnect('mysql');

        $this->info("DB and Migration successfully created : $dbName");
        Artisan::call('migrate', [], $this->getOutput());
        Artisan::call('db:seed', [], $this->getOutput());
        return;
    }
}
