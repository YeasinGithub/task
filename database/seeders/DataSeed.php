<?php

namespace Database\Seeders;


use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DataSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions



        // create roles and assign existing permissions


      User::create(['email' => 'admin@admin.com', 'name'=>'Admin', 'password' => Hash::make('password')]);

      Subject::create(['subject_name' => 'Bangla']);
        Subject::create(['subject_name' => 'English']);




    }
}
