<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $project = new Project();
        $project->name = 'Project 1';
        $project->save();

        $project = new Project();
        $project->name = 'Project 2';
        $project->save();

        $project = new Project();
        $project->name = 'Project 3';
        $project->save();
    }
}
