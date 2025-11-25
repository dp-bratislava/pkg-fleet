<?php

namespace Dpb\Package\Fleet\Entities;

use Carbon\Carbon;

class VehicleCode
{
    public function __construct(
        private string $id,
        private string $code,
        private Carbon $dateFrom,
        private ?Carbon $dateTo
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function dateFrom(): Carbon
    {
        return $this->dateFrom;
    }    

    public function dateTo(): ?Carbon
    {
        return $this->dateTo;
    }  


    public function updateCode(?string $code): ?string
    {
        return $this->code = $code;
    }    
    
    public function isCurrent(): bool
    {
        return $this->dateTo === null;
    }

    public function endToDate(Carbon $date): void
    {
        $this->dateTo = $date;
    }    
}
