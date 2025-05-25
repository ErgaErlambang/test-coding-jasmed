<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        Role::insert([
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Registrasi',
                'slug' => 'registrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Perawat',
                'slug' => 'perawat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dokter',
                'slug' => 'dokter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Apoteker',
                'slug' => 'apoteker',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
