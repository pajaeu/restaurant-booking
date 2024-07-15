<?php

namespace App\Services;

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
     * @throws \Exception
     */
    public function createBooking(array $data)
    {
        $table = $this->findAvailableTable($data['guests'], $data['date'], $data['time']);

        if (!$table) {
            throw new \Exception('Pro Vaše zvolené možnosti již nejsou žádné stoly k dispozici.');
        }

        $isSelectedTableAvailable = $this->isTableAvailable($data['table_id'], $data['guests'], $data['date'], $data['time']);

        if (!$isSelectedTableAvailable) {
            throw new \Exception('Tento stůl již není k dispozici.');
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
        $startHour = config('app.open_hours.open');
        $endHour = config('app.open_hours.close') - 1;

        $currentHour = Carbon::now()
            ->hour;

        if ($date === Carbon::today()->toDateString() && $currentHour >= $startHour) {
            $startHour = $currentHour + 1;
        }

        if ($date === Carbon::today()->toDateString() && $currentHour >= $endHour) {
            return collect();
        }

        return collect(range($startHour, $endHour))
            ->mapWithKeys(fn($hour) => [$hour => $hour . ':00']);
    }

    public function isTableAvailable(int $tableId, int $guests, string $date, string $time): bool
    {
        $table = Table::find($tableId);

        if (!$table) {
            return false;
        }

        $bookingDateTime = Carbon::parse($date . ' ' . $time);
        $bookingStartTime = $bookingDateTime->copy()
            ->subHours(2);
        $bookingEndTime = $bookingDateTime->copy();

        return Booking::where('table_id', $tableId)
            ->where('capacity', '>=', $guests)
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
        $bookingDateTime = Carbon::parse($date . ' ' . $time);
        $bookingStartTime = $bookingDateTime->copy()
            ->subHours(2);
        $bookingEndTime = $bookingDateTime->copy();

        return Table::where('capacity', '>=', $guests)
            ->whereDoesntHave('bookings', function ($query) use ($bookingStartTime, $bookingEndTime) {
                $query->whereBetween('reserved_time', [$bookingStartTime, $bookingEndTime]);
            });
    }
}
