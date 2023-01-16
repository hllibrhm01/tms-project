<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
        public function run()
        {

                $adminUser = User::create([
                        "name" => "admin",
                        "email" => "admin@admin.com",
                        "password" => Hash::make("123")
                ]);

                $driver = User::create([
                        "name" => "driver1",
                        "email" => "driver1@yandex.com",
                        "password" => Hash::make("123")
                ]);

                $driver2 = User::create([
                        "name" => "driver2",
                        "email" => "driver2@yandex.com",
                        "password" => Hash::make("123")
                ]);

                $driver3 = User::create([
                        "name" => "driver3",
                        "email" => "driver3@yandex.com",
                        "password" => Hash::make("123")
                ]);

                $driver4 = User::create([
                        "name" => "driver4",
                        "email" => "driver4@yandex.com",
                        "password" => Hash::make("123")
                ]);

                $driver5 = User::create([
                        "name" => "driver5",
                        "email" => "driver5@yandex.com",
                        "password" => Hash::make("123")
                ]);

                $adminUser->syncRoles('Admin');
                $driver->syncRoles('driver');
                $driver2->syncRoles('driver');
                $driver3->syncRoles('driver');
                $driver4->syncRoles('driver');
                $driver5->syncRoles('driver');
        }
};
