<?php

namespace Dpb\Package\Fleet\Entities;

class VehicleType
{
    public function __construct(
        private string $id,
        private string $code,
        private string $title,
    ) {}

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function title(): string
    {
        return $this->title;
    }
    
    public function rename(string $newTitle): ?string
    {
        return $this->title = $newTitle;
    }    

    public function updateCode(?string $code): ?string
    {
        return $this->code = $code;
    }     
}
