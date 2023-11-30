<style>
    /*--------------------------------------------------------------
# Sections Himawari
--------------------------------------------------------------*/
    .himawari img {
        width: 50%;
    }

    @media (max-width: 576px) {
        .himawari img {
            width: 95%;
        }
    }

    @media (max-width: 992px) {
        .himawari img {
            width: 80%;
        }
    }

    @media (max-width: 768px) {
        .himawari img {
            width: 90%;
        }
    }

    #mapa {
        height: 500px;
        width: 100%;
    }

    /* Gaya untuk ikon dan teks */
    .custom-icon {
        text-align: center;
    }

    .icon-wrapper {
        position: relative;
    }

    .icon-img {
        width: 100%;
        height: auto;
    }

    .icon-text {
        position: absolute;
        bottom: 5px;
        /* Jarak teks dari bawah ikon */
        width: 100%;
        font-size: 12px;
        color: #ffff;
        /* Warna teks */
    }
</style>


<div class="container mt-5">
    <h3 class="pb-2 fw-normal text-center pt-5 mt-5 mb-3">Imajen Real-Time Satelite Himawari</h3>
</div>


<div class="himawari">
    <img class="mx-auto d-block mb-4" src="https://inderaja.bmkg.go.id/IMAGE/HIMA/H08_EH_Indonesia.png?id=37721b4qfi3cfhhemy744ug" title="Himawari-9 IR Enhanced - Indonesia" alt="">
    <a class="mb-5" style="text-align: center;
            display: block;
            text-decoration: none;" href="https://himawari8.nict.go.jp/">Asessu Satelite</a>
</div>
<h3 class="pb-2 fw-normal text-center ">Mapa Klima Agora</h3>
<div class="container">
    <div class="card my-5">
        <div class="card-header">
            Mapa
        </div>
        <div class="card-body">
            <div class="container" id="mapa">

                <script>
                    var map = L.map('mapa').setView([-8.733077, 126.013184], 13);
                    var tiles = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                        maxZoom: 9,
                        attribution: '<a>Developed by DEI 2022</a>',
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1
                    }).addTo(map);

                    <?php

                    use Frederico\Weather\App\Helper\Helper;

                    foreach ($model['lat'] as $index => $lat) { ?>
                        var weatherCode = <?php echo $model['weacode'][$index]; ?>;
                        var iconUrl = getIconUrl(weatherCode);

                        var customIcon = new L.divIcon({
                            className: 'custom-icon', // Nama kelas CSS untuk mengatur gaya ikon
                            html: '<div class="icon-wrapper"><img src="' + iconUrl + '" class="icon-img"/><div class="icon-text"><?= ucfirst($model['city'][$index]) ?></div></div>',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [90, 90],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });

                        var marker = L.marker([<?php echo $lat; ?>, <?php echo $model['long'][$index]; ?>], {
                            icon: customIcon
                        }).addTo(map).bindPopup('<b><center><?php echo ucfirst($model['city'][$index]); ?></center><br><center><h3><?= $model['temp'][$index] ?> °C</h3></center></b><center><p><?= Helper::weatherCodeDesc($model['weacode'][$index]) ?></p></center>');
                    <?php } ?>

                    function getIconUrl(weatherCode) {
                        switch (weatherCode) {

                            case 0:
                                return "/assets/img/weathercode/clearsky.png";
                            case 1:
                            case 2:
                            case 3:
                                return "/assets/img/weathercode/fewclouds.png";
                            case 45:
                            case 48:
                                return "/assets/img/weathercode/scatteredclouds.png";
                            case 51:
                            case 53:
                            case 55:
                                return "/assets/img/weathercode/rain.png";
                            case 56:
                            case 57:
                                return "/assets/img/weathercode/rain.png";
                            case 61:
                            case 63:
                            case 65:
                                return "/assets/img/weathercode/showerrain.png";
                            case 66:
                            case 67:
                                return "/assets/img/weathercode/showerrain.png";
                            case 71:
                            case 73:
                            case 75:
                                return "/assets/img/weathercode/snow.png";
                            case 77:
                                return "/assets/img/weathercode/snow.png";
                            case 80:
                            case 81:
                            case 82:
                                return "/assets/img/weathercode/showerrain.png";
                            case 85:
                            case 86:
                                return "/assets/img/weathercode/snow.png";
                            case 95:
                                return "/assets/img/weathercode/thunderstorm.png";
                            case 96:
                            case 99:
                                return "/assets/img/weathercode/thunderstorm.png";
                            default:
                                return "Unknown weather code";
                        }
                    }
                </script>




            </div>
        </div>
    </div>
</div>