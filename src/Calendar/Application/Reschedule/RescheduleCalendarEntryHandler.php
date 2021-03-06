<?php

declare(strict_types=1);

namespace App\Calendar\Application\Reschedule;

use App\Calendar\Repository\CalendarEntryRepository;

final class RescheduleCalendarEntryHandler
{
    private CalendarEntryRepository $repository;

    public function __construct(CalendarEntryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RescheduleCalendarEntryCommand $command): void
    {
        $entry = $this->repository->get($command->id);

        $entry->reschedule(
            $command->schedule,
        );
    }
}
