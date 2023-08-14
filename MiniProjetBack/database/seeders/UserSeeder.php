<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name'=>'Ndiaye Khadijatou',
                'numero'=>'777967105',
              
            ],
            [
                'name'=>'Ndiaye Aida',
                'numero'=>'780876543',
               
            ]
        ];
        User::insert($user);
    }
}
