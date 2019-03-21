$(function () {
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
        item.on('mouseleave',  function(event) {
           $(this).removeClass('itemhover');
       })
       .on('mouseenter',  function(event) {
           $(this).addClass('itemhover');
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
                    list.css('left', -758 * len);
                }
                if(left < (-758 * len)) {
                    list.css('left', -758);
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
            animate(-758);
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
            animate(758);
            showButton();
             event.stopPropagation();
        });

        buttons.each(function () {
             $(this).bind('click', function (event) {
                 if (list.is(':animated') || $(this).attr('class')=='on') {
                     return;
                 }
                 var myIndex = parseInt($(this).attr('index'));
                 var offset = -758 * (myIndex - index);

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
        var menu = $("#menu");
        var m_left = $("#menu").offset().left;
        var c_left = $("#h_content").offset().left;
        var left = Math.floor((c_left-m_left)/2);
        menu.css('left',left);
       $(window).scroll(function () {
            var items = $("#h_content").find(".item");
            
            var top = $(document).scrollTop();
            var currentId = ""; 
            if (top>686) {
                menu.removeClass('none')
                }
            if (top>3747||top<686) {
                    menu.addClass('none')
                   }
            items.each(function() {
                var m= $(this);
                var itemTop = m.offset().top;
                if (top>itemTop-1) {
                currentId = "#"+m.attr("id");
                }else{
                    return false;
                }
        });
        var currentLink = menu.find(".lift-item-current");
            if (currentId && currentLink.attr("href") != currentId) {
                currentLink.removeClass("lift-item-current");
                menu.find("[href='"+currentId+"']" ).addClass("lift-item-current");
            }
            $("#menu").find('icon-top-alt').click(function(event) {
           top = 0;
       });
       });
       
    }
    menuNav();

    function seckill(argument) {
        $('#box-bd').on('mouseenter', function(event) {
            $("#box-bd").find(".k_arrow").css('display', 'block'); 
        });
         $('#box-bd').on('mouseleave', function(event) {
            $("#box-bd").find(".k_arrow").css('display', 'none'); 
        });
    }
    seckill();
    function clickTest() {
        var message_list = $(".quick_links_panel li").find('.message_list'),
            mui=$(".mui-mbar-tabs");
        console.log(message_list);
       message_list.on('click', function() {
           mui.css('right', 120);
       });
       //  message_list.on('click', function() {
       //     mui.css('right', 0);
       // });
    }
    clickTest();
  });