<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>

     <link href="/css/app.css" rel="stylesheet">
     <link rel="stylesheet" href="./css/home/login.css">
     <link rel="stylesheet" href="./css/home/signin.css">
     <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">


    </head>
    <body >
    <div id="app">

        <nav id="navbar" class="fixed-top">
            <ul class="nav justify-content-center mt-2" id="myTab" role="tablist">
             <li class="nav-item" role="presentation">
                    <a class="nav-link active " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link"  id="home-tab" data-toggle="tab" href="#signIn" role="tab" aria-controls="signIn" aria-selected="false">Login</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link"  id="signUp-tab" data-toggle="tab" href="#signUp" role="tab" aria-controls="signUp"  aria-selected="false">SignUp</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="aboutUs-tab" data-toggle="tab" href="#aboutUs" role="tab" aria-controls="aboutUs" aria-selected="false">About Us</a>
                </li>
            </ul>
</nav>
<div id="myTabContent" class="tab-content w-100 h-100">

    <section class="tab-pane container-fluid row mx-auto fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active" data-interval="10000">
      <img src="/imgs/home/carousel1.jpg" class="d-block" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5><span class="text_carousel"> Necessita solo di un computere </span></h5>
      </div>
    </div>
    <div class="carousel-item" data-interval="10000">
      <img src="/imgs/home/carousel2.jpg" class="d-block" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <h5><span  class="text_carousel"> Puoi tenere d'occhio le vendite mensili</span></h5>
      </div>
    </div>
    <div class="carousel-item" data-interval="10000">
      <img src="/imgs/home/carousel3.jpg" class="d-block" alt="...">
      <div class="carousel-caption d-none d-md-block ">
        <h5><span  class="text_carousel"> Contabilizza Gratis </span></h5>
      </div>
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

    
    <div class=" col-12 flex-grow-1  px-0 align-items-center  d-flex flex-column justify-content-center" id="title_home">
            <h1>Gestionale GV</h1>
             <p>Un programma che ti aiuta a verificare quanti gratta e vinci vendi in maniera gratuita</p>
        </div>
        </section>
    <section class="fade show tab-pane"  id="signIn" role="tabpanel" aria-labelledby="signIn-tab">
        <login ></login>
    </section>
    <section class="fade show tab-pane"  id="signUp" role="tabpanel" aria-labelledby="signUp-tab">
        <signin></signin>
    </section>
</div>
    </div>


    <script src="/js/app.js"></script>

    </body>
</html>
