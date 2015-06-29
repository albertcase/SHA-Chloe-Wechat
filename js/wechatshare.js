function getStrFromTxtDom(selector) {
        var url = jQuery('#txt-' + selector).html().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
        return jQuery.trim(url);
    }

    function report_article() {
        var url = getStrFromTxtDom('sourceurl');
        if (url == "") url = location.href;
        var query = ['把乐带回家', location.href, getStrFromTxtDom('title'), url].join("|WXM|");
        location.href = '/mp/readtemplate?t=wxm-appmsg-inform&__biz=MzA4NzE1NzExNw==&info=' + encodeURIComponent(query) + "#wechat_redirect";
    }

    function getStrFromTxtDomAndDecode(selector) {
        var selectorStr = getStrFromTxtDom(selector);
        if (selectorStr.indexOf("://") < 0) selectorStr = "http://" + selectorStr;
        return 'http://' + window.location.host + '/mp/redirect?url=' + encodeURIComponent(selectorStr);
    }

    function viewSource() {
        jQuery.ajax({
            url: '/mp/appmsg/show-ajax' + location.search,
            //location.href
            async: false,
            type: 'POST',
            timeout: 2000,
            data: {
                url: getStrFromTxtDom('sourceurl')
            },
            complete: function() {
                location.href = getStrFromTxtDomAndDecode('sourceurl');
            }
        });
        return false;
    };
    function report(link, fakeid, action_type) {
        var parse_link = parseUrl(link);
        if (parse_link == null) {
            return;
        }
        var query_obj = parseParams(parse_link['query_str']);
        query_obj['action_type'] = action_type;
        query_obj['uin'] = fakeid;
        var report_url = '/mp/appmsg/show?' + jQuery.param(query_obj);
        jQuery.ajax({
            url: report_url,
            type: 'POST',
            timeout: 2000
        })
    };

    function share_scene(link, scene_type) {
        var parse_link = parseUrl(link);
        if (parse_link == null) {
            return link;
        }
        var query_obj = parseParams(parse_link['query_str']);
        query_obj['scene'] = scene_type;
        var share_url = 'http://' + parse_link['domain'] + parse_link['path'] + '?' + jQuery.param(query_obj) + (parse_link['sharp'] ? parse_link['sharp'] : '');
        return share_url;
    };

    (function() {
        //init()
    })();

    (function() {

        var cookie = {
            get: function(name) {
                if (name == '') {
                    return '';
                }
                var reg = new RegExp(name + '=([^;]*)');
                var res = document.cookie.match(reg);
                return (res && res[1]) || '';
            },
            set: function(name, value) {
                var now = new Date();
                now.setDate(now.getDate() + 1);
                var exp = now.toGMTString();
                document.cookie = name + '=' + value + ';expires=' + exp;
                return true;
            }
        };

        var timeout = null;
        var val = 0;
        var url = location.search.substr(1);
        // var params = parseParams(url);

        // window.onload

    })();

    function nbspDecode(str) {
        if (str == undefined) {
            return "";
        }
        var nbsp = "&nbsp;";
        var replaceFlag = "<nbsp>";
        var matchList = str.match(/(&nbsp;){1,}/g);
        if (matchList) {
            var replacedStr = str.replace(/(&nbsp;){1,}/g, replaceFlag);

            for (var idx = 0; idx < matchList.length; idx++) {
                var tmpNbsp = matchList[idx];
                tmpNbsp = tmpNbsp.replace(nbsp, " ");
                replacedStr = replacedStr.replace(replaceFlag, tmpNbsp);
            }
            return replacedStr;
        } else {
            return str;
        }
    }

  
    //弹出框中图片的切换
    (function() {
        var imgs = jQuery('img'),
        imgsSrc = [],
        minWidth = 0;
        imgs.each(function() {
            var jqthis = jQuery(this),
            src = jqthis.attr('data-src') || jqthis.attr('src');
            if (jqthis.width() >= minWidth && src) {
                imgsSrc.push(src);
                jqthis.on('click',
                function() {
                    reviewImage(src);
                });
            }
        });

        function reviewImage(src) {
            if (typeof window.WeixinJSBridge != 'undefined') {
                WeixinJSBridge.invoke('imagePreview', {
                    'current': src,
                    'urls': imgsSrc
                });
            }
        }
    })();

    // 图片延迟加载
    (function() {
        var timer = null;
        var height = jQuery(window).height() + 40;
        var images = [];
        function detect() {
            var scrollTop = jQuery(window).scrollTop() - 20;
            jQuery.each(images,
            function(idx, img) {
                var offsetTop = img.el.offset().top;
                if (!img.show && scrollTop < offsetTop + img.height && scrollTop + height > offsetTop) {
                    img.el.attr('src', img.src);
                    img.show = true;
                }
            });
        }
        jQuery('img').each(function() {
            var img = $(this);
            if (img.attr('data-src')) {
                images.push({
                    el: img,
                    top: img.offset().top,
                    src: img.attr('data-src'),
                    height: img.height(),
                    show: false
                });
            }
        });
        jQuery(window).on('scroll',
        function() {
            clearTimeout(timer);
            timer = setTimeout(detect, 100);
        });

        detect();
    })();
    function shareWechatInit(sharetitle,imgUrl,sharedesc,sharelink){
	
    	var onBridgeReady = function() {
            var appId = 'wx01c4b9ab6ea17178',
           // imgUrl = "http://mmbiz.qpic.cn/mmbiz/H5fia6b9UudXcqUyFdbWZRjlGAHqqPS5qDkDTwo5MIfZd73YLZBqVP3d9RmICl5J4Picwrh0bmwp1ZpQiaicu9uZ5A/0",
            link = sharelink,
            title = htmlDecode(sharetitle),
            desc = htmlDecode(sharedesc),
            fakeid = "MjM3MDE2NzQ0MQ==",
            desc = desc || sharelink;

            if ("1" == "0") {
                WeixinJSBridge.call("hideOptionMenu");
            }

 

            // 发送给好友; 
            WeixinJSBridge.on('menu:share:appmessage',
            function(argv) {

                WeixinJSBridge.invoke('sendAppMessage', {
                    "appid": appId,
                    "img_url": imgUrl,
                    "img_width": "640",
                    "img_height": "640",
                    "link": share_scene(link, 1),
                    "desc": desc,
                    "title": title
                },
                function(res) {
                    report(link, fakeid, 1);
                });
            });
            // 分享到朋友圈;
            WeixinJSBridge.on('menu:share:timeline',
            function(argv) {
                report(link, fakeid, 2);
                WeixinJSBridge.invoke('shareTimeline', {
                    "img_url":imgUrl,
                    "img_width": "640",
                    "img_height": "640",
                    "link": share_scene(link, 2),
                    "desc": desc,
                    "title": title
                },
                function(res) {});

            });

            // 分享到微博;
            var weiboContent = '';
            WeixinJSBridge.on('menu:share:weibo',
            function(argv) {

                WeixinJSBridge.invoke('shareWeibo', {
                    "content": title + share_scene(link, 3),
                    "url": share_scene(link, 3)
                },
                function(res) {
                    report(link, fakeid, 3);
                });
            });

            // 分享到Facebook
            WeixinJSBridge.on('menu:share:facebook',
            function(argv) {
                report(link, fakeid, 4);
                WeixinJSBridge.invoke('shareFB', {
                    "img_url": imgUrl,
                    "img_width": "640",
                    "img_height": "640",
                    "link": share_scene(link, 4),
                    "desc": desc,
                    "title": title
                },
                function(res) {});
            });

            // 隐藏右上角的选项菜单入口;
            //WeixinJSBridge.call('hideOptionMenu');
        };
        if (document.addEventListener) {
            document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
        } else if (document.attachEvent) {
            document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
            document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
        }	
    	
    	
    }