<?php

namespace Database\Seeders;

use App\Models\Cargo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CargosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cargo::create([
            'loading_country' => 'Россия',
            'loading_index' => '123456',
            'loading_city' => 'Москва',
            'loading_date' => '2025-04-10',
            'weight_tons' => 10.5,
            'volume_m3' => 25.75,
            'can_co_load' => true,
            'additional_info' => 'Погрузка с подъемником. Груз требует аккуратной погрузки. Упаковка в деревянные ящики. Необходимы страховые документы.',
            'unloading_country' => 'Беларусь',
            'unloading_index' => '220035',
            'unloading_city' => 'Минск',
            'unloading_date' => '2025-04-12',
            'price' => 50000.00,
            'nds' => true,
            'prepayment' => false,
            'loading_type' => 'Платформа',
            'company_id' => 1,
            'body_type' => 'Открытый кузов'
        ]);

        Cargo::create([
            'loading_country' => 'Украина',
            'loading_index' => '49000',
            'loading_city' => 'Киев',
            'loading_date' => '2025-04-11',
            'weight_tons' => 8.2,
            'volume_m3' => 18.5,
            'can_co_load' => false,
            'additional_info' => 'Груз состоит из электроники, требуется защита от влаги. Погрузка производится в течении 2 часов. Нужны специалисты по упаковке.',
            'unloading_country' => 'Литва',
            'unloading_index' => 'LT-01',
            'unloading_city' => 'Вильнюс',
            'unloading_date' => '2025-04-13',
            'price' => 38000.00,
            'nds' => false,
            'prepayment' => true,
            'loading_type' => 'Фура',
            'company_id' => 2,
            'body_type' => 'Закрытый кузов'
        ]);

        Cargo::create([
            'loading_country' => 'Грузия',
            'loading_index' => '0101',
            'loading_city' => 'Тбилиси',
            'loading_date' => '2025-04-12',
            'weight_tons' => 12.0,
            'volume_m3' => 30.0,
            'can_co_load' => true,
            'additional_info' => 'Требуется наличие погрузчика. Груз — стройматериалы, необходимо соблюдение порядка размещения. Время погрузки — с 9:00 до 15:00. Доставка без оплаты НДС.',
            'unloading_country' => 'Армения',
            'unloading_index' => '0010',
            'unloading_city' => 'Ереван',
            'unloading_date' => '2025-04-14',
            'price' => 42000.00,
            'nds' => true,
            'prepayment' => true,
            'loading_type' => 'Шасси',
            'company_id' => 2,
            'body_type' => 'Холодильный контейнер'
        ]);
    }
}
