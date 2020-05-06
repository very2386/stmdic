<?php
$path = urldecode(request()->path()) ; 
if( isset($bodyid) && $bodyid == 'page-market' || (isset($bodyclass) && $bodyclass == 'page-market' ) ){
  if(!isset($id)||$id=='數位影音'){
    switch ($path) {
      case 'marketing/marketing/智慧醫療':
      case 'marketing/marketing/牙科':
      case 'marketing/marketing/醫學美容':
      case 'marketing/marketing/體外診斷':
      case 'marketing/marketing/中草藥':
      case 'marketing/marketing/小分子藥物':
      case 'marketing/marketing/生技藥品':
      case 'marketing/marketing/食品生技':
      case 'marketing/marketing/骨科':
      case 'marketing/marketing/其他':
        $people = \App\Cm::where('position','people')->where('type',$type)->first();
        break;
      case 'market':
        $people = \App\Cm::where('position','people')->where('type','marketing')->first();
        break;
      case 'marketing/space':
        $people = \App\Cm::where('position','people')->where('type','space')->first();
        break;
      case 'marketing/product_experience':
        $people = \App\Cm::where('position','people')->where('type','product_experience')->first();
        break;
      case 'video/數位影音':
        $people = \App\Cm::where('position','people')->where('type','video')->first();
        break;
      case 'marketing/prospect/prospect':
        $people = \App\Cm::where('position','people')->where('type','prospect')->first();
        break;
      case 'marketing/prospect/fprospect':
        $people = \App\Cm::where('position','people')->where('type','fprospect')->first();
        break;
      default:
        $people = \App\Cm::where('position','people')->where('type','marketing')->first();
        break;
    }
  }else{
    $page = isset($page) ? $page : '' ;
    switch($page) {
      case 'marketing':
        $people = \App\Cm::where('id',$id)->first();
        break;
      case 'prospect':
        $people = \App\Prospects::where('id',$id)->first();
        break;
      case 'video':
        $people = \App\Cm::where('id',$id)->first();
        break;
      case 'product_experience':
        $people = \App\Cm::where('id',$id)->first();
        break;
      default:
        $people = \App\Cm::where('position','people')->where('type','marketing')->first();
        break;
    }
  }

  // if(isset($type) && $type) $people = \App\Cm::where('position','people')->where('type',$type)->first();
  // elseif(isset($id) && $id=='數位影音')  $people = \App\Cm::where('position','people')->where('type','video')->first();
  // elseif() $people = \App\Cm::where('position','people')->where('type','marketing')->first();
  $people = \App\Cm::where('position','people')->where('type','marketing')->first();
} 
else $people = \App\Cm::where('position','people')->where('type','index')->first();
?>
<footer>
  <div class="flex between">
  	<div class="left">
  		<div class="top flex between">
        <span><p>服務時間 8:30-17:30</p></span>
        <span>
          <span style="margin-right:5px;">最佳瀏覽解析度：1024 x 768 </span>
          <span>造訪人數：{{$people->hits}}</span>
        </span>
      </div>
  		<ul>
  			<li>
  				<span class="addr">741-47 台南市新市區南科三路22號</span>
  				<span class="tel">Tel：06-505-1001</span>
  				<span class="Fax">Fax：06-505-0312</span>
  			</li>
  			<li>
  				<span class="addr">821-51 高雄市路竹區路科五路23號</span>
  				<span class="tel">Tel：07-607-5545</span>
  				<!-- <span class="Fax"> </span> -->
  			</li>
  		</ul>
  	</div>
  	<div class="right">
  		<!-- <div class="top">
        <h2>Follow Us</h2>
      </div>
      <ul class="icon">
        <li><a href="javascript:;"><img src="/img/social/in.png" alt=""></a></li>
        <li><a href="javascript:;"><img src="/img/social/fb.png" alt=""></a></li>
        <li><a href="javascript:;"><img src="/img/social/gp.png" alt=""></a></li>
        <li><a href="javascript:;"><img src="/img/social/ig.png" alt=""></a></li>
        <li><a href="javascript:;"><img src="/img/social/yt.png" alt=""></a></li>
      </ul> -->
  	</div>
  </div>
</footer>