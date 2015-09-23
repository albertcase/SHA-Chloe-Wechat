

var categoryHtml = "",categorylistHtmls = "", contentHtmls = "", allImgArr;


var callback = function(contents, status){
	//console.log(contents)
	categoryHtml = $.map(contents,function(v,k){
		//console.log(v);
		categorylistHtmls = $.map(v,function(j,l){
			allImgArr.push(j.url);
			return '<div class="slide"><img src="'+j.url+'" style="width:109%" /></div>';
		}).join("");

		contentHtmls += '<div class="section" id="'+k+'">'+categorylistHtmls+'</div>'
		return '<li data-menuanchor="'+k+'"><a href="#'+k+'">'+k+'</a></li>';
	}).join("");

	$("#menu ul").html(categoryHtml);
	$("#fullpage").html(contentHtmls);
    // console.log(contents);
    // console.log(err);
}

// $.post('Server.aspx', { id: idValue }, callback);

$.post( baseUrl+'/api/list', callback, "json");



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




$('img').each( function (){
	if(!$(this).attr('src')) return;
	allImgArr.push($(this).attr('src'));		
});



if(!window.location.hash){
	LoadFn(allImgArr , function (){
		setTimeout( function (){
			$('#loading').fadeOut();
			$(".arr").fadeIn();
			
			$.post( baseUrl+'/api/list', callback, "json");
		} , 200)
	} , function ( p ){
		$('.loading-mask').css({"width":p+"%"});
		//$('.loading-mask').html('<br />' + p + '%')
	});
}else{
	// $('#loading').hide();
	// accfun();
}










function accfun(){

	$('#fullpage').fullpage({
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










