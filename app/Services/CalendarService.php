<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class CalendarService
{
    public function getWeekDays(): array
    {
        $now = Carbon::now(Config::get('business.timezone'));
        $startOfWeek = $now->startOfWeek(); // Понедельник
        $days = [];
        
        for ($i = 0; $i < 6; $i++) { // Пн-Сб
            $day = $startOfWeek->clone()->addDays($i);
            $day->locale('ru');
            $days[] = [
                'date' => $day->format('Y-m-d'), 
                'label' => $day->isoFormat('D.MM dd')
            ];
        }
        
        return $days;
    }
    
    public function getDaysForService($serviceId): array
    {
        return $this->getWeekDays();
    }
    
    public function getSlotsForService($serviceId, $date, $durationMinutes): array
    {
        $selectedDate = Carbon::parse($date, Config::get('business.timezone'));
        if ($selectedDate->isSunday()) {
            return [];
        }

        $slots = [];
        $startHour = Carbon::parse($date . ' 10:00', Config::get('business.timezone'));
        $endHour = Carbon::parse($date . ' 20:00', Config::get('business.timezone'));
        $step = 30; // Шаг в минутах для возможных стартов

        while ($startHour->lte($endHour->subMinutes($durationMinutes + 30))) {
            $endSlot = $startHour->clone()->addMinutes($durationMinutes + 30);
            if (!BookingService::hasOverlap($serviceId, $startHour, $endSlot)) {
                $slots[] = $startHour->format('H:i');
            }
            $startHour->addMinutes($step);
        }
        
        return $slots;
    }
}
