<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Service;
use App\Services\BookingService;
use App\Services\CalendarService;
use Illuminate\Http\JsonResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class BookingController extends Controller
{
    private CalendarService $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function index(): Response
    {
        $services = Service::all();
        return inertia('Home', ['services' => $services]);
    }

    public function calendar($serviceId): Response
    {
        $service = Service::query()->findOrFail($serviceId);
        $days = $this->calendarService->getDaysForService($serviceId);
        return inertia('Calendar', ['service' => $service, 'days' => $days]);
    }

    public function slots($serviceId, $date): JsonResponse
    {
        $service = Service::query()->findOrFail($serviceId);
        $slots = $this->calendarService->getSlotsForService($serviceId, $date, $service->duration_minutes);
        return response()->json(['slots' => $slots]);
    }

    public function store(StoreBookingRequest $request, BookingService $bookingService): JsonResponse
    {
        $result = $bookingService->createBooking($request->validated());

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => $result['message']
            ]);
        } else {
            return response()->json(['error' => $result['error']], 422);
        }
    }
}

