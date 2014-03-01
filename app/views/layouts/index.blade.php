
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Spin Up Laravel</title>

    <!-- Bootstrap core CSS -->
    <link href="/packages/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="/packages/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Yeild stylesheets from view -->
    @yield('stylesheets')

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            @if(Auth::check())
              <li><p class="navbar-text">You are logged in as {{Auth::user()->first_name . ' ' . Auth::user()->last_name}}.</p></li>
            @else
              <li><p class="navbar-text">You are not logged in.</p></li>
            @endif
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
        <h1><a href="http://laravel.com">Laravel</a>+<a href="http://getbootstrap.com">Bootstrap</a>+<a href="http://fortawesome.github.io/Font-Awesome/">FA</a>+<a href="https://developers.facebook.com/docs/reference/php/">Fb</a> starter template</h1>
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
      </div>
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          @if(Auth::check())
            <a href="{{ URL::route('logout') }}" data-loading-text="Logging in..." class="btn btn-primary btn-lg btn-block fb-btn"><i class="fa fa-facebook-square"></i> Logout</a>
          @else
            <a href="{{ URL::route('facebookLogin') }}" data-loading-text="Logging in..." class="btn btn-primary btn-lg btn-block fb-btn"><i class="fa fa-facebook-square"></i> Login with Facebook</a>
          @endif          
        </div><!-- .col-md-4 -->
      </div><!-- /.row -->

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="/packages/bootstrap/dist/js/bootstrap.min.js"></script>
    @yield('scripts')
  </body>
</html>
