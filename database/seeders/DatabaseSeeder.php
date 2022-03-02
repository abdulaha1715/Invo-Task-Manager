<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Task;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name'      => 'Abdulaha Islam',
            'email'     => 'abdulahaislam210917@gmail.com',
            'company'   => 'Abnipes Network',
            'phone'     => '01715-246330',
            'country'   => 'Bangladesh',
            'password'  => bcrypt('01918786189'),
            'thumbnail' => 'https://picsum.photos/300'
        ]);

        // User::create([
        //     'name'      => 'John Doe',
        //     'email'     => 'demo@gmail.com',
        //     'company'   => 'Abnipes Network',
        //     'phone'     => '01000-000000',
        //     'country'   => 'Bangladesh',
        //     'password'  => bcrypt('123'),
        //     'thumbnail' => 'https://picsum.photos/300'
        // ]);

        Client::factory(10)->create();

        Task::factory(50)->create();

        // Invoice::factory(80)->create();
    }
}
