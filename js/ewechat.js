var Ewechat=window.Ewechat||new function(){
	var self=this;
	var img_width="640";
	var img_height="640";
	var waiteCallGroup=[];
	var imageView=null;
	var waiteNetworkType=[];
	/**
     * 判断是否微信内置浏览器
     */
	this.isWechat=(navigator.userAgent.toLowerCase().match(/MicroMessenger/i)=="micromessenger");
	/**
     * 微信分享 API 是否准备就绪
     */
	this.readyBridge=function(){return (typeof window.WeixinJSBridge!="undefined")};
	/**
     * 朋友圈分享、朋友分享、微博分享 (分享信息)
     * @appid   appid可以为空值
     * @img_url 分享的图片地址
     * @link    分享的URL地址
     * @desc    分享内容
     * @title   分享标题
     */
	this.timelineShareinfo={};
	this.appmessageShareinfo={};
	this.weiboShareinfo={};
	/**
	 *同时设置全部分享类型中的分享信息
	 *@shareinfoobject 参数类似 {appid:"myAppid",img_url:"xxx.jpg",link:"http://xxx.com",desc:"分享的内容",title:"分享的标题"}
	 */
	this.setShareInfo=function(shareinfoobject){
		self.clearShareInfo();
		for(var i in shareinfoobject){
			self.timelineShareinfo[i]=self.appmessageShareinfo[i]=self.weiboShareinfo[i]=shareinfoobject[i];
		}
	}
	/**
	 *清除所有的分享信息
	 */
	this.clearShareInfo=function(){
		self.timelineShareinfo={};
		self.appmessageShareinfo={};
		self.weiboShareinfo={};
	}
	/**
	 *同时设置单项分享信息参数
	 *@value String 对应的信息值
	 */
	this.setAppid=function(value){
		self.timelineShareinfo["appid"]=self.appmessageShareinfo["appid"]=self.weiboShareinfo["appid"]=value;
	}
	this.setImgUrl=function(value){
		self.timelineShareinfo["img_url"]=self.appmessageShareinfo["img_url"]=self.weiboShareinfo["img_url"]=value;
	}
	this.setLink=function(value){
		self.timelineShareinfo["link"]=self.appmessageShareinfo["link"]=self.weiboShareinfo["link"]=value;
	}
	this.setDesc=function(value){
		self.timelineShareinfo["desc"]=self.appmessageShareinfo["desc"]=self.weiboShareinfo["desc"]=value;
	}
	this.setTitle=function(value){
		self.timelineShareinfo["title"]=self.appmessageShareinfo["title"]=self.weiboShareinfo["title"]=value;
	}
	/**
	 *timelineCallbacks 分享朋友圈回调集合  appmessageCallbacks 分享朋友回调集合 weiboCallbacks 分享微博回调集合
	 *回调集合可配置的键值 ready:func(argv)--就绪状态  cancel:func(resp)--取消  fail:func(resp)--失败  confirm:func(resp)--成功  all:func(resp)--除ready的任何情况都回调
	 */
	this.timelineCallbacks={};
	this.appmessageCallbacks={};
	this.weiboCallbacks={};
	/**
	 *设置所有的回调集合
	 *@callbackobject {ready:func,cancel:func,fail:func,confirm:func,all:func}; 可以只配置部分或不配置回调
	 */
	this.setCallbacks=function(callbackobject){
		self.clearCallbacks();
		for(var i in callbackobject){
			self.timelineCallbacks[i]=self.appmessageCallbacks[i]=self.weiboCallbacks[i]=callbackobject[i];
		}
	}
	/**
	 *清除所有的回调集合
	 */
	this.clearCallbacks=function(){
		self.timelineCallbacks={};
		self.appmessageCallbacks={};
		self.weiboCallbacks={};
	}
	/**
	 *设置单项回调处理
	 *@func 回调处理函数
	 */
	this.setReadyCallback=function(func){
		self.timelineCallbacks["ready"]=self.appmessageCallbacks["ready"]=self.weiboCallbacks["ready"]=func;
	}
	this.setCancelCallback=function(func){
		self.timelineCallbacks["cancel"]=self.appmessageCallbacks["cancel"]=self.weiboCallbacks["cancel"]=func;
	}
	this.setFailCallback=function(func){
		self.timelineCallbacks["fail"]=self.appmessageCallbacks["fail"]=self.weiboCallbacks["fail"]=func;
	}
	this.setConfirmCallback=function(func){
		self.timelineCallbacks["confirm"]=self.appmessageCallbacks["confirm"]=self.weiboCallbacks["confirm"]=func;
	}
	this.setAllCallback=function(func){
		self.timelineCallbacks["all"]=self.appmessageCallbacks["all"]=self.weiboCallbacks["all"]=func;
	}
	/**
     * 调起微信Native的图片播放组件。
     * 这里必须对参数进行强检测，如果参数不合法，直接会导致微信客户端crash
     *
     * @param {String} curSrc 当前播放的图片地址
     * @param {Array} srcList 图片地址列表
     */
    this.imagePreview=function(curSrc,srcList) {
        if(!self.isWechat||!curSrc || !srcList || srcList.length == 0)return;
        imageView={
        	'current' : curSrc,
            'urls' : srcList
        }
        if(self.readyBridge()){
			WeixinJSBridge.invoke('imagePreview',imageView);
			imageView=null;
        }
    }
	/**
     * 显示网页右上角的按钮
     */
	this.showOptionMenu=function(){
		if(!self.isWechat)return;
		if(self.readyBridge()){
			WeixinJSBridge.call('showOptionMenu');
		}else{
			waiteCallGroup.push("showOptionMenu");
		}
	}
	/**
     * 隐藏网页右上角的按钮
     */
	this.hideOptionMenu=function(){
		if(!self.isWechat)return;
		if(self.readyBridge()){
			WeixinJSBridge.call('hideOptionMenu');
		}else{
			waiteCallGroup.push("hideOptionMenu");
		}
	}
	/**
     * 显示底部工具栏
     */
	this.showToolbar=function(){
		if(!self.isWechat)return;
		if(self.readyBridge()){
			WeixinJSBridge.call('showToolbar');
		}else{
			waiteCallGroup.push("showToolbar");
		}
	}
	/**
     * 隐藏底部工具栏
     */
	this.hideToolbar=function(){
		if(!self.isWechat)return;
		if(self.readyBridge()){
			WeixinJSBridge.call('hideToolbar');
		}else{
			waiteCallGroup.push("hideToolbar");
		}
	}
	/**
     * 获取网络类型
     *@callback function 获取到网络类型后的回调处理函数
     */
	this.getNetworkType=function(callback){
		if(!self.isWechat)return;
		if (callback && typeof callback == 'function') {
			if(self.readyBridge()){
				WeixinJSBridge.invoke('getNetworkType', {}, function (e) {
	                /**
				     * 返回如下几种类型：
				     * network_type:wifi     wifi网络
				     * network_type:edge     非wifi,包含3G/2G
				     * network_type:fail     网络断开连接
				     * network_type:wwan     2g或者3g
				     */
	                callback(e.err_msg);
	            });
			}else{
				waiteNetworkType.push(callback);
			}
        }
	}
	/**
	 *朋友圈分享处理
	 */
	var shareTimeline = function (argv) {
		self.timelineCallbacks.ready && self.timelineCallbacks.ready(argv);
        WeixinJSBridge.invoke('shareTimeline', {
            "appid":self.timelineShareinfo.appid ? self.timelineShareinfo.appid : '',
            "img_url":self.timelineShareinfo.img_url,
            "link":self.timelineShareinfo.link,
            "desc":self.timelineShareinfo.desc,
            "title":self.timelineShareinfo.title,
            "img_width":img_width,
            "img_height":img_height
        }, function (resp) {
            switch (resp.err_msg) {
                // share_timeline:cancel 用户取消
                case 'share_timeline:cancel':
                    self.timelineCallbacks.cancel && self.timelineCallbacks.cancel(resp);
                    break;
                // share_timeline:fail　发送失败
                case 'share_timeline:fail':
                    self.timelineCallbacks.fail && self.timelineCallbacks.fail(resp);
                    break;
                // share_timeline:confirm 发送成功
                case 'share_timeline:confirm':
                case 'share_timeline:ok':
                    self.timelineCallbacks.confirm && self.timelineCallbacks.confirm(resp);
                    break;
            }
            self.timelineCallbacks.all && self.timelineCallbacks.all(resp);
        });
    };
    /**
	 *朋友分享处理
	 */
    var sendAppMessage = function (argv) {
    	self.appmessageCallbacks.ready && self.appmessageCallbacks.ready(argv);
        WeixinJSBridge.invoke('sendAppMessage', {
            "appid":self.appmessageShareinfo.appid ? self.appmessageShareinfo.appid : '',
            "img_url":self.appmessageShareinfo.img_url,
            "link":self.appmessageShareinfo.link,
            "desc":self.appmessageShareinfo.desc,
            "title":self.appmessageShareinfo.title,
            "img_width":img_width,
            "img_height":img_height
        }, function (resp) {
            switch (resp.err_msg) {
                // send_app_msg:cancel 用户取消
                case 'send_app_msg:cancel':
                    self.appmessageCallbacks.cancel && self.appmessageCallbacks.cancel(resp);
                    break;
                // send_app_msg:fail　发送失败
                case 'send_app_msg:fail':
                    self.appmessageCallbacks.fail && self.appmessageCallbacks.fail(resp);
                    break;
                // send_app_msg:confirm 发送成功
                case 'send_app_msg:confirm':
                case 'send_app_msg:ok':
                    self.appmessageCallbacks.confirm && self.appmessageCallbacks.confirm(resp);
                    break;
            }
            self.appmessageCallbacks.all && self.appmessageCallbacks.all(resp);
        });
    };
    /**
	 *微博分享处理
	 */
    var shareWeibo = function (argv) {
    	self.weiboCallbacks.ready && self.weiboCallbacks.ready(argv);
        WeixinJSBridge.invoke('shareWeibo', {
            "content":self.weiboShareinfo.desc,
            "url":self.weiboShareinfo.link
        }, function (resp) {
            switch (resp.err_msg) {
                // share_weibo:cancel 用户取消
                case 'share_weibo:cancel':
                    self.weiboCallbacks.cancel && self.weiboCallbacks.cancel(resp);
                    break;
                // share_weibo:fail　发送失败
                case 'share_weibo:fail':
                    self.weiboCallbacks.fail && self.weiboCallbacks.fail(resp);
                    break;
                // share_weibo:confirm 发送成功
                case 'share_weibo:confirm':
                case 'share_weibo:ok':
                    self.weiboCallbacks.confirm && self.weiboCallbacks.confirm(resp);
                    break;
            }
            self.weiboCallbacks.all && self.weiboCallbacks.all(resp);
        });
    };
    /**
	 *微信分享准备就绪初始化处理函数
	 */
	function onBridgeReady(){
		WeixinJSBridge.on('menu:share:timeline', shareTimeline);
        WeixinJSBridge.on('menu:share:appmessage', sendAppMessage);
        WeixinJSBridge.on('menu:share:weibo',shareWeibo);

        while(waiteCallGroup.length){
        	WeixinJSBridge.call(waiteCallGroup.shift()+'');
        }

        while(waiteNetworkType.length){
        	self.getNetworkType(waiteNetworkType.shift());
        }
        
        if(imageView!=null){
        	WeixinJSBridge.invoke('imagePreview',imageView);
			imageView=null;
        }
	}
	/**
	 *判断执行 wechatBridge
	 */
	if(self.isWechat){
		if(self.readyBridge()){
			onBridgeReady();
		}else{
			if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
                document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
            }
		}
	}
}