<?php
$bodyid = isset($bodyid) ? $bodyid : 'page-index' ; 
?>
<style type="text/css">
.market{
 background:#F6EEBA ;
 color: #4E200D;
}
.market-btn{
  display: flex;
  border: none;
  background-color: #F6EEBA ;
  color: #4E200D !important;
  width: 100%;
  text-align: center;
  padding-top: 1em;
  padding-bottom: 1em;
  justify-content: center;
  cursor: pointer;
}
</style>
<div class="popup">
  <div class="masklayer"></div>
  <div class="popup_window">
    <div class="popup_title {{$bodyid=='page-market'?'market':''}}">
      <h3>聯絡廠商</h3>
    </div>
    <div class="popup_content">
      <form action="/do/contact_company" id="contact_company_form" method="post">
        <div class="block">
          <h3 class="note">請輸入您要聯絡廠商的資料：</h3>
          <ul class="custom-input">
            <li>
              <h4 class="ttl">*姓名</h4>
              <input class="" type="text" name="name" value="{{session('minfo')?session('minfo')->name:''}}">
            </li>
            <li>
              <h4 class="ttl">聯絡電話</h4>
              <input class="" type="text" name="tel">
            </li>
            <li>
              <h4 class="ttl">*E-mail</h4>
              <input class="" type="text" name="email" value="{{session('minfo')?session('minfo')->email:''}}">
            </li>
            <li>
              <?php
              $problems = \App\Cm::get_problem_type();
              ?>
              <h4 class="ttl">*問題類型</h4>
                <select name="subject" style="width: 250px;">
                  <option>請選擇</option>
                  @foreach($problems as $p)
                  <option>{{$p}}</option>
                  @endforeach
                </select>
              <!-- <input class="" type="text" name="subject" value=""> -->
            </li>
            <li>
              <h4 class="ttl">*內容</h4>
              <textarea name="content" cols="20" rows="10"></textarea>
            </li>
            <li>
              <h4 class="ttl">*請輸入下圖字樣：</h4>
              <input type="text" name="checkword" size="10" maxlength="10" /><br>
            </li>
            <li>
              <h4 class="ttl" style="background: #fff"></h4>
              <span>
                <img id="imgcode" src="" onclick="refresh_code()"  style="margin:0px;">
              </span>
              <span style="padding-left: 10px;padding-top: 5px;">
                點擊圖片可以更換驗證碼 
              </span>
            </li>
            <li>
              <div class="popup_pad_left"></div>
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input type="hidden" id="comp_id" name="comp_id" value="">
              <input class="market-btn" type="submit" name="goContactCompany" class="btn-box" value="送出" />
            </li>
          </ul>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="popup-Cooperation">
  <div class="masklayer"></div>
  <div class="popup_window">
    <div class="popup_title {{$bodyid=='page-market'?'market':''}}">
      <h3>聯絡資料</h3>
    </div>
    <div class="popup_content">
      <form action="/do/contact_company" id="contact_company_form" method="post">
        <div class="block">
          <!-- <h3 class="note">聯絡資料：</h3> -->
          <ul class="custom-input">
            <li class="comptel">
              <h3 class="ttl">電話：</h3>
              <p></p>
            </li>
            <li class="compfax">
              <h3 class="ttl">傳真：</h3>
              <p></p>
            </li>
            <li class="compemail">
              <h3 class="ttl">E-mail：</h3>
              <p></p>
            </li>
            <li class="compaddr">
              <h3 class="ttl">公司地址：</h3>
              <p></p>
            </li>
            <li class="compweb">
              <h3 class="ttl">官網：</h3>
              <p></p>
            </li>
          </ul>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  $(function(){
    register_form('#contact_company_form', function(){
      $('.popup').fadeOut();
    });
    $('.ask').click(function() {
      var t = $(this).parents('.text');
      var compid = $(this).data('compid');
      var compname = t.find('.comp_name a').data('compname');
      $('.popup_title h3').html('聯絡 '+compname);
      $('#comp_id').val(compid);
      $('#imgcode').attr('src','/captcha?'+Math.random());
      $('.popup').fadeIn();
    }) 
    $('.masklayer').click(function(){
      $(this).parent().fadeOut();
    })
    $('.cooperation').click(function() {
      var t = $(this).parents('.text');
      var compid = $(this).data('compid');
      var compname = t.find('.comp_name a').data('compname');
      $('.popup_title h3').html(compname+' 聯絡資料');
      get_data('/do/get_compinfo', {compid:compid},function(res) {
        $('.comptel p').html(res.data['comptel']);
        $('.compfax p').html(res.data['compfax']);
        $('.compemail p').html(res.data['email']);
        $('.compaddr p').html(res.data['addr']);
        $('.compweb p').html(res.data['link']);
      });
      $('.popup-Cooperation').fadeIn();
    }) 
  });
  function refresh_code(){ 
    document.getElementById("imgcode").src="/captcha?"+Math.random(); 
  } 
</script>