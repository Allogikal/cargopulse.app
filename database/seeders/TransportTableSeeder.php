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
    }
}
