<?php
\App\Funcs::chk_ip();
if(!session('adminid') && (!isset($page) || $page != 'login') ) {
  echo "<script>location.href='/backend/login'</script>";
  exit;
}elseif(!session('lang')) session(['lang'=>'CH']);
$funcs = [];
$remove_funcs= [];
$show_funcs= [];
$roleid = isset(session('admininfo')->roleid) ? session('admininfo')->roleid:0;
$rolerd = \App\Cm::where('id', $roleid)->first();
if($rolerd) $funcs = explode(',', $rolerd->brief);
$funcrs = \App\Cm::where('position','funcs')->get();
foreach($funcrs as $funcrd){
  if(!in_array($funcrd->id, $funcs)){
    $remove_funcs[] = ".".$funcrd->brief; 
  }else{
    $show_funcs[]  = ".".$funcrd->brief;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>南部生技醫療器材產業聚落發展計畫</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" type="text/css" href="/back/assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="/back/assets/css/flat-admin.css">
  <link rel="stylesheet" type="text/css" href="/jquery-ui/jquery-ui.min.css">
  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="/back/assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="/back/assets/css/custom.css">
  <link rel="stylesheet" type="text/css" href="/back/assets/pickadate/themes/default.css">
  <link rel="stylesheet" type="text/css" href="/back/assets/pickadate/themes/default.date.css">
  <link rel="stylesheet" type="text/css" href="/back/assets/pickadate/themes/default.time.css">
  <link rel="stylesheet" type="text/css" href="/back/assets/colorpicker/css/bootstrap-colorpicker.css">
</head>
<body>
  <div class="app app-default">
    @if(session('adminid'))
    @include('backend._menu')
    <div class="app-container">
      @yield('content')
      <footer class="app-footer"> 
        <div class="row">
          <div class="col-xs-12">
            <!-- <div class="footer-copyright">
              Copyright © 2017 ATOS TAIWAN.
            </div> -->
          </div>
        </div>
      </footer>
    </div>
    @else
    @yield('content')
    @endif
  </div>
  <input type="hidden" name="csrf_token" id="csrf_token" value="{{csrf_token()}}" />
  <script type="text/javascript" src="/back/assets/js/vendor.js"></script>
  <script type="text/javascript" src="/back/assets/js/jquery-migrate-git.min.js"></script>
  <script type="text/javascript" src="/back/assets/js/jquery.form.min.js"></script>
  <script type="text/javascript" src="/back/assets/js/app.js"></script>
  <script type="text/javascript" src="/jquery-ui/jquery-ui.js"></script>
  <script type="text/javascript" src="/back/assets/pickadate/picker.js"></script>
  <script type="text/javascript" src="/back/assets/pickadate/picker.date.js"></script>
  <script type="text/javascript" src="/back/assets/pickadate/picker.time.js"></script>
  <script type="text/javascript" src="/back/assets/colorpicker/js/bootstrap-colorpicker.js"></script>
  <script type="text/javascript" src="/js/Chart.js"></script>
  <script type="text/javascript">
  var $login_mid = '{{ session('mid') }}';
  $(function(){
    @if( session('sysmsg') )
      msgbox_show('{{session('sysmsg')}}','系統訊息');
    @endif
    $(".select2").select2({
        dropdownAutoWidth : true
    });
    $(".sidebar-toggle").bind("click", function (e) {
      $("#sidebar").toggleClass("active");
      $(".app-container").toggleClass("__sidebar");
    });

    $(".navbar-toggle").bind("click", function (e) {
      $('.profile-logout').slideToggle();
    });
    
    $('{{implode(',', $remove_funcs)}}').remove();
    $('{{implode(',', $show_funcs)}}').show();
  });
  </script>
  @yield('javascripts')
  @include('backend._modal')
</body>
</html>