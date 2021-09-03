
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>

     <link href="/css/app.css" rel="stylesheet">
     <link rel="stylesheet" href="/css/home/login.css">
     <link rel="stylesheet" href="/css/home/signin.css">
     <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">


    </head>
    <body >
    <div id="app">
    <div id="myTabContent" class="tab-content w-100 h-100">
    <section>
        <reset_password email="{{ $request->email }}" token="{{ $request->token }}"></reset_password>
    </section>
</div>
    </div>


    <script src="/js/app.js"></script>

    </body>
</html>
