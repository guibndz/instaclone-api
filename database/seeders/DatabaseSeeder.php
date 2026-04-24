<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(['email' => 'gui@email.com'], [
            'name' => 'Gui Bondezan',
            'username' => 'guibondezan',
            'password' => Hash::make('123456'),
            'bio' => 'Desenvolvedor back-end focado em Laravel.'
        ]);

        $joao = User::firstOrCreate(['email' => 'joao@email.com'], [
            'name' => 'João',
            'username' => 'joao123',
            'password' => Hash::make('123456'),
            'bio' => 'Apenas testando a rede.'
        ]);

        $admin->following()->syncWithoutDetaching([$joao->id]);

    }
}