
var categoryHtml = "",categorylistHtmls = "", contentHtmls = "<div id='pupTips'><img src='"+baseUrl+"/cw/images/puptips.png' /></div>", allImgArr = [], menuArr = [], itemnum = 0;


var callback = function(contents, status){
	//console.log(contents)
	categoryHtml = $.map(contents,function(v,k){
		itemnum ++;
		categorylistHtmls = $.map(v,function(j,l){
			allImgArr.push(j.url);
			return '<div class="slide"><img src="'+j.url+'" style="width:109%" /></div>';
		}).join("");

		menuArr.push("item"+itemnum);
		contentHtmls += '<div class="section">'+categorylistHtmls+'</div>'
		return '<li data-menuanchor="item'+itemnum+'"><a href="#item'+itemnum+'">'+k+'</a></li>';
	}).join("");

	//console.log(contentHtmls);
	$("#menu ul").html(categoryHtml);
	$("#fullpage").html(contentHtmls);
	accfun();
	$("#pupTips").click(function(){
		$(this).hide();
		$(".burger").stop().animate({"left":"0"},function(){
			$(".burger").removeClass("hover");
		});
	})

    // console.log(contents);
    // console.log(err);
}

// $.post('Server.aspx', { id: idValue }, callback);

$.post( baseUrl+'/api/list', callback, "json");


function getAttention(){
	$.ajax({
	    type: "POST",
	    url: "/api/status",
	    dataType:"json"
    }).done(function(data){
		if(data.code == 0){

		}else{
			$(".qrcode").hide();
		}
    });
}


getAttention();


window.location.hash = '';


 $(".burger").bind("touchstart", function (event) {
 	if($(this).hasClass("hover")) return false;
	$("#mask").fadeIn();
	$(".burger").addClass("hover").stop().animate({"left":"-100px"},function(){
		$(".menu").show();

			TweenMax.staggerTo(".menu li", 0.3, {
				rotation:360,
				x:60, 
				y:30, 
				opacity:1,
				ease:SlowMo.ease.config(0.5, 0.4)
			}, 0.3);
		});
	event.stopPropagation();
	return false;
});

document.addEventListener('touchmove' , function (ev){
	ev.preventDefault();
	return false;
} , false)





function reduction_fun(){
	$(".menu,#mask").hide();
	TweenMax.staggerTo(".menu li", 0.1, {
		rotation:0,
		x:-60, 
		y:-30, 
		opacity:0,
		ease:Linear.easeNone
	}, 0.1);
	$(".burger").stop().animate({"left":"0"},function(){
		$(".burger").removeClass("hover");
	});
}



$("#mask").mousedown(function(event){
	reduction_fun();
	event.stopPropagation();
})

$("#mask").click(function(event){
	reduction_fun();
	event.stopPropagation();
})








function LoadFn ( arr , fn , fn2){
		var loader = new PxLoader();
		for( var i = 0 ; i < arr.length; i ++)
		{
			loader.addImage(arr[i]);
		};
		
		loader.addProgressListener(function(e) {
				var percent = Math.round( e.completedCount / e.totalCount * 100 );
				if(fn2) fn2(percent)
		});	
		
		
		loader.addCompletionListener( function(){
			if(fn) fn();	
		});
		loader.start();	
}




$('img').each( function (){
	if(!$(this).attr('src')) return;
	allImgArr.push($(this).attr('src'));		
});












function accfun(){

	if(!window.location.hash){
		LoadFn(allImgArr , function (){

			setTimeout( function (){

				TweenMax.staggerFromTo("#loading",1,{
					scale:1,
					y:0,
					x:0,
					autoAlpha:1,
					opacity:1
				},{
					scale:1,
					y:0,
					x:0,
					autoAlpha:0,
					opacity:0,
					easing: 'easeInOutCubic',
					onComplete:function(){
			        	homeAnimate_in();    
			        }
				},0.6)

				
				
			} , 200)

			console.log("加载完成！");
		} , function ( p ){
			$('.loading-mask').css({"width":p+"%"});
			//$('.loading-mask').html('<br />' + p + '%')
		});
	}else{
		// $('#loading').hide();
		// accfun();
	}

	


}








function swipeFun(){
      window.mySwipe = new Swipe(document.getElementById('slider'), {
      startSlide: 0,
      auto: false, //设置自动切换时间，单位毫秒
      continuous: false,
      disableScroll: false,
      stopPropagation: false
      })
}


swipeFun()


function homeAnimate_in(){
	$('#loading').hide();
	$(".arr").fadeIn();
	$(".logo").fadeIn();

	TweenMax.staggerFromTo(".slogan",0.6,{
		scale:1.4,
		x:0,
		y:0,
		autoAlpha:0,
		opacity:0
	},{
		scale:1,
		x:0,
		y:0,
		autoAlpha:1,
		opacity:1,
		easing: 'easeOutCubic',
		onComplete:function(){
        }
	},0.6)

}


function homeAnimate_out(){
	$(".logo").hide();
	TweenMax.staggerFromTo("#index_bg",0.6,{
		scale:1,
		x:0,
		y:0,
		autoAlpha:1,
		opacity:1
	},{
		scale:1.2,
		x:0,
		y:0,
		autoAlpha:0,
		opacity:0,
		easing: 'easeOutCubic',
		onComplete:function(){
        	$(".homepage").hide();
        	$("#fullpage").animate({"opacity":1},600);

        	$('#fullpage').fullpage({
					anchors: menuArr,    // 'lastPage', '6thPage'
					menu: '#menu',
					scrollingSpeed: 600,
					//easingcss3: 'cubic-bezier(0.175, 0.885, 0.320, 1.275)',
					//css3: true,
					fitToSection: true,
					resize : true,
					sectionSelector: '.section',
					easing: 'easeInOutCubic',
        			easingcss3: 'ease',
        			continuousVertical: true,
        			onLeave:function(){
        				$("#pupTips").hide();
						// $(".burger").stop().animate({"left":"0"},function(){
						// 	$(".burger").removeClass("hover");
						// });
        			}
			});
        }
	},0.6)

	TweenMax.staggerFromTo(".slogan",0.6,{
		scale:1,
		x:0,
		y:0,
		autoAlpha:1,
		opacity:1
	},{
		scale:1,
		x:0,
		y:0,
		autoAlpha:0,
		opacity:0,
		easing: 'easeOutCubic',
		onComplete:function(){
        }
	},0.6)

	TweenMax.staggerFromTo("#pupTips",0.3,{
		scale:1.2,
		x:0,
		y:0,
		autoAlpha:0,
		opacity:0
	},{
		scale:1,
		x:0,
		y:0,
		autoAlpha:1,
		opacity:1,
		easing: 'easeOutCubic',
		onComplete:function(){
			$(".burger").stop().animate({"left":"0"},function(){
				$(".burger").removeClass("hover");
			});
        }
		
	},0.3)

}


$(".slogan a").click(function(){
	homeAnimate_out();
})

$(".qrcodeImg").bind("touchstart", function (event) {
	event.stopPropagation();
	return false;
});


$(".qrcode, .close").bind("touchstart", function (event) {
 	$(".qrcode").hide();
 	event.stopPropagation();
	return false;
});




