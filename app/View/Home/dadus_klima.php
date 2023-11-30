   <?php

    use Frederico\Weather\App\Helper\Helper;

    ?>

   <div id="content-prinsipal" class="container">
       <div class="container h-100 py-5 mt-5">

           <div class="row d-flex justify-content-center align-items-center h-100">
               <div class="col-md-8 col-lg-6 col-xl-4">

                   <h3 class="mb-4 pb-2 fw-normal text-center">Cek Klima Munisipiu</h3>

                   <form id="weatherForm" method="get" action="/dadus_klima/buka">
                       <div class="input-group rounded mb-0">
                           <input id="search" name="city" type="search" class="form-control rounded" placeholder="Munisipiu" aria-label="Search" aria-describedby="search-addon" value="<?= $_GET['city'] ?? 'Dili' ?>" />
                           <button id="btn_search" class=" input-group-text border-2 fw-bold" type="submit">Cek</button>
                       </div>

                   </form>

                   <div class="card-body border mb-3 rounded">
                       <div class="list-group list-group-item-action" id="content">

                       </div>
                   </div>


                   <?php if (!isset($model['error'])) { ?>

                       <div class="card shadow-0 border">
                           <div class="card-body p-3">

                               <h4 class="mb-1 sfw-normal text-center"><?= $model['city'] . ", " . $model['country'] ?></h4>
                               <p class="mb-2 text-center">Temperatura Agora: <strong><?= $model['temp_now'][0] ?> °C</strong></p>
                               <!-- <p>Feels like: <strong>4.37°C</strong></p> -->
                               <!-- <p>Max: <strong>6.11°C</strong>, Min: <strong>3.89°C</strong></p> -->

                               <p class="mb-0 text-center"><?= Helper::weatherCodeDesc($model['weacode_now'][0]) ?></p>
                               <i class="fas fa-cloud fa-3x" style="color: #eee;"></i>
                               <center><img style="width: 30%;" src="/assets/img/weathercode/<?= Helper::weatherCodeImg($model['weacode_now'][0]) ?>.png" alt="<?= Helper::weatherCodeImg($model['weacode_now'][0]) ?>">
                               </center>
                           </div>
                       </div>

               </div>
           </div>
       </div>


       <h3 class="text-center mb-2 fw-normal">Predisaun Klima oras tuirmai</h3>
       <div class="container h-100 py-3" style="width: 100%;">

           <div class="row d-flex justify-content-center align-items-center h-100" style="color: #282828;">
               <div class="col-md-9 col-lg-7 col-xl-5">

                   <div class="card mb-4" style="border-radius: 25px;">
                       <div class="card-body p-4">

                           <div id="demo2" class="carousel slide" data-ride="carousel">
                               <!-- Carousel inner -->
                               <div class="carousel-inner">
                                   <div class="carousel-item active">
                                       <div class="d-flex justify-content-around text-center mb-2 pb-1 pt-2">

                                           <?php
                                            foreach ($model['time_hourly'] as $index => $time_hourly) {
                                            ?>
                                               <div class="flex-column">
                                                   <p class="small"><strong><?= $model['temp_hourly'][$index] ?> °C</strong></p>
                                                   <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i>
                                                   <img style="width: 70%;" src="/assets/img/weathercode/<?= Helper::weatherCodeImg($model['weacode_hourly'][$index]) ?>.png" alt="<?= Helper::weatherCodeImg($model['weacode_hourly'][$index]) ?>">
                                                   <p class="mb-0"><strong><?= date('G:i', strtotime($time_hourly)) ?></strong></p>
                                                   <p class="mb-0 text-muted" style="font-size: .65rem;">OTL</p>
                                               </div>
                                           <?php } ?>
                                       </div>
                                   </div>
                               </div>
                           </div>

                       </div>
                   </div>



                   <h3 class="mb-4 pb-2 fw-normal text-center">Predisaun Klima loron tuirmai</h3>

                   <div class="card mb-5" style="border-radius: 25px;">
                       <div class="card-body p-4">

                           <div id="demo3" class="carousel slide" data-ride="carousel">
                               <!-- Carousel inner -->
                               <div class="carousel-inner">
                                   <div class="carousel-item active">
                                       <div class="d-flex justify-content-around text-center mb-0 pb-3 pt-2">

                                           <?php
                                            foreach ($model['daily_time'] as $index => $time) {
                                            ?>
                                               <div class="flex-column">
                                                   <p class="small"><strong><?= date('d/m', strtotime($time)) ?></strong></p>
                                                   <i class="fas fa-sun fa-2x mb-3" style="color: #ddd;"></i>
                                                   <img style="width: 70%;" src="/assets/img/weathercode/<?= Helper::weatherCodeImg($model['weather_code_daily'][$index]) ?>.png" alt="<?= Helper::weatherCodeImg($model['weather_code_daily'][$index]) ?>">
                                                   <p class="mb-0"><strong><?= $model['temp_daily'][$index] ?> °C</strong></p>
                                               </div>
                                           <?php } ?>
                                       </div>
                                   </div>
                               </div>
                           </div>

                       </div>
                   </div>

               </div>
           </div>

       <?php } else { ?>

           <div class="container text-center" style="min-height: 60vh;">
               <h1 class="mt-5"><?= $model['error'] ?></h1>
           </div>

       <?php } ?>
       </div>

   </div>




   <script src="/assets/js/autocomplete.js"></script>