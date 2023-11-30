<?php

namespace Frederico\Weather\App\Repository;

use Frederico\Weather\App\Config\Database;
use Frederico\Weather\App\Domain\City;
use PHPUnit\Framework\TestCase;

class CityRepositoryTest extends TestCase
{

    private CityRepository $cityRepository;
    protected function setUp(): void
    {
        $this->cityRepository = new CityRepository(Database::getConnection());
        $this->cityRepository->deleteAll();
    }

    public function testsaveSuccess()
    {
        $city = new City();
        $city->id = "Dili";
        $city->latitude = "-8.06";
        $city->longitude = "125.055";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);

        $result = $this->cityRepository->findById($city->id);

        self::assertEquals("Dili", $result->id);
    }

    public function testFindIdNotFound()
    {
        $result = $this->cityRepository->findById("notFound");
        self::assertNull($result);
    }

    public function testFindAll()
    {

        $city = new City();
        $city->id = "Dili";
        $city->latitude = "-8.06";
        $city->longitude = "125.055";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);


        $city = new City();
        $city->id = "Manufahi";
        $city->latitude = "-8.090";
        $city->longitude = "125.095";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);

        $result = $this->cityRepository->findAll();

        self::assertNotEmpty($result);
    }

    public function testFindSearch()
    {

        $city = new City();
        $city->id = "Dili";
        $city->latitude = "-8.06";
        $city->longitude = "125.055";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);

        $result = $this->cityRepository->findSearchId($city->id);
        self::assertNotEmpty($result);
    }
}
