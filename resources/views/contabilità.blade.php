@extends('layouts.app')
@section('body')
     <link rel="stylesheet" href="/css/main/contabilita.css">
     <index :tobacco_shop="{{ $tobaccoShop }}" :user_logged="{{ $user }}"></index>
@endsection