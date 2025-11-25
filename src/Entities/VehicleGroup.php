<?php

namespace Dpb\Package\Fleet\Entities;

class VehicleGroup
{
    public function __construct(
        private string $id,
        private string $code,
        private string $title,
        private ?string $description,
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
    
    public function description(): ?string
    {
        return $this->description;
    }    

    public function rename(string $newTitle): ?string
    {
        return $this->title = $newTitle;
    }    

    public function updateDescription(?string $description): ?string
    {
        return $this->description = $description;
    }    

    public function updateCode(?string $code): ?string
    {
        return $this->code = $code;
    }     
}
