<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Profile;
use DB;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('profiles')->truncate();
        Profile::insert([
            [
                'user_id' => 1,
                'fullname' => "Super Administrator",
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'country' => 'Indonesia',
                'postal_code' => '40111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'fullname' => "Registrasi",
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'country' => 'Indonesia',
                'postal_code' => '40111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'fullname' => "Perawat",
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'country' => 'Indonesia',
                'postal_code' => '40111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'fullname' => "Super Administrator",
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'country' => 'Indonesia',
                'postal_code' => '40111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'fullname' => "Apoteker",
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'city' => 'Bandung',
                'state' => 'Jawa Barat',
                'country' => 'Indonesia',
                'postal_code' => '40111',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
