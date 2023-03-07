<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\State;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(30)->create();
        // $users->each(function($user) {
        //     $user->state()->createdAt(State::factory()->make()->toArray());
        // });
    }
}
