var fxsina = function(){
	 var pic=BASEUSER+'/../images/weibo_b.jpg'; //图片到位后记得替换
	 window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent('#畅想你的新鲜主张# 给自己一点灵感点缀，每天都有新享法！甩开沉闷，即刻前往每日C官网，更有各种精彩好礼等你拿！@dailyc每日C 活动详情请猛击:')
	 	+'&pic='+encodeURIComponent(pic)
	 	+'&url='+encodeURIComponent('http://www.dailyc.com.cn/'),'_blank');
}

var fxqq = function(){
	var _t = encodeURIComponent('#畅想你的新鲜主张# 给自己一点灵感点缀，每天都有新享法！甩开沉闷，即刻前往每日C官网，更有各种精彩好礼等你拿！@dailyc每日C 活动详情请猛击:');
	var _url = encodeURI('http://www.dailyc.com.cn/');//document.location
	var _site = BASEUSER;//你的网站地址
	var _pic=BASEUSER+'/../images/weibo_b.jpg'; //图片到位后记得替换
	var _u = 'http://v.t.qq.com/share/share.php?pic='+_pic+'&title='+_t+'&url='+_url+'&site='+_site+'&assname=';
	window.open( _u,'转播到腾讯微博', 'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no' );		
}

var fxrr = function(){
	window.open('http://share.renren.com/share/buttonshare.do?link='+encodeURIComponent(BASEUSER+'/sns/renren'),'_blank');
}

var fxkx = function(){
	var pic=BASEUSER+'/../images/weibo_b.jpg'; //图片到位后记得替换
	window.open('http://www.kaixin001.com/rest/records.php?style=11&content='+encodeURIComponent('#畅想你的新鲜主张# 给自己一点灵感点缀，每天都有新享法！甩开沉闷，即刻前往每日C官网，更有各种精彩好礼等你拿！@dailyc每日C 活动详情请猛击:')
	+'&pic='+encodeURIComponent(pic)
	+'&url='+encodeURIComponent('http://www.dailyc.com.cn/'),'_blank');
}

var fxdb = function(){
	var pic=BASEUSER+'/../images/weibo_b.jpg'; //图片到位后记得替换
	window.open('http://shuo.douban.com/!service/share?image='+encodeURIComponent(pic)+'&name='+encodeURIComponent('康师傅每日C自然健康每一天')+'&url='+encodeURIComponent('http://www.dailyc.com.cn/')+'&text='+encodeURIComponent('#畅想你的新鲜主张# 给自己一点灵感点缀，每天都有新享法！甩开沉闷，即刻前往每日C官网，更有各种精彩好礼等你拿！@dailyc每日C 活动详情请猛击: http://www.dailyc.com.cn/'),'_blank');
}
