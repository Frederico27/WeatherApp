<?php

namespace Frederico\Weather\App\Service;

use Frederico\Weather\App\Config\Database;
use Frederico\Weather\App\Domain\City;
use Frederico\Weather\App\Exception\ValidationException;
use Frederico\Weather\App\Helper\Helper;
use Frederico\Weather\App\Model\CityInputRequest;
use Frederico\Weather\App\Repository\CityRepository;
use PHPUnit\Framework\TestCase;

class MeteoApiServiceHourlyTest extends TestCase
{

    private CityRepository $cityRepository;
    private MeteoApiServiceHourly $meteoApiServiceHourly;

    protected function setUp(): void
    {
        $this->cityRepository = new CityRepository(Database::getConnection());
        $this->meteoApiServiceHourly = new MeteoApiServiceHourly($this->cityRepository);
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


        $result = $this->meteoApiServiceHourly->findByCity($request);

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

        $result = $this->meteoApiServiceHourly->findByCity($request);

        self::assertArrayHasKey("hourly", $result);
    }

    public function testInputNull()
    {
        $this->expectException(ValidationException::class);

        $request = new CityInputRequest();
        $request->id = "";
        $this->meteoApiServiceHourly->findByCity($request);
    }

    public function testInputNotFound()
    {
        $this->expectException(ValidationException::class);

        $request = new CityInputRequest();
        $request->id = "London";
        $this->meteoApiServiceHourly->findByCity($request);
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

        $result = $this->meteoApiServiceHourly->findByCity($request);

        $data = Helper::limit5DataHourly($result['hourly']['time']);

        self::assertArrayHasKey(4, $data);
    }

    public function testvard()
    {
        $city = new City();
        $city->id = "dili";
        $city->latitude = "-8.5586";
        $city->longitude = "125.5736";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);


        $city = new City();
        $city->id = "atauro";
        $city->latitude = "-8.2667";
        $city->longitude = "125.6014";
        $city->country = "Timor-Leste";

        $this->cityRepository->save($city);

        $cities = $this->cityRepository->findAll();

        foreach ($cities as $row => $value) {

            $kota[] = $value->getId();
            $lat[] = $value->getLat();
            $long[] = $value->getLong();
            $country[] = $value->getCountry();

            $request = new CityInputRequest();
            $request->id = $value->getId();

            $data = $this->meteoApiServiceHourly->findByCity($request);
            $data_weacode = $data['hourly']['weather_code'];
            $result_weacode = Helper::limitDataHourlyNowMap($data_weacode);

            foreach ($result_weacode as $key => $value) {
                $nilai[] = $value;
            }

            var_dump($nilai);
        }
    }
}
