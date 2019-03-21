// 轮播图
    function banner() {
       var container = $('#container');
        var list = $('#list');
        var buttons = $('#buttons span');
        var prev = $('#prev');
        var next = $('#next');
        var index = 1;
        var len = 5;
        var interval = 3000;
        var timer;
        function animate (offset) {
            var left = parseInt(list.css('left')) + offset;
            if (offset>0) {
                offset = '+=' + offset;
            }
            else {
                offset = '-=' + Math.abs(offset);
            }
            list.animate({'left': offset}, 300, function () {
                if(left > -200){
                    list.css('left', -800 * len);
                }
                if(left < (-800 * len)) {
                    list.css('left', -800);
                }
            });
        }

        function showButton() {
            buttons.eq(index-1).addClass('on').siblings().removeClass('on');
        }

        function play() {
            timer = setTimeout(function () {
                next.trigger('click');
                play();
            }, interval);
        }
        function stop() {
            clearTimeout(timer);
        }

        next.bind('click', function (event) {
            if (list.is(':animated')) {
                return;
            }
            if (index == 5) {
                index = 1;
            }
            else {
                index += 1;
            }
            animate(-800);
            showButton();
             event.stopPropagation();
        });

        prev.bind('click', function (event) {
            if (list.is(':animated')) {
                return;
            }
            if (index == 1) {
                index = 5;
            }
            else {
                index -= 1;
            }
            animate(800);
            showButton();
             event.stopPropagation();
        });

        buttons.each(function () {
             $(this).bind('click', function (event) {
                 if (list.is(':animated') || $(this).attr('class')=='on') {
                     return;
                 }
                 var myIndex = parseInt($(this).attr('index'));
                 var offset = -800 * (myIndex - index);

                 animate(offset);
                 index = myIndex;
                 showButton();
                event.stopPropagation();
             })
        });

        container.hover(stop, play);
        play();
    }
    banner();
// 生鲜分类
function navban() {
	var tab = $("#tab_head").find('.tab_head_item');
	var tab_body = $('#tab_body .tab_head_item')
	tab.on('mouseenter', function(event) {
		var m = $(this);
		m.addClass('active');
		m.find('.bgw').show();
		m.prev().children().css('border', 'none');
		m.children().css('border', 'none');
		m.find('.tab_body').removeClass('none');
	})
	.on('mouseleave', function(event) {
		var m = $(this);
		m.removeClass('active');
		m.find('.bgw').hide();
		m.prev().children().css('border-bottom', '1px dotted #ddd');
		m.children().css('border-bottom', '1px dotted #ddd');
		m.find('.tab_body').addClass('none');
	});
}
navban();
// 限时抢购
function Flash_sale(argument) {
       var tabNav = $('#tab_head_item').find('.tab_head_item');
       // console.log(tabNav.length);
       var tabWrap = $('#tab_body').find('.slider_list');
       // console.log(tabWrap.length);
       if (tabNav.length != tabWrap.length) {
        return ;
       }else{
        tabNav.on('click', function(event) {
          var i = $(this).index();
          tabNav.eq(i).addClass('active').siblings().removeClass('active');
         tabWrap.eq(i).removeClass('none').siblings().not('.tabv').addClass('none');
        });
       }
     }
     Flash_sale();

 // 身临其境
 function tabnav() {
 	var fresh_slim_tab = $('#fresh_slim_tab').find('.tab_head .tab_head_item');
 	var tab_body = $('#fresh_slim_tab').find('.tab_body .tab_body_item');
 	var tab_img = $('#fresh_slim_tab').find('.tab_body .tab_body_item .goods_item_link');
 	if (fresh_slim_tab.length = tab_body.length) {
 		fresh_slim_tab.on('click', function(event) {
 			var i = $(this).index();
 		   $(this).addClass('active').siblings().removeClass('active');
 		   tab_body.eq(i).removeClass('none').siblings().addClass('none');
 		
 	});
 }else{
 		return;
 	}
 goods_mouse_e(tab_img);
 	}
 tabnav();
 // 商品分类
 function goods_category() {
 	var goods_item_img = $('.fresh_category_body').find('.goods_item .goods_item_link');
 	goods_mouse_e(goods_item_img);
 }
 goods_category();
// 鼠标经过商品事件
 function goods_mouse_e(a) {
 	a.on('mouseenter', function(event) {
 	$(this).children('.goods_item_img').animate({top:'-3px'});
 	$(this).children('.goods_item_name').css('color', '#33d17d');
 })
 .on('mouseleave', function(event) {
 	$(this).children('.goods_item_img').animate({top:'3px'});
 	$(this).children('.goods_item_name').css('color', '#222');
 });
 }
 // 楼层导航
    function menuNav() {
       //1.楼梯什么时候显示，800px scroll--->scrollTop
        // var $top = $('#offsetTop').offset().top;
        var list_li =$('#mod_lift_11 .mod_lift_list').find('.J_lift');
          $(window).on('scroll',function(){
            var $scroll=$(this).scrollTop();
            if($scroll>=500){
                $('#mod_lift_11').show();
            }else{
                $('#mod_lift_11').hide();
            }
            // 4.拖动滚轮，对应的楼梯样式进行匹配
            var len =  $('.J_floor:lt(4)');
            console.log(len.length);
            for (var i = 0; i < len.length; i++) {
                var $loutitop=$('.J_floor').eq(i).offset().top;
                if($loutitop>$scroll){//楼层的top大于滚动条的距离
                    list_li.removeClass('active2');
                    list_li.eq(i).addClass('active2');
                    return false;//中断循环
                }
            }
        });
        //2.获取每个楼梯的offset().top,点击楼梯让对应的内容模块移动到对应的位置  offset().left
       
        list_li.on('click',function(){
            $(this).addClass('active2').siblings('li').removeClass('active2');
            var $loutitop=$('.J_floor').eq($(this).index()).offset().top-100;
            // $(window).off('scroll');
            //获取每个楼梯的offsetTop值
            $('html,body').animate({//$('html,body')兼容问题body属于chrome
                scrollTop:$loutitop
            })
        });
        //3.回到顶部
        $('#mod_lift_11 .mod_lift_top').on('click',function(){
            $('html,body').animate({//$('html,body')兼容问题body属于chrome
                scrollTop:0
            })
    });
     }    
    menuNav();
