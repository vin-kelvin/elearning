<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'learn') }}</title> 
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!--<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">-->


</head>
<body>
    @include('inc.navbar')
    @include('inc.faq')
    

<div class="p-4 p-md-8 mb-8 "> 
    <div class="container">
        <div class="col-md-2 col-lg-12 ">

            @if (Request:: is('/') )
            @include('inc.karibu_page') 
            @endif
          
            @include('inc.faq')

            @yield('content')
           
        </div>
            
    </div>

</div>


    
</body>
</html>

