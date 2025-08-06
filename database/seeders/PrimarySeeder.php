<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrimarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
	    $users = [
			[
				'name' => 'Develop',
				'email' => 'dev@app.com',
				'password' => bcrypt('password'),

			],
			[
				'name' => 'Admin',
				'email' => 'admin@app.com',
				'password' => bcrypt('password'),

			],
			[
				'name' => 'Client',
				'email' => 'client@app.com',
				'password' => bcrypt('password'),

			],
		];

		foreach ($users as $user) {
			User::updateOrCreate(
				['email' => $user['email']], 
				$user                         
			);
		}       
    }
}
