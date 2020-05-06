<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>首頁 &lt; 南部科學工業園區</title>
	<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	$commVar = $root."/inc/comm.php";
	include($commVar);
	echo $css;
	echo $js;
	?>
</head>
<body class="page-index">
	<div class="container">
		<?php include 'inc/header.php'; ?>
		<main class="width-limiter">
			<section class="top clearfix">
				<div class="left">
					<div class="swiper-container" data-mode="fade" data-pause="false" data-speed="3000">
						<ul class="swiper-wrapper">
							<li class="swiper-slide"><img src="http://fakeimg.pl/780x450/?text=pic1" alt=""></li>
							<li class="swiper-slide"><img src="http://fakeimg.pl/780x450/?text=pic2" alt=""></li>
							<li class="swiper-slide"><img src="http://fakeimg.pl/780x450/?text=pic3" alt=""></li>
							<li class="swiper-slide"><img src="http://fakeimg.pl/780x450/?text=pic4" alt=""></li>
							<li class="swiper-slide"><img src="http://fakeimg.pl/780x450/?text=pic5" alt=""></li>
							<li class="swiper-slide"><img src="http://fakeimg.pl/780x450/?text=pic6" alt=""></li>
						</ul>
						<!-- Add Pagination -->
						<div class="swiper-pagination"></div>
					</div>
				</div>
				<div class="right">
					<ul>
						<li><a href=""><img src="http://fakeimg.pl/420x225/" alt=""><span class="text">活動專區</span></a></li>
						<li><a href=""><img src="http://fakeimg.pl/420x225/" alt=""><span class="text">活動專區</span></a></li>
					</ul>
				</div>
			</section>
			<section class="hot">
				<div class="ttl-bar">
					<h2>熱門文章</h2>
					<ul class="tab">
						<li class="active">智慧物聯</li>
						<li>健康照護</li>
						<li>齒科產業</li>
						<li>體外診斷</li>
						<li>臨床需求</li>
						<li>醫療法規</li>
						<li>專利技術</li>
						<li>市場營運</li>
					</ul>
					<div class="searchbar">
						<input type="search" placeholder="文章搜尋">
						<div class="custom-select">
							<h5 class="ttl">全部</h5>
							<ul class="opt">
								<li>全部</li>
								<li>標題</li>
								<li>作者</li>
								<li>內文</li>
							</ul>
						</div>
						<button class="btn-search">Search</button>
					</div>
				</div>
				<div class="content two-side clearfix">
					<div class="cat1 active hot-articles">
						<ul class="grid3 spacing20 wrap">
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/?text=news1"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
						</ul>
						<a class="btn-more" href="">More....</a>
					</div>
					<div class="cat2">
						<ul class="grid3 spacing20 wrap">
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/?text=news1"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
						</ul>
						<a class="btn-more" href="">More....</a>
					</div>
					<div class="hot-today side-right">
						<h3>今日熱門文章</h3>

						<div class="slider">
							<div class="swiper-container">
								<ul class="swiper-wrapper flex no-shrink">
									<li class="swiper-slide">
										<a href="">
											<span class="img"><img src="http://fakeimg.pl/354x228/"></span>	
											<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
										</a>
										<p>本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。</p>
										<a class="btn-more" href="">More....</a>
									</li>
									<li class="swiper-slide">
										<a href="">
											<span class="img"><img src="http://fakeimg.pl/354x228/"></span>	
											<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
										</a>
										<p>本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。</p>
										<a class="btn-more" href="">More....</a>
									</li>
								</ul>
								
							</div>
							<div class="swiper-button-next black"></div>
							<div class="swiper-button-prev black"></div>
						</div>
					</div>
				</div>
			</section>

			<section class="exhibit">
				<div class="ttl-bar">
					<h2>展覽活動</h2>
				</div>
				<div class="content grid-intro">
					<div class="slider">
						<div class="swiper-container">
							<ul class="swiper-wrapper grid4 no-shrink">
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<ul class="date">
											<li class="evt-time">
												<h4>活動時間</h4>
												<p>8/18</p>
											</li>
											<li class="reg-time">
												<h4>報名時間</h4>
												<p>7/20 - 8/7</p>
											</li>
										</ul>
										<div class="link">
											<a href="">展覽位置</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<ul class="date">
											<li class="evt-time">
												<h4>活動時間</h4>
												<p>8/18</p>
											</li>
											<li class="reg-time">
												<h4>報名時間</h4>
												<p>7/20 - 8/7</p>
											</li>
										</ul>
										<div class="link">
											<a href="">展覽位置</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<ul class="date">
											<li class="evt-time">
												<h4>活動時間</h4>
												<p>8/18</p>
											</li>
											<li class="reg-time">
												<h4>報名時間</h4>
												<p>7/20 - 8/7</p>
											</li>
										</ul>
										<div class="link">
											<a href="">展覽位置</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<ul class="date">
											<li class="evt-time">
												<h4>活動時間</h4>
												<p>8/18</p>
											</li>
											<li class="reg-time">
												<h4>報名時間</h4>
												<p>7/20 - 8/7</p>
											</li>
										</ul>
										<div class="link">
											<a href="">展覽位置</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<ul class="date">
											<li class="evt-time">
												<h4>活動時間</h4>
												<p>8/18</p>
											</li>
											<li class="reg-time">
												<h4>報名時間</h4>
												<p>7/20 - 8/7</p>
											</li>
										</ul>
										<div class="link">
											<a href="">展覽位置</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<ul class="date">
											<li class="evt-time">
												<h4>活動時間</h4>
												<p>8/18</p>
											</li>
											<li class="reg-time">
												<h4>報名時間</h4>
												<p>7/20 - 8/7</p>
											</li>
										</ul>
										<div class="link">
											<a href="">展覽位置</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="swiper-button-next black"></div>
						<div class="swiper-button-prev black"></div>
					</div>
					<a href="" class="btn-more">More....</a>
				</div>
			</section>
			<section class="manufacturers">
				<div class="ttl-bar">
					<h2>廠商專區</h2>
				</div>
				<div class="content grid-intro">
					<div class="slider">
						<div class="swiper-container">
							<ul class="swiper-wrapper grid4 no-shrink">
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<p>
											本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
											為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
											使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
											這些資料將僅供本網站流量分析與網路行為調查參考。
										</p>
										<div class="link">
											<a href="">合作</a>
											<a href="">詢問</a>
											<a href="">徵才</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<p>
											本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
											為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
											使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
											這些資料將僅供本網站流量分析與網路行為調查參考。
										</p>
										<div class="link">
											<a href="">合作</a>
											<a href="">詢問</a>
											<a href="">徵才</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<p>
											本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
											為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
											使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
											這些資料將僅供本網站流量分析與網路行為調查參考。
										</p>
										<div class="link">
											<a href="">合作</a>
											<a href="">詢問</a>
											<a href="">徵才</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<p>
											本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
											為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
											使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
											這些資料將僅供本網站流量分析與網路行為調查參考。
										</p>
										<div class="link">
											<a href="">合作</a>
											<a href="">詢問</a>
											<a href="">徵才</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<p>
											本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
											為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
											使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
											這些資料將僅供本網站流量分析與網路行為調查參考。
										</p>
										<div class="link">
											<a href="">合作</a>
											<a href="">詢問</a>
											<a href="">徵才</a>
										</div>
									</div>
								</li>
								<li class="swiper-slide">
									<div class="img">
										<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
									</div>
									<div class="text">
										<h3><a href="javascript:;">[ 第二十屆生物科技研討會]</a></h3>
										<p>
											本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
											為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
											使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
											這些資料將僅供本網站流量分析與網路行為調查參考。
										</p>
										<div class="link">
											<a href="">合作</a>
											<a href="">詢問</a>
											<a href="">徵才</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="swiper-button-next black"></div>
						<div class="swiper-button-prev black"></div>
					</div>
					<a href="" class="btn-more">More....</a>
				</div>
			</section>
			<section class="yellow-pages">
				<div class="ttl-bar">
					<h2>專家黃頁</h2>
					<ul class="tab"> 
						<li class="active">學者專家</li>
						<li>臨床醫師</li>
						<li>服務業者</li>
						<li>創業投資人</li>
						<li>其他</li>
					</ul>
				</div>
				<div class="content two-side clearfix">
					<div class="cat1 active side-left">
						<ul class="grid4 wrap">
							<li>
								<div class="img">
									<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="javascript:;">吳季剛</a></h3>
									<p>
										本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
										為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
										使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
										這些資料將僅供本網站流量分析與網路行為調查參考。
									</p>
									<a href="" class="btn-more-box">More</a>
								</div>
								
							</li>
							<li>
								<div class="img">
									<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="javascript:;">吳季剛</a></h3>
									<p>
										本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
										為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
										使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
										這些資料將僅供本網站流量分析與網路行為調查參考。
									</p>
									<a href="" class="btn-more-box">More</a>
								</div>
								
							</li>
							<li>
								<div class="img">
									<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="javascript:;">吳季剛</a></h3>
									<p>
										本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
										為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
										使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
										這些資料將僅供本網站流量分析與網路行為調查參考。
									</p>
									<a href="" class="btn-more-box">More</a>
								</div>
								
							</li>
							<li>
								<div class="img">
									<a href=""><img src="http://fakeimg.pl/354x228/" alt=""></a>
								</div>
								<div class="text">
									<h3><a href="javascript:;">吳季剛</a></h3>
									<p>
										本網站遵守「個人資料保護法」之規範，保障用戶隱私權益，保證不對外公開。但依據有關法律規章規定、應司法機關調查要求
										為維護社會公眾利益、事先獲得用戶明確授權及為維護本網站合法權益之情形，不在此限。
										使用者進入本網站時，伺服器將自動產生相關紀錄(Log)， 包括如使用者的IP位址、使用時間、使用者的瀏覽器、及點選資料記錄等。 
										這些資料將僅供本網站流量分析與網路行為調查參考。
									</p>
									<a href="" class="btn-more-box">More</a>
								</div>
							</li>
						</ul>
					</div>
					<div class="cat2">
						<ul class="grid3 spacing20 wrap">
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/?text=news1"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
							<li>
								<a href="">
									<span class="img"><img src="http://fakeimg.pl/242x156/"></span>	
									<span class="text">膽固醇不一定是「吃」來的破除膽固醇4迷思....</span>
								</a>
							</li>
						</ul>
						<a class="btn-more" href="">More....</a>
					</div>
					<div class="side-right">
						<h3>尋找最有價值的專家</h3>
						<div class="searchbar">
							<input type="search" placeholder="文章搜尋">
							<div class="custom-select">
								<h5 class="ttl">全部</h5>
								<ul class="opt">
									<li>全部</li>
									<li>標題</li>
									<li>作者</li>
									<li>內文</li>
								</ul>
							</div>
							<button class="btn-search">Search</button>
						</div>
						<div class="search-cat">
							<h4>篩選類別搜尋</h4>
							<div class="custom-select">
								<h5 class="ttl">全部</h5>
								<ul class="opt">
									<li>全部</li>
									<li>學者專家</li>
									<li>臨床醫師</li>
									<li>服務業者</li>
									<li>創業投資人</li>
									<li>其他</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</section>
			
		</main>
		<footer>
			<ul>
				<li><p>管理局:741-47台南市新市區南科三路22號</p><p>Tel:06-505-1001</p><p>Fax:06-5050470</p><p>服務時間:8:30-17:30</p></li>
				<li><p>高雄園區:821-51高雄市路竹區路科五路23號</p><p>Tel:07-607-5545</p><p>Fax:07-6075549</p></li>
			</ul>
		</footer>
	</div>
</body>
</html>