{{-- template login lama --}}

{{-- <!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SIBA | Sistem Informasi Borang Akreditasi</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">
    <!-- dropdown -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="{{route('postlogin')}}" method="post">
            {{ csrf_field() }}
              <h1>SIBA Login</h1>
              <!-- <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Pilihan masuk sebagai
                </button>
                <ul class="dropdown-menu">
                  <li><a href="{{URL::to('/dashboard')}}"">Administrator</a></li>
                  <li><a href="#">Dosen</a></li>
                  <li><a href="#">Mahasiswa</a></li>
                </ul>
              </div> -->
              <div>
                <input type="text" class="form-control" name="email" placeholder="Email" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>


                @if (session('message'))
                <div class="alert alert-danger alert-dismissable">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                    </button>
                    {{ session('message') }}
                </div>
                </div>
                @endif

              <div>
                <button type="submit" class="btn btn-default submit">Log in</button>
              </div>

              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
<title>SIBA | Sistem Informasi Borang Akreditasi</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="icon" type="image/png" href="images/icons/favicon.ico" />

<link rel="stylesheet" type="text/css" href="../Login_v2/vendor/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/fonts/font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/fonts/iconic/css/material-design-iconic-font.min.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/vendor/animate/animate.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/vendor/css-hamburgers/hamburgers.min.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/vendor/animsition/css/animsition.min.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/vendor/select2/select2.min.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/vendor/daterangepicker/daterangepicker.css">

<link rel="stylesheet" type="text/css" href="../Login_v2/css/util.css">
<link rel="stylesheet" type="text/css" href="../Login_v2/css/main.css">

<meta name="robots" content="noindex, follow">
<script nonce="b767324f-2700-4f65-aceb-c02e47895fe2">(function(w,d){!function(a,e,t,r){a.zarazData=a.zarazData||{},a.zarazData.executed=[],a.zaraz={deferred:[]},a.zaraz.q=[],a.zaraz._f=function(e){return function(){var t=Array.prototype.slice.call(arguments);a.zaraz.q.push({m:e,a:t})}};for(const e of["track","set","ecommerce","debug"])a.zaraz[e]=a.zaraz._f(e);a.addEventListener("DOMContentLoaded",(()=>{var t=e.getElementsByTagName(r)[0],z=e.createElement(r),n=e.getElementsByTagName("title")[0];for(n&&(a.zarazData.t=e.getElementsByTagName("title")[0].text),a.zarazData.x=Math.random(),a.zarazData.w=a.screen.width,a.zarazData.h=a.screen.height,a.zarazData.j=a.innerHeight,a.zarazData.e=a.innerWidth,a.zarazData.l=a.location.href,a.zarazData.r=e.referrer,a.zarazData.k=a.screen.colorDepth,a.zarazData.n=e.characterSet,a.zarazData.o=(new Date).getTimezoneOffset(),a.zarazData.q=[];a.zaraz.q.length;){const e=a.zaraz.q.shift();a.zarazData.q.push(e)}z.defer=!0;for(const e of[localStorage,sessionStorage])Object.keys(e).filter((a=>a.startsWith("_zaraz_"))).forEach((t=>{try{a.zarazData["z_"+t.slice(7)]=JSON.parse(e.getItem(t))}catch{a.zarazData["z_"+t.slice(7)]=e.getItem(t)}}));z.referrerPolicy="origin",z.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(a.zarazData))),t.parentNode.insertBefore(z,t)}))}(w,d,0,"script");})(window,document);</script></head>
<body class="login">
<div class="limiter">
<div class="container-login100">
<div class="wrap-login100">
<form action="{{route('postlogin')}}" method="post">
            {{ csrf_field() }}
<span class="login100-form-title p-b-26">
SIBA Login
</span>
<div class="wrap-input100 validate-input" data-validate="Valid email is: a@b.c">
<input class="input100" type="text" name="email">
<span class="focus-input100" data-placeholder="Email"></span>
</div>
<div class="wrap-input100 validate-input" data-validate="Enter password">
<span class="btn-show-pass">
<i class="zmdi zmdi-eye"></i>
</span>
<input class="input100" type="password" name="password">
<span class="focus-input100" data-placeholder="Password"></span>
</div>


                @if (session('message'))
                <div class="alert alert-danger alert-dismissable">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                    </button>
                    {{ session('message') }}
                </div>
                </div>
                @endif
<div class="container-login100-form-btn">
<div class="wrap-login100-form-btn">
<div class="login100-form-bgbtn"></div>
<button class="login100-form-btn submit" type="submit">
Login
</button>
</div>
</div>
<div class="text-center p-t-115">

</div>
</form>
</div>
</div>
</div>
<div id="dropDownSelect1"></div>

<script src="../Login_v2/vendor/jquery/jquery-3.2.1.min.js"></script>

<script src="../Login_v2/vendor/animsition/js/animsition.min.js"></script>

<script src="../Login_v2/vendor/bootstrap/js/popper.js"></script>
<script src="../Login_v2/vendor/bootstrap/js/bootstrap.min.js"></script>

<script src="../Login_v2/vendor/select2/select2.min.js"></script>

<script src="../Login_v2/vendor/daterangepicker/moment.min.js"></script>
<script src="../Login_v2/vendor/daterangepicker/daterangepicker.js"></script>

<script src="../Login_v2/vendor/countdowntime/countdowntime.js"></script>

<script src="../Login_v2/js/main.js"></script>

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-23581568-13');
	</script>
<script defer src="https://static.cloudflareinsights.com/beacon.min.js/v652eace1692a40cfa3763df669d7439c1639079717194" integrity="sha512-Gi7xpJR8tSkrpF7aordPZQlW2DLtzUlZcumS8dMQjwDHEnw9I7ZLyiOj/6tZStRBGtGgN6ceN6cMH8z7etPGlw==" data-cf-beacon='{"rayId":"70e55ab29ca34bc8","token":"cd0b4b3a733644fc843ef0b185f98241","version":"2021.12.0","si":100}' crossorigin="anonymous"></script>
</body>
</html>
