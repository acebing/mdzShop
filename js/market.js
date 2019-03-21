$(function(){
	// 分类菜单
    function categorysMen(argument) {
       function sameSign(a,b) {
        return (a ^ b) >=0;
       }
       function vector(a,b) {
        return{
            x: b.x - a.x,
            y: b.y -a.y
        }
       }
       function vectorProduct(v1,v2) {
        return v1.x * v2.y - v2.x * v1.y
       }
       function isPointInTrangle(p,a,b,c) {
        var pa = vector(p,a);
        var pb = vector(p,b);
        var pc = vector(p,c);

        var t1 = vectorProduct(pa,pb);
        var t2 = vectorProduct(pb,pc);
        var t3 = vectorProduct(pc,pa);
        return sameSign(t1,t2) && sameSign(t2,t3);
       }

       function needDelay(elem,leftCorner,currMousePos) {
        var offset = elem.offset();
        var topLeft={
            x: offset.left,
            y: offset.top
        }
        var bottomLeft = {
            x: offset.left,
            y: offset.top + elem.height()
        }
        return isPointInTrangle(currMousePos,leftCorner,topLeft,bottomLeft)
       }

       var sub = $("#sub");
       var item = $("#categorys li");
       var activeRow;
       var activeMen;
       var timer;
       var mouseInSub = false;
       sub.on('mouseenter',function (e) {
        mouseInSub = true;
       }).on('mouseleave', function(e) {
        mouseInSub = false;
       });
       var mouseTrack = [];
       var moveHandler = function (e) {
        mouseTrack.push({
            x:e.pageX,
            y:e.pageY
        })
        if (mouseTrack.length>3) {
            mouseTrack.shift()
        }
       }
       $('#categorys')
       .on('mouseenter', function(event) {
        // sub.removeClass('none');
        $(document).bind('mousemove', moveHandler)
       })
       .on('mouseleave', function(event) {
        sub.addClass('none');
        if (activeRow) {
            activeRow.removeClass('active');
            activeRow = null;
        }
        if (activeMen) {
            activeMen.addClass('none');
            activeMen = null;
        }
        $(document).unbind('mousemove', moveHandler)
       })
       .on('mouseenter', 'li', function(e) {
        sub.removeClass("none");
        if (!activeRow) {
            activeRow = $(e.target).addClass('active');
            activeMen = $('#'+activeRow.data('id'));
            activeMen.removeClass('none');
            return;
        }
        if (timer) {
            clearTimeout(timer);
        }
        var currMousePos = mouseTrack[mouseTrack.length-1];
        var leftCorner = mouseTrack[mouseTrack.length-2];
        var delay = needDelay(sub,leftCorner,currMousePos);
        if (delay) {
            timer = setTimeout(function function_name(argument) {
            if (mouseInSub) {
                return;
            }
            activeRow.removeClass('active');
            activeMen.addClass('none');
            activeRow = $(e.target);
            activeRow.addClass('active');
            activeMen = $('#'+activeRow.data('id'));
            activeMen.removeClass('none');
            timer = null;
        }, 300);
        }else{
            var prevActiveRow = activeRow;
            var prevActiveMen = activeMen;
            activeRow = $(e.target);
            activeMen = $('#'+activeRow.data('id'));
            prevActiveRow.removeClass('active');
            prevActiveMen.addClass('none');
            activeRow.addClass('active');
            activeMen.removeClass('none');
        }
       })
        item.on('mouseover',  function(event) {
           $(this).addClass('cur');
           $(this).children('.split-line').hide();
           $(this).css('color', '#fff');
          
       })
       .on('mouseout',  function(event) {
           $(this).removeClass('cur');
          $(this).children('.split-line').show();
       });
    }
    categorysMen();
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
                    list.css('left', -1920 * len);
                }
                if(left < (-1920 * len)) {
                    list.css('left', -1920);
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
            animate(-1920);
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
            animate(1920);
            showButton();
             event.stopPropagation();
        });

        buttons.each(function () {
             $(this).bind('click', function (event) {
                 if (list.is(':animated') || $(this).attr('class')=='on') {
                     return;
                 }
                 var myIndex = parseInt($(this).attr('index'));
                 var offset = -1920 * (myIndex - index);

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
      // 鼠标经过，二级菜单显示
    function dorpdownLayer(a,b) {
        var dorpdown = $('#dorpdown');
        var layer = $('#layer');
        dorpdown.mouseenter(
            function(event) {
            layer.show();
            $(this).addClass('zindex');
        });
        dorpdown.mouseleave(
            function(event) {
            layer.hide();
            $(this).removeClass('zindex');
        });
    }
    dorpdownLayer();

    // 鼠标经过，购物车显示
    function shopLayer(argument) {
        var shopCart = $('#shopCart');
        var shopDorpdown = $('#shopDorpdown');
        var prompt =  $('#prompt');
        var settleup = $('#settleup');
        shopCart.mouseenter(
            function(event) {
            shopDorpdown.show();
            prompt.addClass('none');
            $(this).addClass('zindex');
        });
        shopCart.mouseleave(
            function(event) {
            shopDorpdown.hide();
            $(this).removeClass('zindex');
        });
    }
    shopLayer();
    // 搜索
    function search() {
        var suggestions = $('#suggestions_box');
       $('#earch_input').on('keyup',function(){
            suggestions.removeClass('none');
            $(document).on('click', function(event) {
                // e.stopPropagation()
           suggestions.addClass('none');
       });
         });
       
    }
    search();
    // 楼层导航
    function menuNav() {
       //1.楼梯什么时候显示，800px scroll--->scrollTop
        var list_li = $('#ECode-floatBar li');
         var len =  $('.main-floor');
          $(window).on('scroll',function(){
            var $scroll=$(this).scrollTop();
            if($scroll>=500){
                $('#ECode-floatBar').show();
            }else{
                $('#ECode-floatBar').hide();
            }
            // 4.拖动滚轮，对应的楼梯样式进行匹配
           
            for (var i = 0; i < len.length; i++) {
                var $loutitop=$('.main-floor').eq(i).offset().top;
                if($loutitop>$scroll){//楼层的top大于滚动条的距离
                    list_li.removeClass('on');
                    list_li.eq(i).addClass('on');
                    return false;//中断循环
                }
            }
        });
        //2.获取每个楼梯的offset().top,点击楼梯让对应的内容模块移动到对应的位置  offset().left
       
        list_li.on('click',function(){
            $(this).addClass('on').siblings('li').removeClass('on');
            var $loutitop=$('.main-floor').eq($(this).index()).offset().top-100;
            // $(window).off('scroll');
            //获取每个楼梯的offsetTop值
            $('html,body').animate({//$('html,body')兼容问题body属于chrome
                scrollTop:$loutitop,
            })
        });
        //3.回到顶部
        $('#goTop').on('click',function(){
            $('html,body').animate({//$('html,body')兼容问题body属于chrome
                scrollTop:0
            })
    });
     }    
    menuNav();
    // 头条鼠标经过
    $("#taday li").on('mouseover', function(event) {
     $(this).addClass('cur');
    });
     $("#taday li").on('mouseout', function(event) {
     $(this).removeClass('cur');
    });
     // 限时抢购
     function Flash_sale(argument) {
       var tabNav = $('#tab-nav ul li');
       // console.log(tabNav.length);
       var tabWrap = $('#tab-content-wrap .tab-content');
       if (tabNav.length != tabWrap.length) {
        return ;
       }else{
        tabNav.on('mouseover', function(event) {
          var i = $(this).index();
          tabNav.eq(i).addClass('cur').siblings().removeClass('cur');
         tabWrap.eq(i).removeClass('none').siblings().addClass('none');
        });
       }
     }
     Flash_sale();
     function ahover(ele) {
       $(".floor1").find('li').on('mouseover', function(event) {
         $(this).find('img').css('transform', 'scale(1.1)').next().css('color', '#e42e3c');
       });
        $(".floor1").find('li').on('mouseout', function(event) {
         $(this).find('img').css('transform', 'scale(1)').next().css('color', '#333');
       });
     }
     ahover();
       function ahover1(ele) {
       $(".rec-floor").find('li').on('mouseover', function(event) {
         $(this).find('img').css('transform', 'scale(1.1)').next().css('color', '#e42e3c');
       });
        $(".rec-floor").find('li').on('mouseout', function(event) {
         $(this).find('img').css('transform', 'scale(1)').next().css('color', '#333');
       });
     }
     ahover1();
});