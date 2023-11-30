<?php

namespace Frederico\Weather\App\Helper;

use DateTime;

class Helper
{
    public static function weatherCodeImg($weathercode): string
    {
        switch ($weathercode) {
            case 0:
                return "clearsky";
            case 1:
            case 2:
            case 3:
                return "fewclouds";
            case 45:
            case 48:
                return "scatteredclouds";
            case 51:
            case 53:
            case 55:
                return "rain";
            case 56:
            case 57:
                return "rain";
            case 61:
            case 63:
            case 65:
                return "showerrain";
            case 66:
            case 67:
                return "showerrain";
            case 71:
            case 73:
            case 75:
                return "snow";
            case 77:
                return "snow";
            case 80:
            case 81:
            case 82:
                return "showerrain";
            case 85:
            case 86:
                return "snow";
            case 95:
                return "thunderstorm";
            case 96:
            case 99:
                return "thunderstorm";
            default:
                return "Unknown weather code";
        }
    }


    public static function weatherCodeDesc($code): string
    {
        switch ($code) {
            case 0:
                return "Lalehan Naroman";
            case 1:
            case 2:
            case 3:
                return  "Naroman Naton, Kalohan, Kalohan nakukun uitoan";
            case 45:
            case 48:
                return  "Abu-Abu taka";
            case 51:
            case 53:
            case 55:
                return "Udan Piska: Kamaan, Moderada, Intensidade aas";
            case 56:
            case 57:
                return "Udan Piska Malirin: Kamaan, Moderada, Intensidade aas";
            case 61:
            case 63:
            case 65:
                return "Udan: Kamaan, Moderada, Intensidade aas";
            case 66:
            case 67:
                return "Udan Malirin: Kamaan, Moderada, Intensidade aas";
            case 71:
            case 73:
            case 75:
                return  "Neve: Kamaan, Moderada, Intensidade aas";
            case 77:
                return  "Neve Piska";
            case 80:
            case 81:
            case 82:
                return  "Udan maka'as: Kamaan, Moderada, Maka'as";
            case 85:
            case 86:
                return  "Udan Neve: Kamaan, Maka'as";
            case 95:
                return  "Railakan: kamaan, maka'as";
            case 96:
            case 99:
                return "Railakan ho Udan Es: Kama'an no Maka'as";
            default:
                return  "Klima La deskreve";
        }
    }

    public static function limit5DataJSON(array $data): array
    {
        $limitData = array_slice($data, 0, 5);
        return $limitData;
    }

    public static function limit5DataHourly(array $data_json): ?array
    {
        date_default_timezone_set("Asia/Dili");
        $timestamp = time(); // atau dapatkan timestamp dari sumber waktu lainnya
        $dateTime = new DateTime("@$timestamp");
        $iso8601 = $dateTime->format('c');

        $current_time = $iso8601;

        // Mengonversi waktu saat ini ke timestamp
        $timestamp = strtotime($current_time);

        // Membulatkan ke jam berikutnya
        $rounded_time = date('Y-m-d\TH:00', ceil($timestamp / 3600) * 3600);

        // Mencari waktu saat ini dalam data JSON
        $index = array_search($rounded_time, $data_json);

        $five_hours_data = array_slice($data_json, $index, 5);

        return $five_hours_data;
    }

    public static function limitDataHourlyNow(array $data_json): ?array
    {
        date_default_timezone_set("Asia/Dili");
        $timestamp = time(); // atau dapatkan timestamp dari sumber waktu lainnya
        $dateTime = new DateTime("@$timestamp");
        $iso8601 = $dateTime->format('c');

        $current_time = $iso8601;

        // Mengonversi waktu saat ini ke timestamp
        $timestamp = strtotime($current_time);

        // Membulatkan ke jam berikutnya
        $rounded_time = date('Y-m-d\TH:00', ceil($timestamp / 3600) * 3600);

        // Mencari waktu saat ini dalam data JSON
        $index = array_search($rounded_time, $data_json);

        $now_hours_data = array_slice($data_json, $index - 1, 1);

        return $now_hours_data;
    }


    public static function limitDataHourlyNowMap(array $data_json): ?array
    {
        date_default_timezone_set("Asia/Dili");
        $timestamp = time(); // atau dapatkan timestamp dari sumber waktu lainnya
        $dateTime = new DateTime("@$timestamp");
        $iso8601 = $dateTime->format('c');

        $current_time = $iso8601;

        // Mengonversi waktu saat ini ke timestamp
        $timestamp = strtotime($current_time);

        // Membulatkan ke jam berikutnya
        $rounded_time = date('Y-m-d\TH:00', ceil($timestamp / 3600) * 3600);

        // Mencari waktu saat ini dalam data JSON
        $index = array_search($rounded_time, $data_json);

        $now_hours_data = array_slice($data_json, $index - 1, 1, true);
        // Mengatur kembali kunci-kunci array
        $now_hours_data = array_values($now_hours_data);

        return $now_hours_data;
    }
}
