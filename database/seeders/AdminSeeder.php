<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Ensure the 'admin' role exists
        $adminRole = Role::firstOrCreate(['name' => 'admin']);

        // Create Admin
        $admin = User::create([
            'first_name' => 'Super',
            'last_name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password@123'),
            'phone_number' => '0123456789',
            'salary' => 70000,
            'image' => null,
            'user_type' => 'admin'
        ]);

        // Assign the 'admin' role to the user
        $admin->assignRole($adminRole);
    }
}
