<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header">
    <a class="sidebar-brand" href="/backend"><span class="highlight">STMDIC</span></a>
    <button type="button" class="sidebar-toggle">
      <i class="fa fa-times"></i>
    </button>
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <li class="dropdown funcs-sys">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-cube" aria-hidden="true"></i>
          </div>
          <div class="title">系統管理</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-newspaper-o" aria-hidden="true"></i>內容管理</li>
            <li class="funcs-sliders"><a href="/backend/home/sliders">首頁輪播</a></li>
            <!-- <li class="funcs-articles"><a href="/backend/home/article">頁面管理</a></li> -->
            <!-- <li><a href="/backend/home/event">活動專區大圖</a></li>
            <li><a href="/backend/home/news">首頁新聞</a></li> -->
            <li class="line"></li>
            <li class="section"><i class="fa fa-user" aria-hidden="true"></i>系統管理</li>
            <li class=""><a href="/backend/admin/index">人員管理</a></li>
            <!--<li><a href="/backend/admin/media">媒體庫</a></li> -->
            <!-- <li class=""><a href="/backend/admin/ip">IP管理</a></li> -->
            <li class=""><a href="/backend/admin/funcs">功能清單</a></li>
            <li class=""><a href="/backend/admin/roles">權限群組</a></li>
            <!-- <li><a href="/backend/tag/index">關鍵字管理</a></li> -->
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-members">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-users" aria-hidden="true"></i>
          </div>
          <div class="title">會員廠商</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>會員管理</li>
            <li><a href="/backend/member/index">會員管理</a></li>
            <li><a href="/backend/member/advertismenet">會員登入頁廣告管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-clock-o" aria-hidden="true"></i>廠商管理</li>
            <li><a href="/backend/company/index">廠商資料</a></li>
            <li><a href="/backend/company/statistics">廠商相關資料統計</a></li>
            <!-- <li><a href="/backend/company/apply">廠商申請</a></li>
            <li><a href="/backend/company/hr">人求事</a></li> -->
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-marketing">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
          </div>
          <div class="title">行銷專區</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>首頁影片管理</li>
            <li><a href="/backend/marketing/video_edit">首頁影片管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>展會活動</li>
            <li><a href="/backend/marketing/prospect">目前展會管理</a></li>
            <li><a href="/backend/marketing/fprospect">未來展會管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>合作平台</li>
            <li><a href="/backend/marketing/cooperation_edit">產醫合作管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>展示平台</li>
            <li><a href="/backend/marketing/space_edit">醫材展示室-空間介紹管理</a></li>
            <li><a href="/backend/marketing/booking">醫材展示室-預約使用</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-plan">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
          </div>
          <div class="title">計畫專區</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i>計畫公告管理</li>
            <li><a href="/backend/plan/index">計畫公告管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-file">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-file-archive-o" aria-hidden="true"></i>
          </div>
          <div class="title">文件下載</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i>文件下載管理</li>
            <li><a href="/backend/files/index">文件下載管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-information">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
          </div>
          <div class="title">最新消息</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i>媒體曝光管理</li>
            <li><a href="/backend/information/index?type=domestic">國內媒體管理</a></li>
            <li><a href="/backend/information/index?type=foreign">國外媒體管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-experts">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-user" aria-hidden="true"></i>
          </div>
          <div class="title">領域專家</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-user" aria-hidden="true"></i>專家管理</li>
            <li><a href="/backend/experts/index">專家管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-events">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-bullhorn" aria-hidden="true"></i>
          </div>
          <div class="title">近期活動</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-bullhorn" aria-hidden="true"></i>活動管理</li>
            <li><a href="/backend/event/index">活動管理</a></li>
            <!-- <li><a href="/backend/event/join">報名管理</a></li> -->
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-news">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-newspaper-o" aria-hidden="true"></i>
          </div>
          <div class="title">聚落新知</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>新聞來源</li>
            <li><a href="/backend/nsite/index">新聞來源網站</a></li>
            <li><a href="/backend/nsource/index">新聞來源管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-clock-o" aria-hidden="true"></i>新聞管理</li>
            <!-- <li><a href="/backend/tag/index?t=news">標籤管理</a></li> -->
            <li><a href="/backend/news/index">新聞管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-posts">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-file-text" aria-hidden="true"></i>
          </div>
          <div class="title">聚落交流區</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>類別管理</li>
            <li><a href="/backend/posts/category">類別管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-clock-o" aria-hidden="true"></i>文章管理</li>
            <li><a href="/backend/posts/index">文章管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-video">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-video-camera" aria-hidden="true"></i>
          </div>
          <div class="title">育成專區管理</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-video-camera" aria-hidden="true"></i></i>數位影音分類管理</li>
            <li><a href="/backend/video/video_type">數位影音類別管理</a></li>
            <li><a href="/backend/video/video_second_type">數位影音次分類管理</a></li>
            <li class="line"></li>
            <li class="section"><i class="fa fa-video-camera" aria-hidden="true"></i></i>數位影音影片管理</li>
            <li><a href="/backend/video/index">影音管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-link">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-link" aria-hidden="true"></i>
          </div>
          <div class="title">外站連結</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>外站連結管理</li>
            <li><a href="/backend/link/index">外站連結管理</a></li>
          </ul>
        </div>
      </li>
      <li class="dropdown funcs-tags">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-tags" aria-hidden="true"></i>
          </div>
          <div class="title">標籤管理</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-tags" aria-hidden="true"></i>標籤管理</li>
            <li><a href="/backend/tag/index">關鍵字管理</a></li>
            <li class="section"><i class="fa fa-tags" aria-hidden="true"></i>爬文關鍵字管理</li>
            <li><a href="/backend/tag/keywords">爬文關鍵字管理</a></li>
          </ul>
        </div>
      </li>
      <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          <div class="icon">
            <i class="fa fa-database" aria-hidden="true"></i>
          </div>
          <div class="title">資料管理</div>
        </a>
        <div class="dropdown-menu">
          <ul>
            <li class="section"><i class="fa fa-info-circle" aria-hidden="true"></i>資料管理</li>
            <li><a href="/backend/experts/index">期刊資料</a></li>
            <li><a href="/backend/experts/index">專利資料</a></li>
          </ul>
        </div>
      </li> -->
    </ul>
  </div>
</aside>