<?php

namespace Frederico\Weather\App\Controller;

use Frederico\Weather\App\App\View;
use Frederico\Weather\App\Config\Database;
use Frederico\Weather\App\Exception\ValidationException;
use Frederico\Weather\App\Helper\Helper;
use Frederico\Weather\App\Model\CityInputRequest;
use Frederico\Weather\App\Repository\CityRepository;
use Frederico\Weather\App\Service\MeteoApiServiceDaily;
use Frederico\Weather\App\Service\MeteoApiServiceHourly;

class HomeController
{

    private MeteoApiServiceDaily $meteoApiServiceDaily;
    private MeteoApiServiceHourly $meteoApiServiceHourly;
    private CityRepository $cityRepository;

    public function __construct()
    {
        $connection = Database::getConnection();
        $this->cityRepository = new CityRepository($connection);
        $this->meteoApiServiceDaily = new MeteoApiServiceDaily($this->cityRepository);
        $this->meteoApiServiceHourly = new MeteoApiServiceHourly($this->cityRepository);
    }

    function index()
    {
        View::render(
            'Home/index',
            ["title" => "Pajina Prinsipal"]
        );
    }

    function dadusKlima()
    {
        try {

            //Request and Response for Daily Data
            $request = new CityInputRequest();
            $data = $this->meteoApiServiceDaily->findByCity($request);
            $data_array_time = $data['daily']['time'];
            $data_array_temp = $data['daily']['temperature_2m_max'];
            $data_array_weatherCode = $data['daily']['weather_code'];
            $result_time = Helper::limit5DataJSON($data_array_time);
            $result_temp = Helper::limit5DataJSON($data_array_temp);
            $result_weacode = Helper::limit5DataJSON($data_array_weatherCode);

            //Request and Response for Hourly Data
            $data_hourly = $this->meteoApiServiceHourly->findByCity($request);
            $data_time_hourly = $data_hourly['hourly']['time'];
            $data_temp_hourly = $data_hourly['hourly']['temperature_2m'];
            $data_weacode_hourly = $data_hourly['hourly']['weather_code'];
            $result_hourly_time = Helper::limit5DataHourly($data_time_hourly);
            $result_hourly_temp = Helper::limit5DataHourly($data_temp_hourly);
            $result_hourly_weacode = Helper::limit5DataHourly($data_weacode_hourly);

            //Request and Response for Hourly Data
            $data_now = $this->meteoApiServiceHourly->findByCity($request);
            $date_temp_now = $data_now['hourly']['temperature_2m'];
            $data_weacode_now = $data_now['hourly']['weather_code'];
            $result_temp_now = Helper::limitDataHourlyNow($date_temp_now);
            $result_weacode_now = Helper::limitDataHourlyNow($data_weacode_now);

            //Retrieve Data From Database
            $city = $this->cityRepository->findById($request->id);
            View::render(
                'Home/dadus_klima',
                [
                    "title" => "Dadus Klima",
                    "daily_time" => $result_time,
                    "temp_daily" => $result_temp,
                    "weather_code_daily" => $result_weacode,
                    "time_hourly" => $result_hourly_time,
                    "temp_hourly" => $result_hourly_temp,
                    "weacode_hourly" => $result_hourly_weacode,
                    "city" => ucfirst($city->id),
                    "country" => $city->country,
                    "temp_now" => $result_temp_now,
                    "weacode_now" => $result_weacode_now
                ]
            );
        } catch (ValidationException $exception) {
            View::render(
                'Home/dadus_klima',
                [
                    "title" => "Dadus Klima",
                    "error" => $exception->getMessage()
                ]
            );
        }
    }

    function postDadusKlima()
    {
        try {

            //Request and Response for Daily Data
            $request = new CityInputRequest();
            $request->id = $_GET['city'];
            $data = $this->meteoApiServiceDaily->findByCity($request);
            $data_array_time = $data['daily']['time'];
            $data_array_temp = $data['daily']['temperature_2m_max'];
            $data_array_weatherCode = $data['daily']['weather_code'];
            $result_time = Helper::limit5DataJSON($data_array_time);
            $result_temp = Helper::limit5DataJSON($data_array_temp);
            $result_weacode = Helper::limit5DataJSON($data_array_weatherCode);

            //Request and Response for Hourly Data
            $data_hourly = $this->meteoApiServiceHourly->findByCity($request);
            $data_time_hourly = $data_hourly['hourly']['time'];
            $data_temp_hourly = $data_hourly['hourly']['temperature_2m'];
            $data_weacode_hourly = $data_hourly['hourly']['weather_code'];
            $result_hourly_time = Helper::limit5DataHourly($data_time_hourly);
            $result_hourly_temp = Helper::limit5DataHourly($data_temp_hourly);
            $result_hourly_weacode = Helper::limit5DataHourly($data_weacode_hourly);

            //Request and Response for Hourly Data
            $data_now = $this->meteoApiServiceHourly->findByCity($request);
            $date_temp_now = $data_now['hourly']['temperature_2m'];
            $data_weacode_now = $data_now['hourly']['weather_code'];
            $result_temp_now = Helper::limitDataHourlyNow($date_temp_now);
            $result_weacode_now = Helper::limitDataHourlyNow($data_weacode_now);

            //Retrieve Data From Database
            $city = $this->cityRepository->findById($request->id);
            if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
                View::render(
                    'Home/dadus_klima',
                    [
                        "title" => "Dadus Klima",
                        "daily_time" => $result_time,
                        "temp_daily" => $result_temp,
                        "weather_code_daily" => $result_weacode,
                        "time_hourly" => $result_hourly_time,
                        "temp_hourly" => $result_hourly_temp,
                        "weacode_hourly" => $result_hourly_weacode,
                        "city" => ucfirst($city->id),
                        "country" => $city->country,
                        "temp_now" => $result_temp_now,
                        "weacode_now" => $result_weacode_now
                    ]
                );
            } else {

                View::render(
                    'Home/dadus_klima',
                    [
                        "title" => "Dadus Klima",
                        "daily_time" => $result_time,
                        "temp_daily" => $result_temp,
                        "weather_code_daily" => $result_weacode,
                        "time_hourly" => $result_hourly_time,
                        "temp_hourly" => $result_hourly_temp,
                        "weacode_hourly" => $result_hourly_weacode,
                        "city" => ucfirst($city->id),
                        "country" => $city->country,
                        "temp_now" => $result_temp_now,
                        "weacode_now" => $result_weacode_now
                    ]
                );
            }
        } catch (ValidationException $exception) {
            View::render(
                'Home/dadus_klima',
                [
                    "title" => "Dadus Klima",
                    "error" => $exception->getMessage()
                ]
            );
        }
    }

    function mapa()
    {
        try {
            //Retrieve Data From Database
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
                $result_weacode = Helper::limitDataHourlyNow($data_weacode);
                $data_temp = $data['hourly']['temperature_2m'];
                $result_temp = Helper::limitDataHourlyNow($data_temp);


                foreach ($result_weacode as $key => $value) {
                    $final_result_weacode[] = $value;
                }


                foreach ($result_temp as $key => $value1) {
                    $final_result_temp[] = $value1;
                }
            }

            View::render(
                'Home/mapa',
                [
                    "title" => "Mapa",
                    "city" => $kota,
                    "lat" => $lat,
                    "long" => $long,
                    "country" => $country,
                    "weacode" => $final_result_weacode,
                    "temp" => $final_result_temp
                ]
            );
        } catch (ValidationException $exception) {
            View::render(
                'Home/mapa',
                [
                    "title" => "Mapa",
                    "error" => $exception->getMessage()
                ]
            );
        }
    }

    function konaba()
    {
        View::render(
            'Home/konaba',
            ["title" => "Konaba-Web"]
        );
    }



    function liveSearch()
    {

        $request = $_POST['search'];
        $result = $this->cityRepository->findSearchId($request);

        if ($result) {

            foreach ($result as $row => $value) {
                echo "<b><a id='d' href='#' class='list-group list-group-item-action mt-2' style='margin-left: 10px;'>" . ucfirst($value->getId()) . "</a></b>";
            }
        } else {
            echo '<p classs = "list-group list-group-item" style="margin-left: 10px; margin-top:10px;">Munisipiu laiha boy&#128517;</p>';
        }
    }
}
