<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'surname' => 'Иванов',
            'name' => 'Иван',
            'email' => 'admin@example.com',
            'phone' => '+79001234567',
            'company_id' => 1,
            'info' => 'Профессиональный администратор с 8-летним стажем работы в сфере грузоперевозок. Ответственный за управление платформой, контроль заявок, поддержку пользователей и обеспечение корректной работы системы. Знание Laravel, MySQL, REST API.',
            'password' => Hash::make('admin123'),
            'position' => 'Администратор',
            'is_admin' => true,
        ]);

        User::create([
            'surname' => 'Петров',
            'name' => 'Пётр',
            'email' => 'user@example.com',
            'phone' => '+79007654321',
            'company_id' => 2,
            'info' => 'Работаю в сфере грузоперевозок более 5 лет. Опыт управления автопарком из 15 единиц транспорта. Специализируюсь на междугородних перевозках, доставке строительных материалов и крупногабаритных грузов. Готов к долгосрочному сотрудничеству.',
            'password' => Hash::make('user123'),
            'position' => 'Грузоперевозчик',
            'is_admin' => false,
        ]);
    }
}
