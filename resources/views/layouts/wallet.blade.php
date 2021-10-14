<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/all.min.css') }}">
</head>
<body class="theme-cyan loaded">
    <div id="app">

        <div class="wallet-area">
            <div class="wallet-area-warpper">
               <div id="loader-wrapper">
                  <div id="loader"></div>
                  <div class="loader-images"><img src="https://theme.bitrixinfotech.com/crypto-wallet/assets/images/loader.svg" alt="Loader"></div>
               </div>
               <div class="row">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                     <div class="header-box">
                        <div class="header-logo">
                           <h3 style="font-size: 20px; color: #eff6ff;">Virtual Money</h3>
                        </div>
                        <div class="header-nav-menu">
                           <i class="menu-responsive fas fa-bars"></i>
                           <ul>
                              <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="/dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                              <li class="{{ (request()->is('wallet')) ? 'active' : '' }}"><a href="/wallet"><i class="fas fa-wallet"></i> My Wallet</a></li>
                              <li class="{{ (request()->is('transfer')) ? 'active' : '' }}"><a href="/transfer"><i class="fas fa-coins"></i> Transfer Money</a></li>
                              <li class="{{ (request()->is('transactions')) ? 'active' : '' }}"><a href="/transactions"><i class="fas fa-history"></i> Transactions</a></li>
                              <li><a href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                           </ul>
                        </div>
                     </div>
                     <div class="wallet-area-right">
                        <div class="wallet-top-header clearfix">
                           <div class="wallet-top-header-right">
                              <div class="wallet-top-header-box user-top-detail">
                                 <span>Welcome Back</span>
                                 <h3>{{Auth::user()->name}}</h3>
                              </div>
                           </div>
                        </div>
                            <main>
                                @yield('content')
                            </main>
                     </div>
                  </div>
               </div>
            </div>
         </div>
    </div>
</body>
</html>
