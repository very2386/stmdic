<?php
$sys_log_counts = \App\SysLogs::where('type', 'login')->where('adminid', session('adminid'))->count();
?>
<ul class="nav navbar-nav navbar-right">
  <!-- <li class="sel-lang">
    <select class="select2" id="sel-lang" name="lang" onchange="sel_lang()">
      <option value="CH" {{session('lang') == 'CH' ? 'selected':''}}>中文</option>
    </select>
  </li> -->
  <li class="dropdown profile">
    <a href="/backend/profile" class="dropdown-toggle"  data-toggle="dropdown">
      <img class="profile-img" src="{{\App\Admins::get_pic(session('adminid'))}}">
      <div class="title">Profile</div>
    </a>
    <div class="dropdown-menu">
      <div class="profile-info">
        <h4 class="username">系統管理員</h4>
      </div>
      <ul class="action">
        <li>
          <a href="/backend/admin/admin_edit?id={{session('adminid')}}">
            帳號管理
          </a>
        </li>
        <li>
          <a href="/backend/admin/syslog?id={{session('adminid')}}">
            <span class="badge badge-danger pull-right">{{$sys_log_counts}}</span>
            登入記錄
          </a>
        </li>
        <li>
          <a href="/backend/logout">
            登出
          </a>
        </li>
      </ul>
    </div>
  </li>
  <li>
</ul>