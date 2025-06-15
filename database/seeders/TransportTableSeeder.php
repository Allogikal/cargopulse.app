<?php

namespace Database\Seeders;

use App\Models\Transport;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transport::create([
            'user_id' => 1,
            'number' => 'А123АА777',
            'brand' => 'Камаз',
            'year' => 2020,
            'loading_type' => 'Платформа',
            'body_type' => 'Открытый кузов',
        ]);

        Transport::create([
            'user_id' => 2,
            'number' => 'В456ВВ888',
            'brand' => 'ГАЗ',
            'year' => 2019,
            'loading_type' => 'Фургон',
            'body_type' => 'Закрытый кузов',
        ]);

        Transport::create([
            'user_id' => 1,
            'number' => 'С789СС999',
            'brand' => 'MAN',
            'year' => 2022,
            'loading_type' => 'Рефрижератор',
            'body_type' => 'Холодильный контейнер',
        ]);

        Transport::create([
            'user_id' => 2,
            'number' => 'Е111ЕЕ222',
            'brand' => 'Scania',
            'year' => 2021,
            'loading_type' => 'Тент',
            'body_type' => 'Тентованный кузов',
        ]);

        Transport::create([
            'user_id' => 3,
            'number' => 'К333КК444',
            'brand' => 'Iveco',
            'year' => 2018,
            'loading_type' => 'Бортовой',
            'body_type' => 'Открытый борт',
        ]);

        Transport::create([
            'user_id' => 1,
            'number' => 'Н555НН666',
            'brand' => 'Volvo',
            'year' => 2023,
            'loading_type' => 'Фургон',
            'body_type' => 'Закрытый кузов',
        ]);

        Transport::create([
            'user_id' => 2,
            'number' => 'О777ОО888',
            'brand' => 'DAF',
            'year' => 2020,
            'loading_type' => 'Платформа',
            'body_type' => 'Открытая платформа',
        ]);

        Transport::create([
            'user_id' => 3,
            'number' => 'Р999РР000',
            'brand' => 'Mercedes',
            'year' => 2022,
            'loading_type' => 'Рефрижератор',
            'body_type' => 'Холодильный кузов',
        ]);
    }
}