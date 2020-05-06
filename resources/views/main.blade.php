<!DOCTYPE html>
<html lang="en">
<head>
  <title>南部科學工業園區</title>
  <link rel="stylesheet" type="text/css" href="/css/reset.css">
  <link rel="stylesheet" type="text/css" href="/css/swiper.min.css"></link>
  <link rel="stylesheet" type="text/css" href="/css/basic.css">
  <link rel="stylesheet" type="text/css" href="/css/core.css">
  <link rel="stylesheet" type="text/css" href="/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/css/custom.css">
  <link rel="stylesheet" type="text/css" href="/pickadate/themes/default.css">
  <link rel="stylesheet" type="text/css" href="/pickadate/themes/default.date.css">
  <link rel="stylesheet" type="text/css" href="/pickadate/themes/default.time.css">
  <link href='/css/fullcalendar.min.css' rel='stylesheet' />
  <link href='/css/fullcalendar.print.min.css' rel='stylesheet' media='print' />
  <link href='/css/scheduler.min.css' rel='stylesheet' />
  <link rel="stylesheet" href="/css/jquery.tagsinput.min.css">
  <link rel="stylesheet" href="/select2/css/select2.min.css">
  <link rel="stylesheet" href="/lightbox/css/lightbox.min.css">
  <link href="/css/jquery.tagit.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
  <script src="/js/jquery.min.js"></script>
  <script src="/js/jquery-migrate-1.2.1.min.js"></script>
  <script src="/js/jquery.form.js"></script>
  <script src="/js/swiper.jquery.min.js"></script>
  <script src="/js/jquery-ui.min.js"></script>
  <script src="/js/comm.js"></script>
  <script src="/js/script.js"></script>
  <script type="text/javascript" src="/pickadate/picker.js"></script>
  <script type="text/javascript" src="/pickadate/picker.date.js"></script>
  <script type="text/javascript" src="/pickadate/picker.time.js"></script>
  <script src='/js/moment.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js'></script>
  <script src='/js/scheduler.min.js'></script>
  <script src="/js/jquery.tagsinput.min.js"></script>
  <script src="/select2/js/select2.min.js"></script>
  <script src="/lightbox/js/lightbox.min.js"></script>
  <script src="//cdn.ckeditor.com/4.6.2/full/ckeditor.js"></script>
  <script src="/js/tag-it.js" type="text/javascript" charset="utf-8"></script>
  @yield('header')
  <meta property="fb:app_id" content="110989952909732"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="{{isset($bodyclass)?$bodyclass:'page-inner'}}" id="{{isset($bodyid) ? $bodyid:'page-body'}}">
  <div class="container">
    @include('header')
    <main class="width-limiter">
      @yield('content')
    </main>
    @include('footer')
  </div>
  <input type="hidden" id="csrf_token" value="{{csrf_token()}}">
  @yield('javascript')
  <!-- Global Site Tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-106386085-1"></script>
  <script>
   window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments)};
   gtag('js', new Date());

   gtag('config', 'UA-106386085-1');
  </script>


<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/881129805/?guid=ON&amp;script=0"/>
</div>
</noscript>

</body>
</html>