<?php
date_default_timezone_set("Asia/Dili");
$timestamp = time(); // atau dapatkan timestamp dari sumber waktu lainnya
$dateTime = new DateTime("@$timestamp");
$iso8601 = $dateTime->format('c');

$current_time = $iso8601;

// Mengonversi waktu saat ini ke timestamp
$timestamp = strtotime($current_time);

// Membulatkan ke jam berikutnya
$rounded_time = date('Y-m-d\TH:00', ceil($timestamp / 3600) * 3600);


$json_data = '{
    "hourly": {
        "time": [
            "2023-11-29T00:00",
            "2023-11-29T01:00",
            "2023-11-29T02:00",
            "2023-11-29T03:00",
            "2023-11-29T04:00",
            "2023-11-29T05:00",
            "2023-11-29T06:00",
            "2023-11-29T07:00",
            "2023-11-29T08:00",
            "2023-11-29T09:00",
            "2023-11-29T10:00",
            "2023-11-29T11:00",
            "2023-11-29T12:00",
            "2023-11-29T13:00",
            "2023-11-29T14:00",
            "2023-11-29T15:00",
            "2023-11-29T16:00",
            "2023-11-29T17:00",
            "2023-11-29T18:00",
            "2023-11-29T19:00",
            "2023-11-29T20:00",
            "2023-11-29T21:00",
            "2023-11-29T22:00",
            "2023-11-29T23:00",
            "2023-11-30T00:00"
        ]
    }
}';


// Mengonversi string JSON menjadi array
$json_array = json_decode($json_data, true);

// Mencari waktu saat ini dalam data JSON
$index = array_search($rounded_time, $json_array['hourly']['time']);

$five_hours_data = array_slice($json_array['hourly']['time'], $index, 5);

// Menampilkan hasil
var_dump($five_hours_data);
