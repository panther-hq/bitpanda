<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dirPath = \sprintf('%s/seeds',database_path());
        foreach (\scandir($dirPath) as $file){
            $filePath = \sprintf('%s/%s', $dirPath, $file);
            if (is_file($filePath)){
                $sql = \file_get_contents($filePath);

                DB::unprepared($sql);
            }
        }
    }
}
