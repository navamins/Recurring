<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- logo on tab -->
    <link rel="icon" href="{{ asset('pic/icon-logobank-gsb.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--  <title>{{ config('app.name', 'Laravel') }}</title>  --}}
    <title>Recurring</title>

    <!-- Styles -->
    {{--  <link href="{{ asset('css/app.css') }}" rel="stylesheet">  --}}
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('bootstrap-4.0.0/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('bootstrap-4.0.0/docs/4.0/examples/navbars/navbar.css') }}" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ asset('bootstrap-4.0.0/docs/4.0/examples/sticky-footer-navbar/sticky-footer-navbar.css') }}" rel="stylesheet">
    <!-- Icons Awesome CSS -->
    <link href="{{ asset('fontawesome-free-5.0.8/web-fonts-with-css/css/fontawesome-all.css') }}" rel="stylesheet">

    <style type="text/css">
        @font-face {
            font-family:PromptRegular; src: url('{{ asset('fonts/Prompt/Prompt-Regular.ttf') }}');
        }
        @font-face {
            font-family:PromptMedium; src: url('{{ asset('fonts/Prompt/Prompt-Medium.ttf') }}');
        }
        @font-face {
            font-family:PromptBold; src: url('{{ asset('fonts/Prompt/Prompt-Bold.ttf') }}');
        }

        .PromptRegular16 {
        font-family: PromptRegular, sans-serif;
        font-size:      16px;
        }
        .PromptMedium16 {
        font-family: PromptMedium, sans-serif;
        font-size:      16px;
        }
        .PromptRegular18 {
            font-family: PromptRegular, sans-serif;
            font-size:      18px;
        }
        .PromptRegular20 {
        font-family: PromptRegular, sans-serif;
        font-size:      20px;
        }
        .PromptMedium52 {
        font-family: PromptMedium, sans-serif;
        font-size:      52px;
        }
        .navbar-dark .navbar-nav .active > .nav-link, .navbar-dark .navbar-nav .nav-link, .navbar-dark .navbar-nav .nav-link.show, .navbar-dark .navbar-nav .show > .nav-link {
            color: #fff;
        }
        .navbar-dark .navbar-nav .nav-link:focus, .navbar-dark .navbar-nav .nav-link:hover {
            color: #CB1580;
        }
        
    </style>

    <!-- push target to head -->
    @stack('styles')

</head>
<body style="background-color: #E9ECEF !important">
    <div id="app">
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #EC068D;">
            <div class="container">
                    <a class="navbar-brand PromptRegular18" href="/">
                        <img src="{{ asset('pic/2741_Logo GSB.jpg') }}" width="30" height="auto" class="d-inline-block align-top" alt="Recurring for Creditcard"> 
                        ระบบชำระค่าสาธารณูปโภค
                    </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link PromptRegular16" href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</a></li>
                            <li><a class="nav-link PromptRegular16" href="{{ route('register') }}"><i class="far fa-registered"></i> ลงทะเบียนเข้าใช้งาน</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle PromptRegular16" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} {{ Auth::user()->lastname }}<span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    {{--  ดูข้อมูลส่วนตัว  --}}
                                    <a class="dropdown-item PromptRegular16" href="{{ route('owner.profile') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('profile').submit();">
                                        {{ __('ข้อมูลส่วนตัว') }}
                                    </a>

                                    <form id="profile" action="{{ route('owner.profile') }}" method="GET" style="display: none;">
                                        @csrf
                                        {{--  <input type='hidden' id='myaccount' name="myaccount" value="{{ Auth::user()->id }}">  --}}
                                    </form>
                                    {{--  ออกจากระบบ  --}}
                                    <a class="dropdown-item PromptRegular16" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('ออกจากระบบ') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        {{--  <main class="py-4">  --}}
        @guest
        @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #F59BB7;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarNavDropdown">
                            <ul class="navbar-nav">
                                @if(Auth::user()->role !='admin')               
                                <li class="nav-item active">
                                    <a class="nav-link PromptRegular16" href="/home"><i class="fas fa-home"></i> หน้าหลัก <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link PromptRegular16" href="{{ route('register.index') }}"><i class="far fa-registered"></i> ลงทะเบียนชำระค่าสาธารณูปโภค </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link PromptRegular16" href="{{ route('customer.search') }}"><i class="fas fa-search"></i> ค้นหาข้อมูลลูกค้า </a>
                                </li> 
                                @else
                                <li class="nav-item active">
                                    <a class="nav-link PromptRegular16" href="/home"><i class="fas fa-home"></i> หน้าหลัก <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link PromptRegular16" href="{{ route('register.index') }}"><i class="far fa-registered"></i> ลงทะเบียนชำระค่าสาธารณูปโภค </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link PromptRegular16" href="{{ route('customer.search') }}"><i class="fas fa-search"></i> ค้นหาข้อมูลลูกค้า </a>
                                </li> 
                                {{--  <li class="nav-item">
                                    <a class="nav-link PromptRegular16" href="#">ข้อมูลลูกค้า</a>
                                </li>  --}}
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle PromptRegular16" href="#" id="management" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-database"></i> การจัดการข้อมูล
                                    </a>
                                    <div class="dropdown-menu PromptRegular16" aria-labelledby="management">
                                        <a class="dropdown-item PromptRegular16" href="{{ route('agency.index') }}"><i class="fas fa-building"></i> ข้อมูลหน่วยงานพันธมิตร </a>
                                        <a class="dropdown-item PromptRegular16" href="{{ route('user.index') }}"><i class="fas fa-users"></i> ข้อมูลผู้ใช้งานระบบ </a>
                                        <a class="dropdown-item PromptRegular16" href="{{ route('bank.index') }}"><i class="fas fa-university"></i> ข้อมูลธนาคารออมสิน </a>
                                        {{-- <a class="dropdown-item PromptRegular16" href="{{ route('edc.index') }}"><i class="fas fa-terminal"></i> ข้อมูลเครื่อง EDC </a> --}}
                                        <a class="dropdown-item PromptRegular16" href="{{ route('cardtype.index') }}"><i class="far fa-credit-card"></i> รายการข้อมูลบัตรเครดิต </a>
                                        <hr>
                                        <a class="dropdown-item PromptRegular16" href="{{ route('customer.form_import_cardlink') }}"><i class="fas fa-upload"></i> อัพเดทข้อมูลจาก Cardlink </a>
                                    </div>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </nav> 
                </div>
            </div>
        </div>
        @endguest
        
        @yield('content')
        {{--  </main>  --}}
    </div>

    <footer class="footer"> 
        <div class="container">
            <span class="PromptRegular16">Copyright © 2018 by Mr. Navamin Sawasdee</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
   
    <!-- push target to Scripts JS -->
    @stack('scripts')
    
</body>
</html>
