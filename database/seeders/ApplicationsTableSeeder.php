<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Application::create([
            'loading_country' => 'Россия',
            'loading_index' => '105005',
            'loading_city' => 'Москва',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-15'),
            'weight_tons' => 12.5,
            'volume_m3' => 28.75,
            'can_co_load' => true,
            'additional_info' => 'Погрузка с подъемником, требуется паспорт транспортного средства.',
            'unloading_country' => 'Беларусь',
            'unloading_index' => '220035',
            'unloading_city' => 'Минск',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-17'),
            'price' => 45000.00,
            'nds' => true,
            'prepayment' => false,
            'loading_type' => 'Платформа',
            'body_type' => 'Открытый кузов',
            'company_id' => 3,
            'status' => 'В пути',
        ]);

        Application::create([
            'loading_country' => 'Украина',
            'loading_index' => '61001',
            'loading_city' => 'Харьков',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-18'),
            'weight_tons' => 9.2,
            'volume_m3' => 18.5,
            'can_co_load' => false,
            'additional_info' => 'Погрузка производится силами клиента.',
            'unloading_country' => 'Польша',
            'unloading_index' => '00-950',
            'unloading_city' => 'Вроцлав',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-20'),
            'price' => 32000.00,
            'nds' => false,
            'prepayment' => true,
            'loading_type' => 'Фура',
            'body_type' => 'Закрытый кузов',
            'company_id' => 2,
            'status' => 'Доставлено',
        ]);

        Application::create([
            'loading_country' => 'Казахстан',
            'loading_index' => '480000',
            'loading_city' => 'Алматы',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-22'),
            'weight_tons' => 15.0,
            'volume_m3' => 32.0,
            'can_co_load' => true,
            'additional_info' => 'Требуется разрешение на перевозку опасных грузов.',
            'unloading_country' => 'Турция',
            'unloading_index' => '34000',
            'unloading_city' => 'Стамбул',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-25'),
            'price' => 68000.00,
            'nds' => true,
            'prepayment' => true,
            'loading_type' => 'Шасси',
            'body_type' => 'Рефрижератор',
            'company_id' => 1,
            'status' => 'В пути',
        ]);
    }
}
