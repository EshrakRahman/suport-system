<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;


class TicketOverViewChart extends ChartWidget
{
    protected ?string $heading = 'Ticket Over View Chart';
    public ?string $filter = 'week';

    protected function getData(): array
    {
        $start = null;
        $end = null;
        $perMethod = null; // Renamed for clarity

        switch ($this->filter) {
            case 'week':
                $start = now()->startOfWeek();
                $end = now()->endOfWeek();
                $perMethod = 'perDay';
                break;
            case 'month':
                $start = now()->startOfMonth();
                $end = now()->endOfMonth();
                $perMethod = 'perDay';
                break;
            case 'year':
            default:
                $start = now()->startOfYear();
                $end = now()->endOfYear();
                $perMethod = 'perMonth';
                break;
        }

        $data = Trend::model(Ticket::class)
            ->between(
                start: $start,
                end: $end,
            )
            ->{$perMethod}()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Tickets Created',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
