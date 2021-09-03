@extends('layouts.app')
@section('body')
     <link rel="stylesheet" href="./css/main/dashboard.css">
     <nav id="navbar" class="fixed-top">
ì            <ul class="nav justify-content-center mt-2" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active "  href="#home">{{ $user->name }}</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link"  href="/signIn" role="tab">Impostazioni</a>
                </li>
            </ul>
</nav>
    <div class="container-fluid h-100">
        <div class="row h-100 align-items-center justify-content-center">
        <div class="col-md-6 "><tobacco-shops :tobacco_shops="{{ json_encode($user->tobaccoShops)}}"></tobacco-shops></div>
        <div class="col-md-6 "><employees :tobacco_shops="{{json_encode($user->employeeToTobaccoShops) }}"></employees></div>
        </div>
    </div>
@endsection