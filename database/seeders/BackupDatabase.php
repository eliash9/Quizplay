<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BackupDatabase extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Path to your database backup file
        $backupFilePath = 'quizplay.sql';

        // Read the SQL file and execute it
        $sql = file_get_contents($backupFilePath);
        DB::unprepared($sql);
    }
}
