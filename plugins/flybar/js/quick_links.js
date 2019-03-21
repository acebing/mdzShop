jQuery(function($){
	//创建DOM
	var 
	quickHTML = document.querySelector("div.quick_link_mian"),
	quickShell = $(document.createElement('div')).html(quickHTML).addClass('quick_links_wrap'),
	quickLinks = quickShell.find('.quick_links');
	quickPanel = quickLinks.next();
	quickShell.appendTo('.mui-mbar-tabs');
	
	//具体数据操作 
	var 
	quickPopXHR,
	quickPop = quickShell.find('#quick_links_pop'),
	quickDataFns = {
		//购物信息
		message_list: {
			title: '购物车',
			content: '<div class="ibar_plugin_content"><div class="ibar_cart_group ibar_cart_product"><ul><li class="cart_item"><div class="cart_item_pic"><a href="#"><img src="images/xiez.jpg" /></a></div><div class="cart_item_desc"><a href="#" class="cart_item_name">夏季透气真皮豆豆鞋反绒男士休闲鞋韩版磨砂驾车鞋英伦船鞋男鞋子</a><div class="cart_item_sku"><span>尺码：38码（精工限量版）</span></div><div class="cart_item_price"><span class="cart_price">￥700.00</span></div></div>	</li></ul></div><div class="cart_handler"><div class="cart_handler_header"><span class="cart_handler_left">共<span class="cart_price">1</span>件商品</span><span class="cart_handler_right">￥569.00</span></div><a href="#" class="cart_go_btn" target="_blank">去购物车结算</a></div></div>',
			init:$.noop
		},
		//我的资产
		history_list: {
			title: '我的资产',
			content: '<div class="ibar_plugin_content"><div class="ia-head-list"><a href="#" target="_blank" class="pl"><div class="num">0</div><div class="text">优惠券</div></a><a href="#" target="_blank" class="pl"><div class="num">0</div><div class="text">红包</div></a><a href="#" target="_blank" class="pl money"><div class="num">￥0</div><div class="text">余额</div></a></div><div class="ga-expiredsoon"><div class="es-head">即将过期优惠券</div><div class="ia-none">您还没有可用的现金券哦！</div></div><div class="ga-expiredsoon"><div class="es-head">即将过期红包</div><div class="ia-none">您还没有可用的红包哦！</div></div></div>			',
			init: $.noop
		},
		mpbtn_histroy:{
			title: '我的足迹',
			content:'<div class="ibar_plugin_content"><div class="ibar-history-head">共3件产品<a href="#">清空</a></div><div class="ibar-moudle-product"><div class="imp_item"><a href="#" class="pic"><img src="images/xiez.jpg" width="100" height="100" /></a><p class="tit"><a href="#">夏季透气真皮豆豆鞋反绒男士休闲鞋韩</a></p><p class="price"><em>￥</em>649.00</p><a href="#" class="imp-addCart">加入购物车</a></div><div class="imp_item"><a href="#" class="pic"><img src="images/xiez.jpg" width="100" height="100" /></a><p class="tit"><a href="#">夏季透气真皮豆豆鞋反绒男士休闲鞋韩</a></p><p class="price"><em>￥</em>649.00</p><a href="#" class="imp-addCart">加入购物车</a></div><div class="imp_item"><a href="#" class="pic"><img src="images/xiez.jpg" width="100" height="100" /></a><p class="tit"><a href="#">夏季透气真皮豆豆鞋反绒男士休闲鞋韩</a></p><p class="price"><em>￥</em>649.00</p><a href="#" class="imp-addCart">加入购物车</a></div></div></div>',
			init: $.noop
		},
		mpbtn_wdsc:{
			title: '收藏的产品',
			content: '<div class="ibar_plugin_content"><div class="ibar_cart_group ibar_cart_product"><ul><li class="cart_item"><div class="cart_item_pic"><a href="#"><img src="images/xiez.jpg" /></a></div><div class="cart_item_desc"><a href="#" class="cart_item_name">夏季透气真皮豆豆鞋反绒男士休闲鞋韩版磨砂驾车鞋英伦船鞋男鞋子</a><div class="cart_item_sku"><span>尺码：38码（精工限量版）</span></div><div class="cart_item_price"><span class="cart_price">￥700.00</span><a href="#" class="sc" title="删除"><img src="images/sc.png" alt="删除" /></a></div></div>	</li></ul></div><div class="cart_handler"><a href="#" class="cart_go_btn jiaru" target="_blank">加入购物车</a></div></div>',
			init: $.noop
		},
	};
	
	//showQuickPop
	var 
	prevPopType,
	prevTrigger,
	doc = $(document),
	popDisplayed = false,
	hideQuickPop = function(){
		if(prevTrigger){
			prevTrigger.removeClass('current');
		}
		popDisplayed = false;
		prevPopType = '';
		quickPop.hide();
		quickPop.animate({left:280,queue:true});
	},
	showQuickPop = function(type){
		if(quickPopXHR && quickPopXHR.abort){
			quickPopXHR.abort();
		}
		if(type !== prevPopType){
			var fn = quickDataFns[type];
			quickPop.html(ds.tmpl(popTmpl, fn));
			fn.init.call(this, fn);
		}
		doc.unbind('click.quick_links').one('click.quick_links', hideQuickPop);

		quickPop[0].className = 'quick_links_pop quick_' + type;
		popDisplayed = true;
		prevPopType = type;
		quickPop.show();
		quickPop.animate({left:0,queue:true});
	};
	quickShell.bind('click.quick_links', function(e){
		e.stopPropagation();
	});
	quickPop.delegate('a.ibar_closebtn','click',function(){
		quickPop.hide();
		quickPop.animate({left:280,queue:true});
		if(prevTrigger){
			prevTrigger.removeClass('current');
		}
	});

	//通用事件处理
	var 
	view = $(window),
	quickLinkCollapsed = !!ds.getCookie('ql_collapse'),
	getHandlerType = function(className){
		return className.replace(/current/g, '').replace(/\s+/, '');
	},
	showPopFn = function(){
		var type = getHandlerType(this.className);
		if(popDisplayed && type === prevPopType){
			return hideQuickPop();
		}
		showQuickPop(this.className);
		if(prevTrigger){
			prevTrigger.removeClass('current');
		}
		prevTrigger = $(this).addClass('current');
	},
	quickHandlers = {
		//购物车，最近浏览，商品咨询
		my_qlinks: showPopFn,
		message_list: showPopFn,
		history_list: showPopFn,
		mpbtn_histroy:showPopFn,
		mpbtn_wdsc:showPopFn,
		//返回顶部
		return_top: function(){
			ds.scrollTo(0, 0);
			hideReturnTop();
		}
	};
	quickShell.delegate('a', 'click', function(e){
		var type = getHandlerType(this.className);
		if(type && quickHandlers[type]){
			quickHandlers[type].call(this);
			e.preventDefault();
		}
	});
	
	//Return top
	var scrollTimer, resizeTimer, minWidth = 1350;

	function resizeHandler(){
		clearTimeout(scrollTimer);
		scrollTimer = setTimeout(checkScroll, 160);
	}
	
	function checkResize(){
		quickShell[view.width() > 1340 ? 'removeClass' : 'addClass']('quick_links_dockright');
	}
	function scrollHandler(){
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(checkResize, 160);
	}
	function checkScroll(){
		view.scrollTop()>100 ? showReturnTop() : hideReturnTop();
	}
	function showReturnTop(){
		quickPanel.addClass('quick_links_allow_gotop');
	}
	function hideReturnTop(){
		quickPanel.removeClass('quick_links_allow_gotop');
	}
	view.bind('scroll.go_top', resizeHandler).bind('resize.quick_links', scrollHandler);
	quickLinkCollapsed && quickShell.addClass('quick_links_min');
	resizeHandler();
	scrollHandler();
});