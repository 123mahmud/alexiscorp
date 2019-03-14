<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{asset('assets/img/games.ico')}}">

    <title>Alexis</title>

    <link rel="stylesheet" type="text/css" href="{{asset('assets/login-mirip-discrottt/css/alamraya-style.css')}}">

</head>
<body>
    <div class="background-loading">
      {{-- ..Loading.. --}}
      <div id="loader"></div>
    </div>

    <div id="particles-with-parallax"  data-friction-x="0.1" data-friction-y="0.1" data-scalar-x="25" data-scalar-y="15">
            <div id="particles-js" class="layer" data-depth="0.40"></div>

            <div data-depth="0.80" class="layer forest-1"></div>

            <div data-depth="0.70" class="layer forest-2"></div>

            <div data-depth="0.60" class="layer forest-3"></div>

            <div data-depth="0.50" class="layer forest-4"></div>

            <div data-depth="0.40" class="layer forest-5"></div>

            <div data-depth="0.30" class="layer mountain-1"></div>

            <div data-depth="0.20" class="layer mountain-2"></div>

            <div data-depth="0.10" class="layer sky"></div>


        
    </div>


        <div class="container">
            <div class="ar-card">
                <div class="ar-card-header">
                    <img src="{{asset('assets/img/games.ico')}}" width="100px" height="100px" class="ar-card-logo">
                    <div class="ar-card-header-h3">
                        CV. Alexis
                    </div>
                    <div class="ar-card-header-h2">
                        Login
                    </div>
                </div>
                <div class="ar-card-body">
                    <form method="POST" action="{{ url('login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <h5 class="form-label">Username</h5>
                            <input type="text" class="form-control" name="email" id="email">
                            @if ($errors->has('email'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <h5 class="form-label">Password</h5>
                            <input type="password" class="form-control" name="password" id="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <label for="remember" class="text-primary ">
                            <input class="checkbox" id="remember" name="remember" type="checkbox">
                            <span>Remember me</span>
                        </label>
                        <a class="anchor-link pull-right" href="javascript:void(0);">Forgot your password?</a>
                        <button class="btn w-100 bg-primary" type="submit">Login</button>
                        <label>
                            <span class="span-underbutton">Need an account?</span>
                            <a class="anchor-link" href="javascript:void(0);">Register</a>
                        </label>
                    </form>
                </div>
            </div>
        </div>

    <footer>
        <span>Created by Ari Akbar Ind. 2019 Made with Ɛ>.</span>
    </footer>
    <script src="{{asset('assets/login-mirip-discrottt/js/jquery/jquery-3.3.1.js')}}"></script>
    <script src="{{asset('assets/login-mirip-discrottt/js/parallax-mousehover/parallax.js')}}"></script>

<script type="text/javascript">
  $(window).ready(function(){

    setTimeout(function(){
      $('.content').addClass('animated fadeInLeft');

      $('.background-loading').fadeOut('slow');
    },1000);
  });
</script>

<script type="text/javascript">

    $(document).ready(function(){
        // setTimeout(function(){


            $(window).resize(function(){

                console.log('resize');

                parallax_func();


            });

            parallax_func();

            function parallax_func(){
                if($(window).width() > 700){

                    var particles_js = document.getElementById('particles-with-parallax');

                    var parallax = new Parallax(particles_js, {
                        limitX:50,
                        limitY:50,
                        relativeInput:true,
                        pointerEvents:true
                    });
                } else {
                    parallax.destroy();
                }
            }
        // },500);
    });

    // Collapse Navbar
    var navbarCollapse = function() {
        var scrollHeight = $(document).height();
        var scrollPosition = $(window).height() + $(window).scrollTop();
        if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
            // when scroll to bottom of the page
          $('footer').addClass("footer");
        } else {
          $('footer').removeClass("footer");
        }
        // console.log(scrollHeight );
        // console.log(scrollPosition );
    };

    $(window).scroll(navbarCollapse);

    var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) : {};

    var themeName = themeSettings.themeName || '';

    if (themeName) {
        $('body').addClass(themeName);
    } else {
        console.log('nothing');
    }
</script>
</body>
</html>