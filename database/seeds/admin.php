<?php

use Illuminate\Database\Seeder;

class admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new \App\User;
        $admin->name = "Farhan Adji";
        $admin->email = "admin@test.com";
        $admin->role = "ADMIN";
        $admin->password = \Hash::make("adminadmin");

        $admin->save();
    }
}
