<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin account
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@rfn.com',
            'user_type' => 'admin',
            'password' => Hash::make('Admin@12345'),
            'password_changed' => true, // Admin doesn't need to change password on first login
            'user_account_id' => null,
        ]);

        echo "✅ Admin account created successfully!\n";
        echo "📧 Email: admin@rfn.com\n";
        echo "🔐 Password: Admin@12345\n";
        echo "⚠️  Please change this password after first login!\n";
    }
}

