
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
 // 优品集合
 function tabnav() {
 	var fresh_slim_tab = $('#mod_scroll_floor').find('.more_body .tab_head_item');
 	var tab_body = $('#mod_scroll_floor').find('.tab_body .tab_body_item');
 	if (fresh_slim_tab.length = tab_body.length) {
 		fresh_slim_tab.on('click', function(event) {
 			var i = $(this).index();
 		   $(this).addClass('active').siblings().removeClass('active');
 		   tab_body.eq(i).removeClass('none').siblings().addClass('none');
 		
 	});
 }else{
 		return;
 	}
 	}
 tabnav();
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
            var len =  $('.J_floor');
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
