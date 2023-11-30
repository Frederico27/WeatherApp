<?php

namespace Frederico\Weather\App\Domain;

class City
{

    public ?string $id = null;
    public ?string $latitude = null;
    public ?string $longitude = null;
    public ?string $country = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function getLat(): string
    {
        return $this->latitude;
    }

    public function getLong(): string
    {
        return $this->longitude;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
