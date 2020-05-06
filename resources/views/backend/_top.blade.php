<nav class="navbar navbar-default" id="navbar">
  <div class="container-fluid">
    <div class="navbar-collapse collapse in">
      <ul class="nav navbar-nav navbar-mobile">
        <li>
          <button type="button" class="sidebar-toggle">
            <i class="fa fa-bars"></i>
          </button>
        </li>
        <li class="logo">
          <a class="navbar-brand" href="#"><span class="highlight">STMDIC Taiwan</span></a>
        </li>
        <li>
          <button type="button" class="navbar-toggle" style="width:80px;">
            <img class="profile-img" src="{{\App\Admins::get_pic(session('adminid'))}}">
          </button>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-left">
        <li class="navbar-title">
          <span class="highlight">網站內容管理系統</span>
        </li>
        <li class="navbar-search hidden">
          <input id="search" type="text" placeholder="Search..">
          <button class="btn-search"><i class="fa fa-search"></i></button>
        </li>
      </ul>
      @include('backend._top_profile')
    </div>
  </div>
</nav>
<div class="profile-logout"><a href="/backend/logout">登出</a></div>