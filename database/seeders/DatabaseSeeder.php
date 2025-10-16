<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Service::query()->firstOrCreate(['title' => 'Поездка на квадроцикле 30 минут', 'duration_minutes' => 30]);
        Service::query()->firstOrCreate(['title' => 'Поездка на квадроцикле 60 минут', 'duration_minutes' => 60]);
        Service::query()->firstOrCreate(['title' => 'Тур на эндуро 60 минут', 'duration_minutes' => 60]);
        Service::query()->firstOrCreate(['title' => 'Тур на эндуро 120 минут', 'duration_minutes' => 120]);

        $msc = Config::get('business.timezone');

        // Поездка на квадроцикле 30 мин (duration +30 = 60 мин)
        $service1 = Service::where('title', 'Поездка на квадроцикле 30 минут')->first();
        Booking::query()->firstOrCreate([
            'service_id' => $service1->id,
            'start_time' => Carbon::parse('2025-10-16 13:00', $msc),
            'end_time' => Carbon::parse('2025-10-16 13:00', $msc)->addMinutes(60),
            'name' => 'Test', 'phone' => '123'
        ]);
        Booking::query()->firstOrCreate([
            'service_id' => $service1->id,
            'start_time' => Carbon::parse('2025-10-16 16:00', $msc),
            'end_time' => Carbon::parse('2025-10-16 16:00', $msc)->addMinutes(60),
            'name' => 'Test', 'phone' => '123'
        ]);
        // Аналогично для других на 17.10: 10:00,11:00,13:00,18:00

        // Поездка на квадроцикле 60 мин (duration +30 = 90 мин)
        $service2 = Service::where('title', 'Поездка на квадроцикле 60 минут')->first();
        Booking::query()->firstOrCreate([
            'service_id' => $service2->id,
            'start_time' => Carbon::parse('2025-10-16 10:00', $msc),
            'end_time' => Carbon::parse('2025-10-16 10:00', $msc)->addMinutes(90),
            'name' => 'Test', 'phone' => '123'
        ]);

        // Тур на эндуро 60 мин (duration +30 = 90 мин)
        $service3 = Service::where('title', 'Тур на эндуро 60 минут')->first();
        Booking::query()->firstOrCreate([
            'service_id' => $service3->id,
            'start_time' => Carbon::parse('2025-10-16 10:00', $msc),
            'end_time' => Carbon::parse('2025-10-16 10:00', $msc)->addMinutes(90),
            'name' => 'Test', 'phone' => '123'
        ]);
        // + 11:30, 18:30 на 16.10

        // Тур на эндуро 120 мин (duration +30 = 150 мин)
        $service4 = Service::where('title', 'Тур на эндуро 120 минут')->first();
        Booking::query()->firstOrCreate([
            'service_id' => $service4->id,
            'start_time' => Carbon::parse('2025-10-17 14:00', $msc),
            'end_time' => Carbon::parse('2025-10-17 14:00', $msc)->addMinutes(150),
            'name' => 'Test', 'phone' => '123'
        ]);
    }
}
