<?php

namespace Dpb\Package\Fleet\Entities;

class VehicleBrand
{
    public function __construct(
        private string $id,
        private string $title,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }
    
    public function rename(string $newTitle): ?string
    {
        return $this->title = $newTitle;
    }    
}
