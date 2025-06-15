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

        Cargo::create([
            'loading_country' => 'Казахстан',
            'loading_index' => '010010',
            'loading_city' => 'Нур-Султан',
            'loading_date' => '2025-04-13',
            'weight_tons' => 15.0,
            'volume_m3' => 40.0,
            'can_co_load' => false,
            'additional_info' => 'Груз — оборудование для промышленности. Требуется страховка и документы на экспорт. Погрузка возможна только в рабочие часы.',
            'unloading_country' => 'Узбекистан',
            'unloading_index' => '100101',
            'unloading_city' => 'Ташкент',
            'unloading_date' => '2025-04-15',
            'price' => 55000.00,
            'nds' => true,
            'prepayment' => false,
            'loading_type' => 'Фура',
            'company_id' => 3,
            'body_type' => 'Закрытый кузов'
        ]);

        Cargo::create([
            'loading_country' => 'Польша',
            'loading_index' => '00-950',
            'loading_city' => 'Варшава',
            'loading_date' => '2025-04-14',
            'weight_tons' => 9.5,
            'volume_m3' => 22.0,
            'can_co_load' => true,
            'additional_info' => 'Груз — мебель. Требуется упаковка и поддержание чистоты. Погрузка осуществляется с использованием грузоподъемных механизмов.',
            'unloading_country' => 'Чехия',
            'unloading_index' => '11000',
            'unloading_city' => 'Прага',
            'unloading_date' => '2025-04-16',
            'price' => 48000.00,
            'nds' => false,
            'prepayment' => true,
            'loading_type' => 'Платформа',
            'company_id' => 4,
            'body_type' => 'Открытый кузов'
        ]);

        Cargo::create([
            'loading_country' => 'Сербия',
            'loading_index' => '11000',
            'loading_city' => 'Белград',
            'loading_date' => '2025-04-15',
            'weight_tons' => 11.0,
            'volume_m3' => 28.0,
            'can_co_load' => false,
            'additional_info' => 'Груз — строительные материалы. Погрузка происходит на площадке. Требуется наличие лицензии на перевозку.',
            'unloading_country' => 'Хорватия',
            'unloading_index' => '10000',
            'unloading_city' => 'Загреб',
            'unloading_date' => '2025-04-17',
            'price' => 43000.00,
            'nds' => true,
            'prepayment' => true,
            'loading_type' => 'Шасси',
            'company_id' => 2,
            'body_type' => 'Закрытый кузов'
        ]);

        Cargo::create([
            'loading_country' => 'Россия',
            'loading_index' => '603135',
            'loading_city' => 'Нижний Новгород',
            'loading_date' => '2025-04-16',
            'weight_tons' => 7.0,
            'volume_m3' => 17.5,
            'can_co_load' => true,
            'additional_info' => 'Груз — бытовая техника. Упакован в коробки. Погрузка производится в течение дня. Необходимо оформление документов на товар.',
            'unloading_country' => 'Украина',
            'unloading_index' => '03057',
            'unloading_city' => 'Харьков',
            'unloading_date' => '2025-04-18',
            'price' => 39000.00,
            'nds' => false,
            'prepayment' => true,
            'loading_type' => 'Фура',
            'company_id' => 3,
            'body_type' => 'Открытый кузов'
        ]);

        Cargo::create([
            'loading_country' => 'Беларусь',
            'loading_index' => '220002',
            'loading_city' => 'Гродно',
            'loading_date' => '2025-04-17',
            'weight_tons' => 6.5,
            'volume_m3' => 16.0,
            'can_co_load' => false,
            'additional_info' => 'Груз — продовольствие. Требуется холодильная цепочка. Погрузка с контролем температуры. Документы готовы заранее.',
            'unloading_country' => 'Латвия',
            'unloading_index' => 'LV-1001',
            'unloading_city' => 'Рига',
            'unloading_date' => '2025-04-19',
            'price' => 41000.00,
            'nds' => true,
            'prepayment' => false,
            'loading_type' => 'Шасси',
            'company_id' => 4,
            'body_type' => 'Холодильный контейнер'
        ]);
    }
}