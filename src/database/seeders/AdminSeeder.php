<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class AdminSeeder extends Seeder
{
    public function run()
    {


        $admins = [

            [
                'id' => 1,
                'name' => 'Super Admin',
                'avatar' => 'assets/images/avatar/1.jpg',
                'email' => 'superadmin@rishad.com',
                'phone' => '+8801100000000',
                'password' => '12345678',
            ],



        ];

        foreach ($admins as $admin) {

            DB::table('admins')->insert([
                'id' => $admin['id'],
                'name' => $admin['name'],
                'avatar' => $admin['avatar'],
                'email' => $admin['email'],
                'phone' => $admin['phone'],
                'is_active' => 1,
                'password' => Hash::make($admin['password']),
            ]);
        }
    }
}
