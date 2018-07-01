<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- logo on tab -->
        <link rel="icon" href="{{ asset('pic/icon-logobank-gsb.png') }}">

        <title>Recurring</title>

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
            .PromptRegular18 {
            font-family: PromptRegular, sans-serif;
            font-size:      18px;
            }
            .PromptMedium52 {
            font-family: PromptMedium, sans-serif;
            font-size:      52px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            {{--  @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif  --}}
            <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #EC068D;">
                <div class="container">
                    <a class="navbar-brand PromptRegular18" href="#">
                        <img src="{{ asset('pic/2741_Logo GSB.jpg') }}" width="30" height="auto" class="d-inline-block align-top" alt="Recurring for Creditcard"> 
                        ระบบชำระค่าสาธารณูปโภค
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <div class="collapse navbar-collapse" id="navbarsExample07">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            {{--  <li class="nav-item active">
                            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                            </li>
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                            <div class="dropdown-menu" aria-labelledby="dropdown07">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                            </li>  --}}
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
    
                                        <form id="profile" action="{{ route('owner.profile') }}" method="POST" style="display: none;">
                                            @csrf
                                            <input type='hidden' id='myaccount' name="myaccount" value="{{ Auth::user()->id }}">
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

            <div class="container">
                <main role="main">
                  <div class="jumbotron">
                    <div class="col-sm-8 mx-auto">
                      <h1 class="PromptMedium52">ระบบชำระค่าสาธารณูปโภค</h1>
                      <p class="PromptRegular16">ด้วยธนาคารออมสินได้เปิดบริการรับชำระค่าไฟฟ้า ผ่านบัตรเครดิตธนาคารออมสินดังนี้</p>
                      <span class="PromptRegular16">1. บัตรเครดิตธนาคารออมสิน พรีเมี่ยม (GSB Premium Credit Card)</span>
                      <br>
                      <span class="PromptRegular16">2. บัตรเครดิตธนาคารออมสิน พรีเชียส (GSB Precious Credit Card)</span>
                      <br>
                      <span class="PromptRegular16">3. บัตรเครดิตธนาคารออมสิน เพรสทีจ (GSB Prestige Credit Card)</span>
                      <br><br>
                      <span class="PromptRegular16">โดยให้ลูกค้าทำการสมัครใช้บริการผ่านช่องทาง Call Center โทร. 0 2299 9999</span>
                      <p class="PromptRegular16">ทุกวัน ตลอด 24 ชั่วโมง</p>
                       @if (Route::has('login'))
                       <p>
                            @auth
                                <a class="btn btn-primary PromptRegular16" href="{{ url('/home') }}" role="button">หน้าหลัก &raquo;</a>
                            @else
                                <a class="btn btn-primary PromptRegular16" href="{{ route('login') }}" role="button"><i class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ &raquo;</a>
                                <a class="btn btn-primary PromptRegular16" href="{{ route('register') }}" role="button"><i class="far fa-registered"></i> ลงทะเบียนเข้าใช้งาน &raquo;</a>
                            @endauth
                        </p>
                       @endif
                    </div>
                  </div>
                </main>
              </div>
        </div>
        
        <footer class="footer"> 
            <div class="container">
                <span class="PromptRegular16">Copyright © 2018 by Mr. Navamin Sawasdee</span>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        {{--  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>  --}}
        <script>window.jQuery || document.write('<script src="{{ asset('bootstrap-4.0.0/assets/js/vendor/jquery-slim.min.js') }}"><\/script>')</script>
        <script src="{{ asset('bootstrap-4.0.0/assets/js/vendor/popper.min.js') }}"></script>
        <script src="{{ asset('bootstrap-4.0.0/dist/js/bootstrap.min.js') }}"></script>
    </body>
</html>
