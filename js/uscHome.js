var Opt = 0,
	MaxNumb = 5,
	slideTimer = null,
	timeStep = 4000;

function slideAc()
{
    this.target = $('#slideDiv');
    $('#homeNav li a').eq(Opt).addClass('current');
    this.Sec = 1000;
}

slideAc.prototype = {
	Left : function() {
		var oldId = Opt;
		this.target.children('ul').eq(oldId).hide();
		$('#homeNav li a').eq(Opt).removeClass('current');
	    Opt = (Opt<=0)?4:--Opt;
	    this.target.children('ul').eq(Opt).fadeIn();
	    $('#homeNav li a').eq(Opt).addClass('current');
	},
	Right : function(){
		var oldId = Opt;
		this.target.children('ul').eq(oldId).hide();
		$('#homeNav li a').eq(Opt).removeClass('current');
		Opt = (Opt>=4)?0:++Opt;
		this.target.children('ul').eq(Opt).fadeIn();
		$('#homeNav li a').eq(Opt).addClass('current');
	},
	Click : function(id){
		var oldId = Opt;
		this.target.children('ul').eq(oldId).hide();
		$('#homeNav li a').eq(Opt).removeClass('current');
		Opt = id;
		this.target.children('ul').eq(Opt).fadeIn();
		$('#homeNav li a').eq(Opt).addClass('current');
	},
	AutoPlay:function(){
		var oldId = Opt;
		$('#slideDiv').children('ul').eq(oldId).hide();
		$('#homeNav li a').eq(Opt).removeClass('current');
		Opt = (Opt>=(MaxNumb-1))?0:++Opt;
		$('#slideDiv').children('ul').eq(Opt).fadeIn();
		$('#homeNav li a').eq(Opt).addClass('current');
	},
	Init:function(){
		$('#slideDiv_cell_'+(Opt+1)).show();
		$('#homeNav li a').eq(Opt).addClass('current');
		slideTimer = setInterval(slideBtn.AutoPlay,timeStep);
		$('#homeNav li').each(function(i){
			$(this).mouseenter(function(event){
				if(slideTimer!=null){
					clearInterval(slideTimer);
				}
				slideBtn.Click(i);
			}).mouseleave(function(event) {
				slideTimer = setInterval(slideBtn.AutoPlay,timeStep);
			});
		})
	}
}

var slideBtn = new slideAc;
slideBtn.Init();
