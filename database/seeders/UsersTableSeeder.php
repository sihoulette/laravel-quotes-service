<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UsersTableSeeder
 *
 * @package Database\Seeders
 */
final class UsersTableSeeder extends Seeder
{
    /**
     * @var string $table
     */
    private string $table = 'users';

    /**
     * @var array $users
     */
    private array $users = [
        [
            'name' => 'dev',
            'email' => 'aleksandr.bytsyk@gmail.com',
            'password' => 'password',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->users as $user) {
            $user['email_verified_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $user['created_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $user['updated_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $user['password'] = Hash::make($user['password']);

            DB::table($this->table)->insert($user);
        }
    }
}
