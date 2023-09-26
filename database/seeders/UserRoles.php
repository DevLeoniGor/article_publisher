<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class UserRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::query()->create([
            'title' => 'Admin',
            'slug' => 'admin'
        ]);

        Role::query()->create([
            'title' => 'Author',
            'slug' => 'author'
        ]);
    }
}
