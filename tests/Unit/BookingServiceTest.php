<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\Table;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    private BookingService $bookingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookingService = new BookingService();
    }

    /** @test */
    public function it_creates_a_booking_when_table_is_available()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $table = Table::factory()->create(['capacity' => 4]);

        $bookingData = [
            'guests' => 2,
            'date' => '2024-07-15',
            'time' => '12:00',
            'table_id' => $table->id
        ];

        $booking = $this->bookingService->createBooking($bookingData);

        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertEquals($user->id, $booking->user_id);
        $this->assertEquals(2, $booking->guests);
        $this->assertEquals($table->id, $booking->table_id);
        $this->assertEquals('2024-07-15 12:00:00', $booking->reserved_time);
    }

    /** @test */
    public function it_throws_exception_when_no_table_is_available()
    {
        $this->expectException(\App\Exceptions\BookingException::class);
        $this->expectExceptionMessage('V tento čas není žádný stůl k dispozici.');

        $bookingData = [
            'guests' => 2,
            'date' => '2024-07-15',
            'time' => '12:00',
            'table_id' => 1
        ];

        $this->bookingService->createBooking($bookingData);
    }

    /** @test */
    public function it_finds_available_table()
    {
        $table = Table::factory()->create(['capacity' => 4]);

        $availableTable = $this->bookingService->findAvailableTable(3, '2024-07-15', '12:00');

        $this->assertInstanceOf(Table::class, $availableTable);
        $this->assertEquals($table->id, $availableTable->id);
    }

    /** @test */
    public function it_finds_available_tables()
    {
        Table::factory()->create(['capacity' => 2]);
        Table::factory()->create(['capacity' => 4]);
        Table::factory()->create(['capacity' => 6]);

        $availableTables = $this->bookingService->findAvailableTables(3, '2024-07-15', '12:00');

        $this->assertCount(2, $availableTables);
        $this->assertTrue($availableTables->contains('capacity', 4));
        $this->assertTrue($availableTables->contains('capacity', 6));
    }

    /** @test */
    public function it_excludes_tables_with_existing_bookings()
    {
        $table1 = Table::factory()->create(['capacity' => 4]);
        $table2 = Table::factory()->create(['capacity' => 4]);

        $user = User::factory()->create();

        $user->bookings()->create([
            'table_id' => $table1->id,
            'guests' => 2,
            'reserved_time' => '2024-07-15 12:00:00'
        ]);

        $availableTable = $this->bookingService->findAvailableTable(4, '2024-07-15', '12:00');

        $this->assertInstanceOf(Table::class, $availableTable);
        $this->assertEquals($table2->id, $availableTable->id);
    }

    /** @test */
    public function it_considers_booking_time_range()
    {
        $table = Table::factory()->create(['capacity' => 4]);

        $user = User::factory()->create();

        $user->bookings()->create([
            'table_id' => $table->id,
            'guests' => 2,
            'reserved_time' => '2024-07-15 11:00:00'
        ]);

        $availableTable = $this->bookingService->findAvailableTable(4, '2024-07-15', '14:00');

        $this->assertInstanceOf(Table::class, $availableTable);
        $this->assertEquals($table->id, $availableTable->id);

        $unavailableTable = $this->bookingService->findAvailableTable(4, '2024-07-15', '11:00');

        $this->assertNull($unavailableTable);
    }
}