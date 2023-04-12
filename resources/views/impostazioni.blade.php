@extends('layouts.app')
@section('body')
<link href="/css/app.css" rel="stylesheet">

<link rel="stylesheet" href="./css/main/impostazioni.css">
<nav id="navbar" class="fixed-top">
    <ul class="nav justify-content-center mt-2" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active " href="/dashboard">{{ $user->name }}</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="/impostazioni" role="tab">Impostazioni</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="/user/logout" role="tab">Esci</a>
        </li>
    </ul>
</nav>
<div class="container-fluid h-100">
    <div class="row h-100 align-items-center justify-content-center">
        <div class="col-md-12 ">
            <impostazioni :user="{{ json_encode($user)}}"></impostazioni>
        </div>
    </div>
</div>
@endsection