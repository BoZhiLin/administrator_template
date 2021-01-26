<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\AdminUser;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_user = new AdminUser();
        $admin_user->name = 'administrator';
        $admin_user->username = 'admin';
        $admin_user->password = Hash::make('admin123456');
        $admin_user->save();
    }
}
