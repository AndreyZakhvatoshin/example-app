<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingService
{
    public static function hasOverlap($serviceId, $start, $end): bool
    {
        return Booking::query()->where('service_id', $serviceId)
            ->where(function ($query) use ($start, $end) {
                $query->where('start_time', '<', $end)
                    ->where('end_time', '>', $start);
            })->exists();
    }

    public function createBooking(array $data): array
    {
        try {
            $start = Carbon::parse($data['date'] . ' ' . $data['slot'], Config::get('business.timezone'));
            $service = Service::find($data['service_id']);
            $end = $start->clone()->addMinutes($service->duration_minutes + 30);

            if ($start->isSunday() || $start->hour < 10 || $start->hour >= 20) {
                throw new \Exception('Недопустимое время для бронирования');
            }

            $booking = null;
            
            DB::transaction(function () use ($data, $start, $end, $service, &$booking) {
                // Проверяем пересечения бронирований
                $hasOverlap = self::hasOverlap($data['service_id'], $start, $end);

                if ($hasOverlap) {
                    throw new \Exception('Слот занят');
                }

                $booking = Booking::create([
                    'service_id' => $data['service_id'],
                    'start_time' => $start,
                    'end_time' => $end,
                    'name' => $data['name'],
                    'phone' => $data['phone'],
                ]);
            });

            Log::info('Бронирование успешно создано', ['booking_id' => $booking->id]);

            return [
                'success' => true,
                'message' => 'Бронирование успешно создано!',
                'booking' => $booking
            ];
        } catch (\Exception $e) {
            Log::error('Ошибка при создании бронирования: ' . $e->getMessage());
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}