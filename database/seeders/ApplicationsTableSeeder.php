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
            'loading_country' => 'Германия',
            'loading_index' => '10585',
            'loading_city' => 'Берлин',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-10'),
            'weight_tons' => 7.6,
            'volume_m3' => 16.3,
            'can_co_load' => true,
            'additional_info' => 'Погрузка с использованием погрузчика.',
            'unloading_country' => 'Франция',
            'unloading_index' => '75001',
            'unloading_city' => 'Париж',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-12'),
            'price' => 28000.00,
            'nds' => false,
            'prepayment' => true,
            'loading_type' => 'Микрофургон',
            'body_type' => 'Открытый кузов',
            'company_id' => 2,
            'status' => 'Доставлено',
        ]);
        
        Application::create([
            'loading_country' => 'Россия',
            'loading_index' => '603119',
            'loading_city' => 'Нижний Новгород',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-12'),
            'weight_tons' => 10.0,
            'volume_m3' => 22.5,
            'can_co_load' => false,
            'additional_info' => 'Погрузка осуществляется силами клиента.',
            'unloading_country' => 'Литва',
            'unloading_index' => 'LT-01',
            'unloading_city' => 'Вильнюс',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-14'),
            'price' => 36000.00,
            'nds' => true,
            'prepayment' => false,
            'loading_type' => 'Фура',
            'body_type' => 'Закрытый кузов',
            'company_id' => 3,
            'status' => 'В пути',
        ]);
        
        Application::create([
            'loading_country' => 'Украина',
            'loading_index' => '53031',
            'loading_city' => 'Одесса',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-16'),
            'weight_tons' => 14.5,
            'volume_m3' => 30.0,
            'can_co_load' => true,
            'additional_info' => 'Требуется подтверждение наличия груза на складе.',
            'unloading_country' => 'Чехия',
            'unloading_index' => '11000',
            'unloading_city' => 'Прага',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-18'),
            'price' => 47000.00,
            'nds' => true,
            'prepayment' => true,
            'loading_type' => 'Шасси',
            'body_type' => 'Рефрижератор',
            'company_id' => 1,
            'status' => 'Доставлено',
        ]);
        
        Application::create([
            'loading_country' => 'Казахстан',
            'loading_index' => '050012',
            'loading_city' => 'Астана',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-19'),
            'weight_tons' => 8.2,
            'volume_m3' => 17.5,
            'can_co_load' => false,
            'additional_info' => 'Погрузка производится до 10:00 утра.',
            'unloading_country' => 'Таджикистан',
            'unloading_index' => '73401',
            'unloading_city' => 'Душанбе',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-21'),
            'price' => 25000.00,
            'nds' => false,
            'prepayment' => false,
            'loading_type' => 'Платформа',
            'body_type' => 'Открытый кузов',
            'company_id' => 2,
            'status' => 'В пути',
        ]);

        Application::create([
            'loading_country' => 'Беларусь',
            'loading_index' => '220096',
            'loading_city' => 'Гомель',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-23'),
            'weight_tons' => 11.0,
            'volume_m3' => 25.0,
            'can_co_load' => true,
            'additional_info' => 'Погрузка производится по предварительной договорённости.',
            'unloading_country' => 'Украина',
            'unloading_index' => '49000',
            'unloading_city' => 'Днепр',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-25'),
            'price' => 37000.00,
            'nds' => true,
            'prepayment' => false,
            'loading_type' => 'Фура',
            'body_type' => 'Открытый кузов',
            'company_id' => 3,
            'status' => 'В пути',
        ]);
        
        Application::create([
            'loading_country' => 'Россия',
            'loading_index' => '190000',
            'loading_city' => 'Санкт-Петербург',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-20'),
            'weight_tons' => 9.5,
            'volume_m3' => 20.0,
            'can_co_load' => false,
            'additional_info' => 'Погрузка только в будние дни до 17:00.',
            'unloading_country' => 'Латвия',
            'unloading_index' => 'LV-1001',
            'unloading_city' => 'Рига',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-22'),
            'price' => 31000.00,
            'nds' => false,
            'prepayment' => true,
            'loading_type' => 'Микрофургон',
            'body_type' => 'Закрытый кузов',
            'company_id' => 1,
            'status' => 'Доставлено',
        ]);
        
        Application::create([
            'loading_country' => 'Казахстан',
            'loading_index' => '010000',
            'loading_city' => 'Нур-Султан',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-24'),
            'weight_tons' => 13.0,
            'volume_m3' => 28.0,
            'can_co_load' => true,
            'additional_info' => 'Требуется документы на груз.',
            'unloading_country' => 'Армения',
            'unloading_index' => '0001',
            'unloading_city' => 'Ереван',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-26'),
            'price' => 42000.00,
            'nds' => true,
            'prepayment' => true,
            'loading_type' => 'Шасси',
            'body_type' => 'Рефрижератор',
            'company_id' => 2,
            'status' => 'В пути',
        ]);
        
        Application::create([
            'loading_country' => 'Украина',
            'loading_index' => '61001',
            'loading_city' => 'Харьков',
            'loading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-28'),
            'weight_tons' => 7.8,
            'volume_m3' => 15.5,
            'can_co_load' => false,
            'additional_info' => 'Погрузка производится силами клиента.',
            'unloading_country' => 'Польша',
            'unloading_index' => '31-542',
            'unloading_city' => 'Краков',
            'unloading_date' => Carbon::createFromFormat('Y-m-d', '2025-04-30'),
            'price' => 29000.00,
            'nds' => false,
            'prepayment' => false,
            'loading_type' => 'Платформа',
            'body_type' => 'Открытый кузов',
            'company_id' => 3,
            'status' => 'Доставлено',
        ]);
    }
}
