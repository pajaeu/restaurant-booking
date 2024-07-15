<?php

namespace App\Livewire;

use App\Services\BookingService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;

class BookingForm extends Component
{

    #[Validate('required', 'integer', 'min:1')]
    public int $guests = 1;

    #[Validate('required', 'date')]
    public string $date = '';

    #[Validate('required')]
    public string $time = '';

    #[Validate('required', 'integer', 'exists:tables,id')]
    public ?int $tableId = null;

    public ?Collection $hours = null;

    public ?Collection $tables = null;

    private readonly BookingService $bookingService;

    protected array $messages = [
        'guests.required' => 'Počet hostů je povinný údaj.',
        'guests.integer' => 'Počet hostů musí být celé číslo.',
        'guests.min' => 'Počet hostů musí být alespoň :min.',
        'date.required' => 'Datum je povinný údaj.',
        'date.date' => 'Datum musí být platné datum.',
        'date.after_or_equal' => 'Datum musí být dnešní nebo pozdější.',
        'time.required' => 'Čas je povinný údaj.',
        'tableId.required' => 'Stůl je povinný údaj.',
        'tableId.integer' => 'Stůl musí být celé číslo.',
        'tableId.exists' => 'Vybraný stůl neexistuje.'
    ];

    public function boot(BookingService $bookingService): void
    {
        $this->bookingService = $bookingService;
    }

    public function onGuestsChange(): void
    {
        $this->reset(['tableId', 'tables']);

        $this->findAvailableTables();
    }

    public function onDateChange(): void
    {
        $this->reset(['time', 'tableId', 'tables']);

        $this->findAvailableHours();
    }

    public function findAvailableTables(): void
    {
        if (empty($this->date) || empty($this->time)) {
            return;
        }

        $this->tables = $this->bookingService->findAvailableTables(
            $this->guests,
            $this->date,
            $this->time
        );
    }

    public function findAvailableHours(): void
    {
        $hours = $this->bookingService->findAvailableHours($this->date);

        if ($hours->isEmpty()) {
            $this->addError('date', 'Již není možné rezervovat stůl na dnešní den.');
        }

        $this->hours = $hours;
    }

    public function submit(): void
    {
        $this->validate();

        try {
            $booking = $this->bookingService->createBooking([
                'guests' => $this->guests,
                'date' => $this->date,
                'time' => $this->time,
                'table_id' => $this->tableId
            ]);

            session()->flash('success', "Rezervace proběhla úspěšně, vaše číslo rezervace je: {$booking->id}");

            $this->reset(['guests', 'date', 'time', 'hours', 'tableId', 'tables']);
        } catch (\Exception $e) {
            $this->addError('error', $e->getMessage());
        }
    }

    public function render(): View
    {
        return view('livewire.booking-form')
            ->title('Rezervace');
    }
}
