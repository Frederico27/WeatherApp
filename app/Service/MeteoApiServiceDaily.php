<?php

namespace Frederico\Weather\App\Service;

use Frederico\Weather\App\Exception\ValidationException;
use Frederico\Weather\App\Model\CityInputRequest;
use Frederico\Weather\App\Repository\CityRepository;
use GuzzleHttp\Client;

class MeteoApiServiceDaily
{
    //Default Value of URL
    private string $baseUrl = "https://api.open-meteo.com/v1/forecast?"; //Meteo URL
    private string $tailUrl = "&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=Asia%2FTokyo"; //Atrribute Meteo
    private Client $httpClient; //Http Client Object
    private CityRepository $cityRepository; //Repository City

    public function __construct(CityRepository $cityRepository)
    {
        $this->httpClient = new Client();
        $this->cityRepository = $cityRepository;
    }

    //Find each JSON Data By City
    public function findByCity(CityInputRequest $request)
    {
        $this->validateCityInputRequest($request);

        $city = $this->cityRepository->findById($request->id);
        if ($city == null) {
            throw new ValidationException("Dadus la existe");
        }
        $url = $this->baseUrl . "latitude=" . $city->latitude . "&longitude=" . $city->longitude . $this->tailUrl;
        $response = $this->httpClient->get($url);

        if ($response) {
            $result = json_decode($response->getBody()->getContents(), true);
            if ($result) {
                return $result;
            } else {
                throw new ValidationException("Dadus API la existe");
            }
        } else {
            throw new ValidationException("API Timeout");
        }
    }

    //Validate Input from users
    public function validateCityInputRequest(CityInputRequest $request)
    {
        if (
            $request->id == null || trim($request->id) == ""
        ) {
            throw new ValidationException("Labele husik input mamuk");
        }
        strtolower($request->id);
    }
}
