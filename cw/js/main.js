var aa = {
	cc: {
		id: "1",
		list: {
			tid:"1",
			url:"/upload/details/detail1.jpg"
		}
	},
	details: {
		id: "2",
		list: {
			tid: "1",
			url: "/upload/details/detail1.jpg"
		}
	}
}

$.map(aa,function(v,k){
	// console.log(v);
	// console.log(k);
})


$.map(aa.cc.list,function(v,k){
	console.log(v);
	//console.log(k);
})

var looksInfo = {
	"1" : "l1",
	"2" : "l1",
	"5" : "l1",
	"4" : "l1",
	"10" : "l1",
	"33" : "l1",
	"21" : "l1",
	"24" : "l2",
	"26" : "l2",
	"28" : "l2",
	"6" : "l2",
	"16" : "l2",
	"23" : "l2",
	"22" : "l2",
	"20" : "l2",
	"15" : "l3",
	"17" : "l3",
	"7" : "l3",
	"31" : "l3",
	"14" : "l3",
	"19" : "l3",
	"25" : "l3",
	"13" : "l3",
	"29" : "l3",
	"11" : "l4",
	"39" : "l4",
	"8" : "l4",
	"18" : "l4",
	"37" : "l4",
	"9" : "l5",
	"3" : "l5",
	"32" : "l5",
	"12" : "l6",
	"34" : "l6",
	"35" : "l6",
	"38" : "l6",
	"40" : "l6",
	"42" : "l6",
	"43" : "l6",
	"23" : "l7",
	"30" : "l7",
	"36" : "l7",
	"41" : "l7",
	"44" : "l7",
	"45" : "l7"
}

var mapping_data = {
	"l1" : "以女性浪漫和清新田园风情为灵感基调，沿袭毫无刻意的法式时装精神，Chloé打造出新一季刚柔并济的活力女性形象。",
	"l2" : "散发女性意味的紫罗兰、米黄、矢车菊蓝与深色海军蓝、象牙白以及棕红色无间交织，在对比间赋予该系列时装灵动质感。",
	"l3" : "立体触感的面料贯穿始终，从柔软的格纹绒呢、挺阔的麦尔登呢、复古灯芯绒到浓密羊毛、精致暗色蟒蛇皮，以及浪漫的真丝绉和细腻蕾丝。",
	"l4" : "微微耸起的肩部细节，立体的剪裁，外套单品勾勒出新一季的加长廓形。加宽的前襟翻领设计、军装元素则平衡了蕾丝点缀丝绸释放出的女性柔美。",
	"l5" : "短小精干的马甲为飘逸的低领剪裁衬衫注入了率性和洒脱，与之搭配的花呢短裤与长裙更显时髦精致。",
	"l6" : "极富层次感的绉纱长裙与长裤周身四处以垂坠的棉绳点缀。",
	"l7" : "色彩鲜艳的拼接图案装点了细羊毛针织衫、丝绒面料上的精致提花则如冬季花园一般，散发令人难以抗拒的诱惑。"
}

function returnfun(a){
	var key = looksInfo[a];
	return mapping_data[key];
}




var modelname = [
"",
"Lorde",
"Olivia Palermo <br /> Johanns Huebl",
"Zhou Dongyu",
"Zhou Dongyu<br />Clare Waight Keller",
"Molly <br />Daniel de la Falaise",
"Poppy Delevigne",
"Ming Xi",
"Chiara Ferragni",
"Leaf Greener",
"Mimi Xu",
"Helena Bordon",
"Langley Fox",
"Anais Demoustier",
"Sonia Sieff",
"Sofia Sanchez Barrenechea",
"Elena Perminova",
"Leigh Lezark",
"Kristina Bazan",
"Marina Hands",
"Alexia Niedzielski <br />Elizabeth von Guttman",
"Kelly Rowland",
"Vashtie",
"Tina Leung",
"Kelly Rowland <br />Christine & the Queens",
"Christine & The Queens",
"Aymeline Valade",
"Clare Waight Keller <br />Christine & The Queens",
"Christine & The Queens <br />Lorde",
"Langley Fox <br />Dree Hemingway",
"#chloéGIRLS",
"#chloéGIRLS",
"Kelly Rowland <br /> Clare Waight Keller"];




var callback = function(contents, status){
	//console.log(contents)
	// $.map(contents,function(v,k){
	// 	console.log(v)
	// })
    // console.log(contents);
    // console.log(err);
}

// $.post('Server.aspx', { id: idValue }, callback);

$.post( baseUrl+'/api/list', callback);













window.location.hash= '';


$(".burger").click(function(event){
	$("#mask").fadeIn();
	$(".burger").animate({"left":"-100px"},100,function(){
		$(".menu").show();
	});
	event.stopPropagation();
})



    

	

document.addEventListener('touchmove' , function (ev){
	ev.preventDefault();
	return false;
} , false)




function reduction_fun(){
	$(".menu,#mask").fadeOut();
	$(".burger").animate({"left":"1em"});

	$(".magnifier-text").slideUp();
    $(".magnifier").stop().animate({"right":"3em","opacity":1});
}



$(document).mousedown(function(event){
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



var LoadingImg = [];

$('img').each( function (){
	if(!$(this).attr('src')) return;
	LoadingImg.push($(this).attr('src'));		
});


LoadingImg.push('upload/looks/look1.jpg');
LoadingImg.push('upload/looks/look2.jpg');
LoadingImg.push('upload/looks/look3.jpg');
LoadingImg.push('upload/looks/look4.jpg');
LoadingImg.push('upload/looks/look5.jpg');
LoadingImg.push('upload/looks/look6.jpg');
LoadingImg.push('upload/looks/look7.jpg');
LoadingImg.push('upload/looks/look8.jpg');
LoadingImg.push('upload/looks/look9.jpg');
LoadingImg.push('upload/looks/look10.jpg');
LoadingImg.push('upload/looks/look11.jpg');
LoadingImg.push('upload/looks/look12.jpg');
LoadingImg.push('upload/looks/look13.jpg');
LoadingImg.push('upload/looks/look14.jpg');
LoadingImg.push('upload/looks/look15.jpg');
LoadingImg.push('upload/looks/look16.jpg');
LoadingImg.push('upload/looks/look17.jpg');
LoadingImg.push('upload/looks/look18.jpg');
LoadingImg.push('upload/looks/look19.jpg');
LoadingImg.push('upload/looks/look20.jpg');
LoadingImg.push('upload/looks/look21.jpg');
LoadingImg.push('upload/looks/look22.jpg');
LoadingImg.push('upload/looks/look23.jpg');
LoadingImg.push('upload/looks/look24.jpg');
LoadingImg.push('upload/looks/look25.jpg');
LoadingImg.push('upload/looks/look26.jpg');
LoadingImg.push('upload/looks/look27.jpg');
LoadingImg.push('upload/looks/look28.jpg');
LoadingImg.push('upload/looks/look29.jpg');
LoadingImg.push('upload/looks/look30.jpg');
LoadingImg.push('upload/looks/look31.jpg');
LoadingImg.push('upload/looks/look32.jpg');
LoadingImg.push('upload/looks/look33.jpg');
LoadingImg.push('upload/looks/look34.jpg');
LoadingImg.push('upload/looks/look35.jpg');
LoadingImg.push('upload/looks/look36.jpg');
LoadingImg.push('upload/looks/look37.jpg');
LoadingImg.push('upload/looks/look38.jpg');
LoadingImg.push('upload/looks/look39.jpg');
LoadingImg.push('upload/looks/look40.jpg');
LoadingImg.push('upload/looks/look41.jpg');
LoadingImg.push('upload/looks/look42.jpg');
LoadingImg.push('upload/looks/look43.jpg');
LoadingImg.push('upload/looks/look44.jpg');
LoadingImg.push('upload/looks/look45.jpg');


LoadingImg.push('upload/acc/acc1.jpg');
LoadingImg.push('upload/acc/acc2.jpg');
LoadingImg.push('upload/acc/acc3.jpg');
LoadingImg.push('upload/acc/acc4.jpg');
LoadingImg.push('upload/acc/acc5.jpg');
LoadingImg.push('upload/acc/acc6.jpg');
LoadingImg.push('upload/acc/acc7.jpg');
LoadingImg.push('upload/acc/acc8.jpg');
LoadingImg.push('upload/acc/acc9.jpg');
LoadingImg.push('upload/acc/acc10.jpg');

LoadingImg.push('upload/backstage/backstage1.jpg');
LoadingImg.push('upload/backstage/backstage2.jpg');
LoadingImg.push('upload/backstage/backstage3.jpg');
LoadingImg.push('upload/backstage/backstage4.jpg');
LoadingImg.push('upload/backstage/backstage5.jpg');
LoadingImg.push('upload/backstage/backstage6.jpg');
LoadingImg.push('upload/backstage/backstage7.jpg');
LoadingImg.push('upload/backstage/backstage8.jpg');
LoadingImg.push('upload/backstage/backstage9.jpg');
LoadingImg.push('upload/backstage/backstage10.jpg');
LoadingImg.push('upload/backstage/backstage11.jpg');
LoadingImg.push('upload/backstage/backstage12.jpg');
LoadingImg.push('upload/backstage/backstage13.jpg');
LoadingImg.push('upload/backstage/backstage14.jpg');
LoadingImg.push('upload/backstage/backstage15.jpg');
LoadingImg.push('upload/backstage/backstage16.jpg');
LoadingImg.push('upload/backstage/backstage17.jpg');
LoadingImg.push('upload/backstage/backstage18.jpg');
LoadingImg.push('upload/backstage/backstage19.jpg');
LoadingImg.push('upload/backstage/backstage20.jpg');
LoadingImg.push('upload/backstage/backstage21.jpg');
LoadingImg.push('upload/backstage/backstage22.jpg');
LoadingImg.push('upload/backstage/backstage23.jpg');
LoadingImg.push('upload/backstage/backstage24.jpg');
LoadingImg.push('upload/backstage/backstage25.jpg');
LoadingImg.push('upload/backstage/backstage26.jpg');
LoadingImg.push('upload/backstage/backstage27.jpg');
LoadingImg.push('upload/backstage/backstage28.jpg');
LoadingImg.push('upload/backstage/backstage29.jpg');
LoadingImg.push('upload/backstage/backstage30.jpg');
LoadingImg.push('upload/backstage/backstage31.jpg');
LoadingImg.push('upload/backstage/backstage32.jpg');
LoadingImg.push('upload/backstage/backstage33.jpg');
LoadingImg.push('upload/backstage/backstage34.jpg');
LoadingImg.push('upload/backstage/backstage35.jpg');
LoadingImg.push('upload/backstage/backstage36.jpg');
LoadingImg.push('upload/backstage/backstage37.jpg');
LoadingImg.push('upload/backstage/backstage38.jpg');
LoadingImg.push('upload/backstage/backstage39.jpg');


LoadingImg.push('upload/details/detail1.jpg');
LoadingImg.push('upload/details/detail2.jpg');
LoadingImg.push('upload/details/detail3.jpg');
LoadingImg.push('upload/details/detail4.jpg');
LoadingImg.push('upload/details/detail5.jpg');


LoadingImg.push('upload/guests/guest1.jpg');
LoadingImg.push('upload/guests/guest2.jpg');
LoadingImg.push('upload/guests/guest3.jpg');
LoadingImg.push('upload/guests/guest4.jpg');
LoadingImg.push('upload/guests/guest5.jpg');
LoadingImg.push('upload/guests/guest6.jpg');
LoadingImg.push('upload/guests/guest7.jpg');
LoadingImg.push('upload/guests/guest8.jpg');
LoadingImg.push('upload/guests/guest9.jpg');
LoadingImg.push('upload/guests/guest10.jpg');
LoadingImg.push('upload/guests/guest11.jpg');
LoadingImg.push('upload/guests/guest12.jpg');
LoadingImg.push('upload/guests/guest13.jpg');
LoadingImg.push('upload/guests/guest14.jpg');
LoadingImg.push('upload/guests/guest15.jpg');
LoadingImg.push('upload/guests/guest16.jpg');
LoadingImg.push('upload/guests/guest17.jpg');
LoadingImg.push('upload/guests/guest18.jpg');
LoadingImg.push('upload/guests/guest19.jpg');
LoadingImg.push('upload/guests/guest20.jpg');
LoadingImg.push('upload/guests/guest21.jpg');
LoadingImg.push('upload/guests/guest22.jpg');
LoadingImg.push('upload/guests/guest23.jpg');
LoadingImg.push('upload/guests/guest24.jpg');
LoadingImg.push('upload/guests/guest25.jpg');
LoadingImg.push('upload/guests/guest26.jpg');
LoadingImg.push('upload/guests/guest27.jpg');
LoadingImg.push('upload/guests/guest28.jpg');
LoadingImg.push('upload/guests/guest29.jpg');
LoadingImg.push('upload/guests/guest30.jpg');
LoadingImg.push('upload/guests/guest31.jpg');
LoadingImg.push('upload/guests/guest32.jpg');
//LoadingImg.push('upload/guests/guest33.jpg');




if(!window.location.hash){
	LoadFn(LoadingImg , function (){
		setTimeout( function (){
			$('#loading').fadeOut();
			$(".arr").fadeIn();
			accfun();
		} , 200)
	} , function ( p ){
		$('.loading-mask').css({"width":p+"%"});
		//$('.loading-mask').html('<br />' + p + '%')
	});
}else{
	// $('#loading').hide();
	// accfun();
}









var accHtml = "";
var backstageHtml = "";
var detailsHtml = "";
var guestsHtml = "";
var looksHtml = "";
var looknum = 0;
var guestnum = 0;
function accfun(){

	$.map(LoadingImg,function(key,n){
		if(key.indexOf("acc")>0){
			accHtml+="<div class='slide'><img src='"+key+"' style='width:109%' /></div>"
		}else if(key.indexOf("backstage")>0){
			backstageHtml+="<div class='slide'><img src='"+key+"' style='width:109%' /></div>"
		}else if(key.indexOf("details")>0){
			detailsHtml+="<div class='slide'><img src='"+key+"' style='width:109%' /></div>"
		}else if(key.indexOf("guests")>0){
			guestnum++;
			guestsHtml+="<div class='slide'><span class='model_name'>"+modelname[guestnum]+"</span><img src='"+key+"' style='width:109%' /></div>"
		}else if(key.indexOf("looks")>0){
			looknum++;
			looksHtml+="<div class='slide'><img src='"+key+"' style='width:109%' /></div>"
		}
	})
   
	$("#details").empty().html(detailsHtml);
	$("#acc").empty().html(accHtml);
	$("#backstage").empty().html(backstageHtml);
	$("#guests").empty().html(guestsHtml);
	$("#looks").empty().html(looksHtml);

	$('#fullpage').fullpage({
			sectionsColor: ['#000', '#000', '#000', '#000', '#000'],
			anchors: ['firstPage', 'secondPage', '3rdPage', '4thPage', '5thPage', '6thPage'],    // 'lastPage', '6thPage'
			menu: '#menu',
			scrollingSpeed: 600,
			//easingcss3: 'cubic-bezier(0.175, 0.885, 0.320, 1.275)',
			css3: true,
			slidesNavigation: false,
			continuousVertical: true
	});

	$("#fullpage").animate({"opacity":1},600);

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










