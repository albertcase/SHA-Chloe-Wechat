var prizeType,ifIsLogin,playTimes,firstMobile,hasName,hasAddress,ifsearchPrize
//浏览器判别
var isChrome = navigator.userAgent.toLowerCase().match(/chrome/) != null;
var isSafari = navigator.userAgent.toLowerCase().match(/safari/) != null;
var isFireFox = navigator.userAgent.toLowerCase().match(/firefox/) != null;
var isMsIe = navigator.userAgent.toLowerCase().match(/msie/) != null;
var hasData =false;
$(function(){
	islogin();
	drawActiveNum();
	// 弹出关闭
	$('.closeBtn').click(function(){
		$(this).parent().fadeOut()
		$('#onload_cover').fadeOut()
	})
	
	// 活动细则
	$('.rulesNav li a').each(function(e){
		$(this).click(function(){
			$('.rulesNav li a').removeClass('current')
			$(this).addClass('current')
			$('.maincont').hide().eq(e).show()
			if(e==2){
				$('#scrollbar').tinyscrollbar({size:150,sizethumb:41});
			}
		})
	})
	$('#prizeIcon').mouseover(function(){
		$('#prizeTips').fadeIn()
	}).mouseleave(function(){
		$('#prizeTips').fadeOut()
	})

	// 留资料
	$('#userPhone').blur(function(){
		checkMobile()
	})
	$('#userName').blur(function(){
		checkName()
	})

	$('#userAddress').blur(function(){
		checkAddress()
	})

	// 中奖名单
	$('#select_dt').click(function(){
		$('#select_dd').show()
	})
	$('.select').mouseleave(function(){
		$('.select dd').hide()
	})

	$('#search_input').focus(function(){
		if($(this).val()=='请输入您的姓名/手机号码'){
			$(this).val('')
		}
	})
	
})

function alertMsg(obj){
	$('.pop_div').hide()
	var obj = $(obj)
	var ch
	if(isChrome){
		ch=parseInt(document.body.scrollHeight);
	}else{
		ch=parseInt(document.documentElement.scrollHeight);
	}
	obj.fadeIn()
	$('#onload_cover').css('height', ch-57).fadeIn();
}
function closeMsg(obj){
	var obj = $(obj)
	obj.fadeOut()
	$('#onload_cover').fadeOut()
}

// 游戏动态提示
function gameRollIcon(){
	$('#lightMask').animate({opacity:1},{
		duration:500,
		complete:function(){
			$('#lightMask').animate({opacity:0},500)
		}
	})
	$('#rollIcon').animate({top:'80px'},{
		duration:500,
		complete:function(){
			$('#rollIcon').animate({top:'75px'},{duration:500})
		}
	})
}
var rollinit = setInterval('gameRollIcon()',1000)

//播放动画帧
function setAni(i,dom,time){
	$('#lightMask,#rollIcon,.rollText').hide()
	var $size=$(dom).length;
	if($size <= i){
		rscroll();
		if($size*2 < i){
			$('#lightMask,#rollIcon,.rollText').show()
			$('#click_btn').html('')
		 	return false
		}
		$(dom).hide();
		$(dom).eq($size*2-i).show();
	}else{
		$(dom).hide();
		$(dom).eq(i).show();
	}
	i++;
	setTimeout(function(){setAni(i,dom,time)},time)
	
}
//设置游戏参数
function numRand() {
	var rand
	if(prizeType){
		rand = parseInt(111);
		return rand;
	}else if(!prizeType){
		var x = 510; //上限
		var y = 200; //下限
		rand = parseInt(Math.random() * (x - y + 1) + y); // //1,5,9同时出现中奖
		return rand;
	}
}

var isBegin = false;
//触发游戏滚动
function rscroll(){
		//clearInterval(rollinit)
		
		var u = 167;
		if(isBegin) return false;
		isBegin = true;
		$(".num").eq(0).css('backgroundPosition',"0 73px");
		$(".num").eq(1).css('backgroundPosition',"0 240px");
		$(".num").eq(2).css('backgroundPosition',"0 407px");
		var result = numRand();
		$('#res').text('result = '+result);
		var num_arr = (result+'').split('');

		$(".num").each(function(index){
			var _num = $(this);
			setTimeout(function(){
				_num.animate({
					backgroundPosition:'0 '+((u*60) - (u*num_arr[index])+73)+''
					//backgroundPositionY: (u*60) - (u*num_arr[index])+41+'px'
				},{
					duration: 6000+index*3000,
					easing: "easeInOutCirc",
					complete: function(){
						if(index==2){
							//摇奖结束
							var $jarSize=jarSize(result);
							if($jarSize==3){
								alertMsg('#popMsg')
								gsTrackPage ("/win");
							}else{
								alertMsg('#popNoPrize')
								$('#gameTimes').text(playTimes)
								gsTrackPage ("/lost");
							}
							drawActiveNum()
							setTimeout(function(){
								$(".num").eq(0).css('backgroundPosition',"0 73px");
								$(".num").eq(1).css('backgroundPosition',"0 240px");
								$(".num").eq(2).css('backgroundPosition',"0 407px");
							},1000);
							
							//时间添加
							$('#click_btn').html('<a href="javascript:void(0)" onclick="rollPrize();_mvp.push([\'$logAction\',\'美版雅培网站点击马上摇奖\']);"></a>')
							isBegin = false;
							
							//rollinit = setInterval('gameRollIcon()',1000)
					    }
					}
				});
			}, index * 300);
		});
}
//拆分参数
function jarSize(num){
	var m=0;
	var $rands=num.toString();
	for(var i=0;i<$rands.length;i++){
		if(Math.floor($rands.substring(i,i+1))==1 || Math.floor($rands.substring(i,i+1))==6){
			m++;
		}
	}
	return m
}

// 退出登陆
function logOut(){
	$.ajax({
		type:"POST",
		url:BASEURL+"/sns/loginout",
		data:{},
		dataType: "json",
		success:function(data){
			if(data.code==1){
				islogin()
			}else{
				alert(data.msg)
			}
		}
	})
}

// 判断登录
function islogin(){
	$.ajax({
		type:"POST",
		url:BASEURL+"/sns/islogin",
		data:{},
		dataType: "json",
		success:function(data){
			if(data.code==0){
				ifIsLogin = false;
				$('#loginCont').html('')
			}else if(data.code==1){
				ifIsLogin = true;
				$('#loginCont').html('<p class="wlecomeMember">欢迎你，'+data.msg.nickname+'</p><p class="logout"><span onclick="logOut()">退出</span></p>')
			}
		}
	})
}

// 抽奖
function rollPrize(){
	$('#click_btn').html('<a href="javascript:void(0)" onclick="rollPrize();_mvp.push([\'$logAction\',\'美版雅培网站点击马上摇奖\']);"></a>')
	if(!ifIsLogin){
		sinaLogin('loginCallback')
		return;
	}
	if(ifIsLogin){
		$.ajax({
			type:"POST",
			url:BASEURL + "/sampling/lottery",
			data:{},
			dataType:"json",
			success:function(data){
				playTimes = 3 - data.msg;
				if(data.code==1){
					prizeType = true;
					setAni(0,'.g_la img',25)
				}else if(data.code==2){
					prizeType = false;
					setAni(0,'.g_la img',25)
				}else if(data.code==3){
					alertMsg('#popNoTimes')
				}
			}
		})
		gsTrackPage("/clickLottery");
	}
}


var regPhone = (/(^1[3|4|5|6|7|8|9][0-9]{9}$)/);
// 留资料
function leaveMsg(){
	var phoneMsg = $('#userPhone').val()
	var nameMsg = $('#userName').val()
	var addressMsg = $('#userAddress').val()

	if(!hasName){
    	$('#nameWarn').html('*姓名至少为2个字符以上')
    	return false;
    	
    }
    if(!hasAddress){
    	$('#addressWarn').html('*请输入详细的收奖地址')
    	return false;
    }
   
    if(regPhone.length==0||!regPhone.test(phoneMsg)){
    	$('#phoneWarn').html('*请输入正确的手机号')
		return false;
	}

	$.ajax({
		type:"POST",
		url: BASEURL + "/sampling/checkmobile",
		data:{"mobile":phoneMsg},
		dataType:"json",
		success:function(data){
			if(data.code==3){
				firstMobile = false;
				$('#phoneWarn').html('<span style="line-height:15px">*您已经赢取过奖品，请把机会留给其他妈妈吧！</span>')
				gsTrackPage ("/win_duplicate ")
				return;
			}else if(data.code==1){
				firstMobile = true;
				$('#phoneWarn').html('')
				$.ajax({
					type:"POST",
					url:BASEURL+"/sampling/finish",
					data:{"name":nameMsg,"mobile":phoneMsg,"address":addressMsg},
					dataType:"json",
					success:function(data){
						if(data.code==1){
							closeMsg('#popMsg')
							alertMsg("#popGetPrize")
							gsTrackPage ("/win_submitOK");
						}else{
							alert(data.msg)
						}
					}
				})
			}
		}
	})
	// if(!firstMobile){
	// 	$('#phoneWarn').html('<span style="line-height:15px">*您已经赢取过奖品，请把机会留给其他妈妈吧！</span>')
 	//    	return false;
 	//    }
}
// 判断手机
function checkMobile(){
	var phoneMsg = $('#userPhone').val()
	if(regPhone.length==0||!regPhone.test(phoneMsg)){
		$('#phoneWarn').html('*请输入正确的手机号')
		return;
	}else{
		$('#phoneWarn').html('')
	}
	$.ajax({
		type:"POST",
		url: BASEURL + "/sampling/checkmobile",
		data:{"mobile":phoneMsg},
		dataType:"json",
		success:function(data){
			if(data.code==3){
				firstMobile = false;
				$('#phoneWarn').html('<span style="line-height:15px">*您已经赢取过奖品，请把机会留给其他妈妈吧！</span>')
				return;
			}else if(data.code==1){
				firstMobile = true;
				$('#phoneWarn').html('')
			}
		}
	})
}

function checkName(){
	var nameMsg = $('#userName').val()
	if(nameMsg.length==0||nameMsg.length<2){
		hasName=false
		$('#nameWarn').html('*姓名至少为2个字符以上')
		return;
	}else{
		hasName=true
		$('#nameWarn').html('')
		return;
	}
}

function checkAddress(){
	var addressMsg = $('#userAddress').val()
	if(addressMsg.length==0||addressMsg.length<6){
		hasAddress=false
		$('#addressWarn').html('*请输入详细的收奖地址')
		return;
	}else{
		hasAddress=true
		$('#addressWarn').html('')
		return;
	}
}

// 新浪登陆
function sinaLogin(callback){
    var url = BASEURL + "/sinaWeibo?campaign_id=samplingpc&callback="+callback;
    var top=(document.body.clientHeight-600)/2;
    var left=(document.body.clientWidth-990)/2;
    window.open(url,'connect_window', 'height=600, width=990, toolbar =no, menubar=no, scrollbars=yes, resizable=no,top='+top+',left='+left+', location=no, status=no');
}

function loginCallback(){
	closeMsg('#popLogin');
	islogin();
}

// 点赞
function addHot(id){
	var sendPid = id
	$.ajax({
		type:"POST",
		url:BASEURL + "/sampling/ilike",
		data:{"pid":sendPid},
		dataType:"json",
		success:function(data){
			if(data.code==1){
				drawhotNum(sendPid)
			}else{
				alert(data.msg)
			}
		}
	})
}
function drawhotNum(id){
	var sendPid = id-1
	$.ajax({
		type:"POST",
		url:BASEURL + "/sampling/ilikelist",
		data:{},
		dataType:"json",
		success:function(data){
			if(data.code==1){
				var hotnumber = parseInt(data.msg[sendPid].num)+100
				$('#loveNum').text(hotnumber)
			}else{
				alert(data.msg)
			}
		}
	})
}

// 阅读
function addread(id){
	var sendPid = id
	$.ajax({
		type:"POST",
		url:BASEURL + "/sampling/read",
		data:{"pid":sendPid},
		dataType:"json",
		success:function(data){
			if(data.code==1){
				drawreadNum(sendPid)
			}else{
				alert(data.msg)
			}
		}
	})
}
function drawreadNum(id){
	var sendPid = id-1
	$.ajax({
		type:"POST",
		url:BASEURL + "/sampling/readlist",
		data:{},
		dataType:"json",
		success:function(data){
			if(data.code==1){
				var readNum = parseInt(data.msg[sendPid].num)+100
				$('#readNum').text(readNum)
			}else{
				alert(data.msg)
			}
		}
	})
}

function drawActiveNum(){
	$.ajax({
		type:"POST",
		url:BASEURL+"/sampling/count",
		data:{},
		dataType:"json",
		success:function(data){
			if(data.code==1){
				var num = 5681+parseInt(data.msg)
				$('#activemmNum').text(num)
			}else{
				alert(data.msg)
			}
		}
	})
}

// 分享
function getPrizeshareSina(){
	//var BASEERURL=""
	var url = "http://www.similacchina.com/sampling"
	var pic = "http://www.similacchina.com/images/sampling/sampling_share.jpg"
	var text = "我刚刚参加#美国雅培Similac时时派#活动，赢得了1罐美国雅培Similac Go & Grow (9-24个月) 配方奶粉和1组天猫旗舰店优惠券。现在和@美国雅培Similac官方旗舰 把好运传递给你们，快去试试运气吧！"
    window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(text)
        +'&pic='+encodeURIComponent(pic)
        +'&url='+encodeURIComponent(url),'_blank');
}

function noPrizeshareSina(){
	//var BASEERURL="www.similacchina.com"
	var url = "http://www.similacchina.com/sampling"
	var pic = "http://www.similacchina.com/images/sampling/sampling_share.jpg"
	var text = "#美国雅培Similac时时派#活动开始啦！摇一摇即刻开奖，3600罐美国雅培Similac Go & Grow (9-24个月) 配方奶粉等你来赢！还有更多精美好礼，快来试试运气吧！ @美国雅培Similac官方旗舰"
    window.open('http://v.t.sina.com.cn/share/share.php?title='+encodeURIComponent(text)
        +'&pic='+encodeURIComponent(pic)
        +'&url='+encodeURIComponent(url),'_blank');
}

function drawPrizeList(searchid,dayid){
	var searchid = searchid;
	var dayid = dayid;
	var htmlStr = '';
	var selStr = '';
	var dtHtml = '';
	for(var i=19;i>=1;i--){
		selStr += '<a href="javascript:void(0)" data-value="'+i+'">第'+i+'期</a>'
	}
	$('#select_dd').html(selStr);

	if(dayid!==''){
		dtHtml = '第'+dayid+'期';
	}else{
		dtHtml = '';
	}
	
	

	$('#select_dd a').each(function(e){
		$(this).click(function(){
			$('#select_dd').hide()
			drawPrizeList('',$('#select_dd a').eq(e).attr('data-value'))
		})
	})
	$.ajax({
		type:"post",
		url:BASEURL+"/sampling/lotteryList",
		data:{"search":searchid,"pici":dayid},
		dataType:"json",
		success:function(data){
			if(data.code==1){
				if(ifsearchPrize){
					if(data.msg==''){
						htmlStr += '<p class="wrong_p">您不在中奖名单中，欢迎您继续参加活动，赢取丰厚奖品</p>'
					}else{
						htmlStr += '<div id="scrollbar2"><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><div class="viewport"><div class="overview">';
						for(var i=0; i<data.msg.length; i++){
							var phone = data.msg[i].mobile;
				            var mphone =phone.substr(3,5);
				            var lphone = phone.replace(mphone,"*****");
							htmlStr += '<ul><li class="li_name">'+data.msg[i].name+'</li><li class="li_phone">'+lphone+'</li><br class="clearfix"></ul>';
						}
						htmlStr += '</div></div></div>';
					}
					ifsearchPrize = false;
				}else{
					htmlStr += '<div id="scrollbar2"><div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div><div class="viewport"><div class="overview">';
					for(var i=0; i<data.msg.length; i++){
						var phone = data.msg[i].mobile;
			            var mphone =phone.substr(3,5);
			            var lphone = phone.replace(mphone,"*****");
						htmlStr += '<ul><li class="li_name">'+data.msg[i].name+'</li><li class="li_phone">'+lphone+'</li><br class="clearfix"></ul>';
					}
					htmlStr += '</div></div></div>';
				}
				$('#select_dt').html(dtHtml)
				//var dtDate = data.date.replace(/年/,'-').replace(/月/,'-').replace(/日/,'')
				//$('#select_dt').attr('date-value',dtDate)
				$('.list_cont').html(htmlStr)
				$('#scrollbar2').tinyscrollbar({size:220,sizethumb:41});
			}else{
				$('.list_cont').html('<p class="wrong_p">'+data.msg+'</p>')
			}
		}
	})
}

function searchPrize(){
	ifsearchPrize = true;
	var num = $('#search_input').val()
	if(num=='请输入您的姓名/手机号码'){
		num=''
	}
	//var day = $('#select_dt').attr('date-value')
	drawPrizeList(num,'')
}



