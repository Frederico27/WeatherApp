<?php

namespace Frederico\Weather\App\Repository;

use Frederico\Weather\App\Config\Database;
use Frederico\Weather\App\Domain\City;
use Frederico\Weather\App\Exception\ValidationException;
use Frederico\Weather\App\Helper\Helper;
use Frederico\Weather\App\Model\CityInputRequest;
use Frederico\Weather\App\Service\MeteoApiServiceDaily;
use PHPUnit\Framework\TestCase;

class MeteoApiServiceDailyTest extends TestCase
{
    private CityRepository $cityRepository;
    private MeteoApiServiceDaily $meteoApiService;

    protected function setUp(): void
    {
        $this->cityRepository = new CityRepository(Database::getConnection());
        $this->meteoApiService = new MeteoApiServiceDaily($this->cityRepository);
        $this->cityRepository->deleteAll();
    }

    //Unit Testing City Data 
    public function testfindByCity()
    {
        $city = new City();
        $city->id = "dili";
        $city->latitude = "-8.5586";
        $city->longitude = "125.5736";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);
        $row = $this->cityRepository->findById($city->id);

        $request = new CityInputRequest();
        $request->id = "DILI";


        $result = $this->meteoApiService->findByCity($request);

        self::assertArrayHasKey("latitude", $result);
    }

    public function testBydefaultCity()
    {
        $city = new City();
        $city->id = "dili";
        $city->latitude = "-8.5586";
        $city->longitude = "125.5736";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);

        $request = new CityInputRequest();

        $result = $this->meteoApiService->findByCity($request);

        self::assertArrayHasKey("daily", $result);
    }

    public function testInputNull()
    {
        $this->expectException(ValidationException::class);

        $request = new CityInputRequest();
        $request->id = "";
        $this->meteoApiService->findByCity($request);
    }

    public function testInputNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new CityInputRequest();
        $request->id = "London";
        $this->meteoApiService->findByCity($request);
    }

    public function testLimit7dataJSON()
    {

        $city = new City();
        $city->id = "dili";
        $city->latitude = "-8.5586";
        $city->longitude = "125.5736";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);

        $request = new CityInputRequest();

        $result = $this->meteoApiService->findByCity($request);

        $data = Helper::limit5DataJSON($result['daily']['time']);

        self::assertArrayHasKey(4, $data);
    }
}
