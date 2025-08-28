<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Default Admin
        User::updateOrInsert(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin123'),
                'role_id' => 1,
                'email_verified_at' => now(),
                'created_at' => Carbon::now()->subDays(365),
                'updated_at' => now(),
            ]
        );

        // Default Member
        User::updateOrInsert(
            ['email' => 'member@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('member123'),
                'role_id' => 2,
                'email_verified_at' => now(),
                'created_at' => Carbon::now()->subDays(300),
                'updated_at' => now(),
            ]
        );

        // Additional Admin Users
        $admins = [
            [
                'name' => 'Admin Librarian',
                'email' => 'librarian@example.com',
                'password' => Hash::make('librarian123'),
                'created_at' => Carbon::now()->subDays(200)
            ],
            [
                'name' => 'Head Admin',
                'email' => 'head.admin@example.com',
                'password' => Hash::make('head123'),
                'created_at' => Carbon::now()->subDays(180)
            ]
        ];

        foreach ($admins as $admin) {
            User::updateOrInsert(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => $admin['password'],
                    'role_id' => 1,
                    'email_verified_at' => now(),
                    'created_at' => $admin['created_at'],
                    'updated_at' => now(),
                ]
            );
        }

        // Sample Member Users with Indonesian Names
        $members = [
            [
                'name' => 'Sari Dewi',
                'email' => 'sari.dewi@student.ac.id',
                'created_at' => Carbon::now()->subDays(150)
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@student.ac.id',
                'created_at' => Carbon::now()->subDays(145)
            ],
            [
                'name' => 'Rina Kusuma',
                'email' => 'rina.kusuma@student.ac.id',
                'created_at' => Carbon::now()->subDays(140)
            ],
            [
                'name' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@student.ac.id',
                'created_at' => Carbon::now()->subDays(135)
            ],
            [
                'name' => 'Maya Sari',
                'email' => 'maya.sari@student.ac.id',
                'created_at' => Carbon::now()->subDays(130)
            ],
            [
                'name' => 'Dian Pratama',
                'email' => 'dian.pratama@student.ac.id',
                'created_at' => Carbon::now()->subDays(125)
            ],
            [
                'name' => 'Linda Wati',
                'email' => 'linda.wati@student.ac.id',
                'created_at' => Carbon::now()->subDays(120)
            ],
            [
                'name' => 'Rizki Hakim',
                'email' => 'rizki.hakim@student.ac.id',
                'created_at' => Carbon::now()->subDays(115)
            ],
            [
                'name' => 'Nita Anggraini',
                'email' => 'nita.anggraini@student.ac.id',
                'created_at' => Carbon::now()->subDays(110)
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@student.ac.id',
                'created_at' => Carbon::now()->subDays(105)
            ],
            [
                'name' => 'Fitri Handayani',
                'email' => 'fitri.handayani@student.ac.id',
                'created_at' => Carbon::now()->subDays(100)
            ],
            [
                'name' => 'Agus Setiawan',
                'email' => 'agus.setiawan@student.ac.id',
                'created_at' => Carbon::now()->subDays(95)
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@student.ac.id',
                'created_at' => Carbon::now()->subDays(90)
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@student.ac.id',
                'created_at' => Carbon::now()->subDays(85)
            ],
            [
                'name' => 'Sinta Maharani',
                'email' => 'sinta.maharani@student.ac.id',
                'created_at' => Carbon::now()->subDays(80)
            ],
            [
                'name' => 'Bayu Nugroho',
                'email' => 'bayu.nugroho@student.ac.id',
                'created_at' => Carbon::now()->subDays(75)
            ],
            [
                'name' => 'Tari Indah',
                'email' => 'tari.indah@student.ac.id',
                'created_at' => Carbon::now()->subDays(70)
            ],
            [
                'name' => 'Yudi Susanto',
                'email' => 'yudi.susanto@student.ac.id',
                'created_at' => Carbon::now()->subDays(65)
            ],
            [
                'name' => 'Ayu Permata',
                'email' => 'ayu.permata@student.ac.id',
                'created_at' => Carbon::now()->subDays(60)
            ],
            [
                'name' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@student.ac.id',
                'created_at' => Carbon::now()->subDays(55)
            ],
            [
                'name' => 'Indira Sari',
                'email' => 'indira.sari@student.ac.id',
                'created_at' => Carbon::now()->subDays(50)
            ],
            [
                'name' => 'Fajar Maulana',
                'email' => 'fajar.maulana@student.ac.id',
                'created_at' => Carbon::now()->subDays(45)
            ],
            [
                'name' => 'Citra Dewi',
                'email' => 'citra.dewi@student.ac.id',
                'created_at' => Carbon::now()->subDays(40)
            ],
            [
                'name' => 'Andi Saputra',
                'email' => 'andi.saputra@student.ac.id',
                'created_at' => Carbon::now()->subDays(35)
            ],
            [
                'name' => 'Ratna Sari',
                'email' => 'ratna.sari@student.ac.id',
                'created_at' => Carbon::now()->subDays(30)
            ],
            [
                'name' => 'Yoga Pratama',
                'email' => 'yoga.pratama@student.ac.id',
                'created_at' => Carbon::now()->subDays(25)
            ],
            [
                'name' => 'Putri Rahayu',
                'email' => 'putri.rahayu@student.ac.id',
                'created_at' => Carbon::now()->subDays(20)
            ],
            [
                'name' => 'Arief Hidayat',
                'email' => 'arief.hidayat@student.ac.id',
                'created_at' => Carbon::now()->subDays(15)
            ],
            [
                'name' => 'Kartika Sari',
                'email' => 'kartika.sari@student.ac.id',
                'created_at' => Carbon::now()->subDays(10)
            ],
            [
                'name' => 'Deni Kurniawan',
                'email' => 'deni.kurniawan@student.ac.id',
                'created_at' => Carbon::now()->subDays(5)
            ],
        ];

        foreach ($members as $member) {
            User::updateOrInsert(
                ['email' => $member['email']],
                [
                    'name' => $member['name'],
                    'password' => Hash::make('member123'),
                    'role_id' => 2,
                    'email_verified_at' => now(),
                    'created_at' => $member['created_at'],
                    'updated_at' => now(),
                ]
            );
        }

        // Some users without email verification (recent registrations)
        $unverifiedUsers = [
            [
                'name' => 'Novi Astuti',
                'email' => 'novi.astuti@student.ac.id',
                'created_at' => Carbon::now()->subDays(3)
            ],
            [
                'name' => 'Rian Maulana',
                'email' => 'rian.maulana@student.ac.id',
                'created_at' => Carbon::now()->subDays(2)
            ],
            [
                'name' => 'Siska Wulandari',
                'email' => 'siska.wulandari@student.ac.id',
                'created_at' => Carbon::now()->subDays(1)
            ]
        ];

        foreach ($unverifiedUsers as $user) {
            User::updateOrInsert(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => Hash::make('member123'),
                    'role_id' => 2,
                    'email_verified_at' => null, // Unverified
                    'created_at' => $user['created_at'],
                    'updated_at' => now(),
                ]
            );
        }

        echo "✅ User seeder completed successfully!\n";
        echo "📊 Created:\n";
        echo "   - 3 Admin users (including super admin)\n";
        echo "   - 33 Member users (30 verified + 3 unverified)\n";
        echo "   - Total: 36 users\n\n";
        echo "🔑 Default Login Credentials:\n";
        echo "   Admin: admin@example.com / admin123\n";
        echo "   Member: member@example.com / member123\n";
        echo "   All other members: password is 'member123'\n";
    }
}