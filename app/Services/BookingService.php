<?php

namespace App\Services;

use App\Exceptions\BookingException;
use App\Models\Booking;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class BookingService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }


    /**
     * @throws BookingException
     */
    public function createBooking(array $data)
    {
        $table = $this->findAvailableTable($data['guests'], $data['date'], $data['time']);

        if (!$table) {
            BookingException::tableNotAvailable();
        }

        $isSelectedTableAvailable = $this->isTableAvailable($data['table_id'], $data['guests'], $data['date'], $data['time']);

        if (!$isSelectedTableAvailable) {
            BookingException::selectedTableNotAvailable();
        }

        $reservedTime = Carbon::parse($data['date'] . ' ' . $data['time'])
            ->format('Y-m-d H:i:s');

        return Booking::create([
            'user_id' => auth()->id(),
            'guests' => $data['guests'],
            'table_id' => $data['table_id'],
            'reserved_time' => $reservedTime
        ]);
    }

    public function findAvailableHours(string $date): Collection
    {
        $startHour = config('restaurant.open_hours.open');
        $endHour = config('restaurant.open_hours.close') - 1;

        $currentHour = Carbon::now()
            ->hour;

        if ($date === Carbon::today()->toDateString() && $currentHour >= $startHour) {
            $startHour = $currentHour + 1;
        }

        if ($date === Carbon::today()->toDateString() && $currentHour >= $endHour) {
            return collect();
        }

        $timeSlots = $this->generateTimeSlots($startHour, $endHour, config('restaurant.half_hours'));

        return collect($timeSlots);
    }

    public function isTableAvailable(int $tableId, int $guests, string $date, string $time): bool
    {
        $table = Table::find($tableId);

        if (!$table || $table->capacity < $guests) {
            return false;
        }

        [$bookingStartTime, $bookingEndTime] = $this->getBookingTimes($date, $time);

        return Booking::where('table_id', $tableId)
            ->whereBetween('reserved_time', [$bookingStartTime, $bookingEndTime])
            ->doesntExist();
    }

    public function findAvailableTable(int $guests, string $date, string $time)
    {
        $query = $this->getAvailableTablesQuery($guests, $date, $time);

        return $query->first();
    }

    public function findAvailableTables(int $guests, string $date, string $time)
    {
        $query = $this->getAvailableTablesQuery($guests, $date, $time);

        return $query->get();
    }

    private function getAvailableTablesQuery(int $guests, string $date, string $time)
    {
        [$bookingStartTime, $bookingEndTime] = $this->getBookingTimes($date, $time);

        return Table::select('id', 'name', 'capacity')
            ->where('capacity', '>=', $guests)
            ->whereDoesntHave('bookings', function ($query) use ($bookingStartTime, $bookingEndTime) {
                $query->whereBetween('reserved_time', [$bookingStartTime, $bookingEndTime]);
            });
    }

    private function getBookingTimes(string $date, string $time): array
    {
        $bookingDateTime = Carbon::parse($date . ' ' . $time);
        $bookingStartTime = $bookingDateTime->copy()
            ->subHours(2);
        $bookingEndTime = $bookingDateTime->copy();

        return [$bookingStartTime, $bookingEndTime];
    }

    private function generateTimeSlots(int $startHour, int $endHour, bool $halfHours = false): array
    {
        $fullHours = range($startHour, $endHour);
        $timeSlots = [];

        foreach ($fullHours as $hour) {
            $formattedHour = str_pad($hour, 2, '0', STR_PAD_LEFT);
            $timeSlots[] = $formattedHour . ':00';

            if ($halfHours && $hour < $endHour) {
                $timeSlots[] = $formattedHour . ':30';
            }
        }

        return $timeSlots;
    }
}
