<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'inn' => '7708563498',
            'country' => 'Россия',
            'registration_address' => 'г. Москва, ул. Ленина, д. 1',
            'postal_address' => '101000, г. Москва, ул. Ленина, д. 1',
            'city' => 'Москва',
            'email' => 'company1@example.com',
            'name' => 'ООО "Грузовик"',
            'rate' => 85,
            'phone' => '+7 (495) 123-45-67',
            'activity' => 'Организация перевозок, доставка грузов',
            'cargos_statistics_month' => 15,
            'cargos_statistics_year' => 180,
            'cargos_statistics_all_time' => 1200,
            'registered_at' => now(),
            'last_login' => now(),
        ]);

        Company::create([
            'inn' => '7711223344',
            'country' => 'Беларусь',
            'registration_address' => 'г. Минск, ул. Сурганова, д. 5',
            'postal_address' => '220005, г. Минск, ул. Сурганова, д. 5',
            'city' => 'Минск',
            'email' => 'logistics2@belpost.by',
            'name' => 'ООО "Беллогистика"',
            'rate' => 72,
            'phone' => '+375 (29) 111-22-33',
            'activity' => 'Перевозка и хранение грузов',
            'cargos_statistics_month' => 20,
            'cargos_statistics_year' => 240,
            'cargos_statistics_all_time' => 1800,
            'registered_at' => now()->subMonth(),
            'last_login' => now(),
        ]);

        Company::create([
            'inn' => '7733445566',
            'country' => 'Казахстан',
            'registration_address' => 'г. Алматы, ул. Абая, д. 100',
            'postal_address' => '050000, г. Алматы, ул. Абая, д. 100',
            'city' => 'Алматы',
            'email' => 'cargo.kz@example.com',
            'name' => 'ТОО "Транспорт КЗ"',
            'rate' => 35,
            'phone' => '+7 (701) 987-65-43',
            'activity' => 'Доставка международных грузов',
            'cargos_statistics_month' => 8,
            'cargos_statistics_year' => 96,
            'cargos_statistics_all_time' => 750,
            'registered_at' => now()->subMonths(3),
            'last_login' => now(),
        ]);

        Company::create([
            'inn' => '7777889900',
            'country' => 'Украина',
            'registration_address' => 'м. Київ, вул. Хрещатик, 45',
            'postal_address' => '01001, м. Київ, вул. Хрещатик, 45',
            'city' => 'Киев',
            'email' => 'ukr.logistics@example.com',
            'name' => 'ТОВ "Логістичні Рішення"',
            'rate' => 22,
            'phone' => '+38 (044) 123-45-67',
            'activity' => 'Экспедирование и логистические решения',
            'cargos_statistics_month' => 12,
            'cargos_statistics_year' => 144,
            'cargos_statistics_all_time' => 900,
            'registered_at' => now()->subYear(),
            'last_login' => now(),
        ]);

        Company::create([
            'inn' => '7722334455',
            'country' => 'Таджикистан',
            'registration_address' => 'г. Душанбе, ул. Рудаки, д. 15',
            'postal_address' => '734000, г. Душанбе, ул. Рудаки, д. 15',
            'city' => 'Душанбе',
            'email' => 'tj.logistics@example.com',
            'name' => 'ООО "Самоход Таджик"',
            'rate' => 45,
            'phone' => '+992 98 765 43 21',
            'activity' => 'Доставка по Центральной Азии',
            'cargos_statistics_month' => 10,
            'cargos_statistics_year' => 120,
            'cargos_statistics_all_time' => 850,
            'registered_at' => now()->subMonths(6),
            'last_login' => now(),
        ]);
    }
}