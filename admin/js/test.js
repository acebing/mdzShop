    

/**********************************{common} start*****************************/
    
    var goods_id = $("input[name='goods_id']").val();
    var user_id = '0';
    
    $(function(){
        var steflex = $(".stepflex");
        var goodsInfo = $(".goods_info");
        var model_inventory = $("form[name='theForm'] :input[name='model_inventory']").val();
        $(window).load(function(){
            //默认进入加载步骤
            auto_step();
            
            //设置分类导航
            set_cat_nav();
            
            //促销
            handlePromote('input[name=is_promote]');
            
            //限购
            handle_for_purchasing('.is_xiangou');
            
            /**
            *隐藏属性模块
            */
            var goods_attr_list = $("#goods_attr_gallery").html();
            if(goods_attr_list == ''){
                $("#goods_attr_gallery").hide();
            }
            
            //分销
            if(document.getElementById('dis_commission')){
                handle_distribution('.is_dishandle');
            }
            
            //会员价格

            set_price_note('6');
            set_price_note('11');
            set_price_note('12');
            set_price_note('7');
            set_price_note('8');
            set_price_note('3');          
        });
        
        //设置步骤
        var auto_step = function(num){
            if(goods_id > 0){           
                var auto_step = 'auto_step_' + goods_id;
                if(num){
                    $.cookie(auto_step, num, {expires:1,path:'/'});
                }else{
                    //编辑商品默认到第三步
                    //var num = $.cookie(auto_step)? $.cookie(auto_step):1;
                    show_step('step', 4);
                }
            }else{
                if(num == null){
                    //添加商品默认到第一步
                    show_step('step', 1);
                }
            }
        }
        
        //页面跳转
        var show_step = function(type,num,valid,obj){
            //点击下一步骤验证
            if(obj != null){
                var obj = $(obj);
                var step = obj.parents("div[ectype='step']").data("step");
                
                if(validfunc(step) == false && valid == true){
                    return;
                }
            }

            //当前步骤导航
            steflex.find("dl:lt("+num+")").addClass("cur");
            steflex.find("dl:gt("+(num-1)+")").removeClass("cur");

            //当前步骤内容页显示
            goodsInfo.find("*[ectype='step'][data-step="+num+"]").show().siblings().hide();
            
            if(type == "submit"){
                $("#goods_form").submit();
            }
            
            if(num == 1 || num == 2 || num ==3){
                scroll();
            }
        }
        
        //添加或者编辑商品点击下一步事件
        $("*[ectype='stepSubmit']").on("click",function(){
            var _this = $(this);
            var step = _this.data("step");
            var type = _this.data("type");
            var down = _this.data("down");
            if(down == true){
                show_step(type,step,true,_this);
            }else{
                show_step(type,step,false,_this);
            }
        });
        
        //步骤验证通过下一步
        validfunc = function (num){
            var model_inventory = $("form[name='theForm'] :input[name='model_inventory']").val();
            var stepDiv = $("div[data-step='"+num+"']");
            stepDiv.find("input[ectype='require']").removeClass("error");
            stepDiv.find(".form_prompt .error").remove();
            if(num == 1){
                //验证是否选择了分类
                if($("input[name='cat_id']").val() == 0){
                    $("#choiceClass").find("strong").html("请选择分类");
                    return false;
                }
            }else if(num == 2){
                //验证商品基本信息必填信息
                if($("input[name='goods_name']").val() == ""){
                    error_div("input[name='goods_name']",'goods_name_not_null');
                    return false;
                }

                if(!(/^[0-9]+.?[0-9]*$/.test($("input[name='shop_price']").val()))){
                    error_div("input[name='shop_price']",'shop_price_not_number');
                    return false;
                }
                if(/[^0-9 \-]+/.test($("input[name='goods_number']").val())){
                    error_div("input[name='goods_number']",'goods_number_not_int');
                    return false;
                }
                
                if($("#is_img_url").val() == 0){
                    if($(".update_images").find("img").attr("src") == "images/update_images.jpg"){
                        
                        error_div(".moxie-shim input","请上传商品默认图片");
                        return false;
                    }
                }else{
                    if($("#goods_img_url").val() == ''){
                        error_div("input[name='goods_img_url']","请填写图片外部链接，http://格式");
                        return false;
                    }
                }
                
                //运费验证
                if($("input[name='freight']").length > 0){
                    var is_freight = true;
                    var error_prompt = "";
                    
                    if($("input[name='freight']").is(":checked")){
                        var val = $("input[name='freight']:checked").val();
                        if(val == 2){
                            var tid = $("input[name='tid']").val();
                            if(tid == "" || tid == 0){
                                is_freight = false;
                                error_prompt = 'volume_freight_not_null';
                            }
                        }else{
                            is_freight = true;
                        }
                    }else{
                        is_freight = false;
                        error_prompt = 'volume_goods_freight_not_null';
                    };

                    if(is_freight == false){
                        error_div("input[name='freight']",'error_prompt');
                        return false;
                    }
                }
                
            }else{
                return true;
            }
        }
        
        //验证调用的报错提示
        error_div = function(obj,error,is_error){
            var error_div = $(obj).parents('div.item').find('div.form_prompt');
            $(obj).parents('div.item').find(".notic").hide();
            
            if(is_error != 1){
                $(obj).addClass("error");
            }
            
            $(obj).focus();
            error_div.find("label").remove();
            error_div.append("<label class='error'><i class='icon icon-exclamation-sign'></i>"+error+"</label>");
        }
        
        //列出商品模式
        goods_model_list = function(obj, goods_id, model, user_id){
            var obj = $(obj);
            $.jqueryAjax('goods.php', 'act=goods_model_list&goods_id='+goods_id+'&model='+model+'&user_id='+user_id, function(data){
                obj.html(data.content);
            });
        }
        
        //悬浮显示上下步骤按钮
        scroll = function(){
            $(window).scroll(function(){
                var scrollTop = $(document).scrollTop();
                var height = $(".warpper").height();
                var bodyHeight = $(".iframe_body").height();
                if(scrollTop>(height-bodyHeight)){
                    $(".goods_footer .goods_btn").removeClass("goods_btn_fixed");
                }else{
                    $(".goods_footer .goods_btn").addClass("goods_btn_fixed");
                }
            });
        }
        
        //返回修改分类
        $("a[ectype='edit_category']").on("click",function(){
            show_step('step', 3);
        });
        
    });
    /**********************************{common} end*****************************/
    
    /**********************************{商品分类选中} start*****************************/
    //分类滚动轴
    $(".category_list").perfectScrollbar();

    //常用分类
    $.divselect("#sortcommList","#sortcommValue",function(obj){
        var cat_id = $(obj).data('value');
        $.jqueryAjax('goods.php', 'act=set_common_category_pro&cat_id='+cat_id, function(data){
            for(var i=1; i<=3; i++){
                if(data.content[i]){
                    $("ul[ectype=category][data-cat_level="+i+"]").html(data.content[i]);
                }
            }
            //设置商品分类
            set_cat_nav();
            $("input[name=cat_id]").val(cat_id);
        })
    }); 
    
    $(document).on("click","ul[ectype='category'] li",function(){
        var _this = $(this);
        var cat_id = _this.data("cat_id");
        var cat_level = _this.data("cat_level");
        var goods_id = _this.data("goodsid");

        get_select_category_pro(_this, cat_id, cat_level, goods_id);
    });
    /**********************************{商品分类选中} end*****************************/
    
    /**********************************{商品基本信息} start*****************************/
    //商品货号
    function checkGoodsSn(goods_sn, goods_id)
    {
        $("input[name='goods_sn']").parents('div.step_value').find('div.form_prompt').html('');
        
        var callback = function(res)
        {
            if (res.error > 0)
            {
                error_div("input[name='goods_sn']",res.message, 1);
            }
        }
        
        Ajax.call('goods.php?is_ajax=1&act=check_goods_sn', "goods_sn=" + goods_sn + "&goods_id=" + goods_id, callback, "GET", "JSON");
    }
    
    //商品价格
    function priceSetted()
    {
        var theForm = $("form[name='theForm']"),
            input_shop_price = theForm.find("input[name='shop_price']"),      //商品价格
            input_promote_price = theForm.find("input[name='promote_price']"),//商品促销价格
            shop_price = 0;
            
        if(input_shop_price.length > 0){
            var is_promote = theForm.find("input[name='is_promote']:checked").val();
            
            if(is_promote == 1){
                shop_price = Number(parseFloat(input_promote_price.val()));
            }else{
                shop_price = Number(parseFloat(input_shop_price.val()));
            }
        }
        
        computePrice('market_price', marketPriceRate);
        
                set_price_note(6);
                set_price_note(11);
                set_price_note(12);
                set_price_note(7);
                set_price_note(8);
                set_price_note(3);
                
        
         
    }
    
    /*价格计算相关js start*/      
    var marketPriceRate = 1.2;
    var integralPercent = 1;
  
    //取整数
    function integral_market_price()
    {
        document.forms['theForm'].elements['market_price'].value = parseInt(document.forms['theForm'].elements['market_price'].value);
    }
    
    /**
    * 赠送消费积分数
    */
    function get_give_integral(val)
    {
        var val = Number(val);
                document.forms['theForm'].elements['give_integral'].value = parseInt(val);
    }
  
    /**
    * 赠送等级积分数
    */
    function get_rank_integral(val)
    {
        var val = Number(val);
                document.forms['theForm'].elements['rank_integral'].value = parseInt(val);
    } 
  
    /**
    * 积分购买金额
    */
    function parseint_integral(val)
    {
        var val = Number(val);
                document.forms['theForm'].elements['integral'].value = parseInt(val);
    }
    
    function get_price_give(val){
         
    }
  
    /**
    * 促销
    */
    function handlePromote(obj)
    {
        $(obj).each(function(index, element) {
          if($(element).is(":checked") == true){
              if($(element).val() == 1){
                  $("#promote_1").attr("disabled",false);
                  $("#promote_start_date").parent().removeClass("time_disabled");
                  
                                  
                  shop_price = Number(parseFloat($("input[name='promote_price']").val()));
              }else{
                  $("#promote_1").attr("disabled",true);
                  $("#promote_start_date").parent().addClass("time_disabled");
                  
                  shop_price = Number(parseFloat($("input[name='shop_price']").val()));
              }
              
              get_price_give(shop_price);
          }
      });
      
      document.forms['theForm'].elements['give_integral'].value = 0;
      document.forms['theForm'].elements['rank_integral'].value = 0;
      document.forms['theForm'].elements['integral'].value = 0;
    }
    
    /**
    **促销价格
    */
    function get_promote_price(val){
        var shop_price = 0;
        
        shop_price = Number(parseFloat(val));
        
        get_price_give(shop_price);
    }
    
    /**
    * 限购
    */
    function handle_for_purchasing(obj)
    {
      $(obj).each(function(index, element) {
          if($(element).is(":checked") == true){
              if($(element).val() == 1){
                    $("#xiangou_num").attr("disabled",false);
                    $("#xiangou_start_date").parent().removeClass("time_disabled");
              }else{
                    $("#xiangou_num").attr("disabled",true);
                    $("#xiangou_start_date").parent().addClass("time_disabled");
              }
          }
      });
    }
    
    //按市场价
    function marketPriceSetted()
    {
        computePrice('shop_price', 1/marketPriceRate, 'market_price');
        computePrice('integral', integralPercent / 100);
        
                set_price_note(6);
                set_price_note(11);
                set_price_note(12);
                set_price_note(7);
                set_price_note(8);
                set_price_note(3);
                
    }

    //计算价格
    function computePrice(inputName, rate, priceName)
    {
        var shopPrice = priceName == undefined ? document.forms['theForm'].elements['shop_price'].value : document.forms['theForm'].elements[priceName].value;
        shopPrice = Utils.trim(shopPrice) != '' ? parseFloat(shopPrice)* rate : 0;
        if(inputName == 'integral')
        {
          shopPrice = parseInt(shopPrice);
        }
        shopPrice += "";
        
        n = shopPrice.lastIndexOf(".");
        if (n > -1)
        {
          shopPrice = shopPrice.substr(0, n + 3);
        }
        
        if (document.forms['theForm'].elements[inputName] != undefined)
        {
          document.forms['theForm'].elements[inputName].value = shopPrice;
        }
        else
        {
          document.getElementById(inputName).value = shopPrice;
        }
        console.log(shopPrice);
    }

    function set_price_note(rank_id)
    {
        var shop_price = $("input[name='shop_price']");
        var rank = new Array();
        
        if(shop_price.length > 0){
            var shop_price = parseFloat(shop_price.value);
        }else{
            var shop_price = 0;
        }
        
        
                            rank[6] = 100;
                            rank[11] = 100;
                            rank[12] = 100;
                            rank[7] = 85;
                            rank[8] = 70;
                            rank[3] = 60;
                    
        
        if (shop_price >0 && rank[rank_id] && document.getElementById('rank_' + rank_id) && parseInt(document.getElementById('rank_' + rank_id).value) == -1)
        {
            var price = parseInt(shop_price * rank[rank_id] + 0.5) / 100;
            if (document.getElementById('nrank_' + rank_id)){
                document.getElementById('nrank_' + rank_id).innerHTML = '(' + price + ')';
            }
        }else{
            if (document.getElementById('nrank_' + rank_id)){
                document.getElementById('nrank_' + rank_id).innerHTML = '';
            }
        }
    } 
    /*价格计算相关js end*/
    
    //添加扩展分类
    $(".category_dialog").on("click",function(){
        var goods_id = $("input[name='goods_id']").val();
        var other_catids = $("input[name='other_catids']").val();
        $.jqueryAjax("dialog.php", "is_ajax=1&act=extension_category&goods_id="+goods_id+"&other_catids="+other_catids, function(data){
            var content = data.content;
            pb({
                id:"categroy_dialog",
                title:"扩展分类",
                width:788,
                content:content,
                ok_title:"确定",
                cl_title:"取消",
                drag:false,
                foot:true,
                onOk:function(){}
            });
            $(".category_list").perfectScrollbar();
        });
    });
    
    /* 处理扩展分类 by wu start */
    $(document).on("click","a[ectype=addExdCategory]",function(){
        var thisObj = $(this).parent();
        var cat_id = thisObj.find("input[ectype=cat_id]").val();
        if(cat_id == 0){
            $(".red_notic").remove();
            $(".sort_info").after("<div class='red_notic'>请选择分类</div>");
            setTimeout('$(".red_notic").remove()',1500);
        }else if(thisObj.find(".filter_item input[value="+cat_id+"]").length > 0){
            $(".red_notic").remove();
            $(".sort_info").after("<div class='red_notic'>不能添加重复分类</div>");
            setTimeout('$(".red_notic").remove()',1500);
        }else{
            var str = "";
            thisObj.find("ul li.current").each(function(){
                str += $(this).text() + '>';
            });
            str = str.substr(0,str.length - 1);
            var div = "<span class='filter_item'><span>"+str+"</span><a herf='javascript:void(0);' class='delete'></a>";
            div += "<input type='hidden' name='other_cat[]' value='"+cat_id+"'></span>";
            thisObj.find(".filter").append(div);
            deal_extension_category(this, goods_id, cat_id, 'add'); //ajax添加扩展分类
        }
    });
    
    $(document).on("click","#extension_category .delete",function(){
        var cat_id = $(this).siblings("input").val();
        deal_extension_category(this, goods_id, cat_id, 'delete'); //ajax删除扩展分类
        $(this).parent().remove();
    });
    /* 处理扩展分类 by wu end */

    //商品基本信息 - 上传商品图片
    var goods_id = $("input[name='goods_id']").val();
    var uploader = new plupload.Uploader({//创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'goods_figure', // 上传按钮
        url: "get_ajax_content.php?is_ajax=1&act=upload_img&type=goods_img&id="+goods_id, //远程上传地址
        filters: {
            max_file_size: '2mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
            mime_types: [//允许文件上传类型
                {title: "files", extensions: "jpg,png,gif,jpeg"}
            ]
        },
        multi_selection: false, //true:ctrl多文件上传, false 单文件上传
        init: {
            FilesAdded: function(up, files) { //文件上传前
                var li = '';
                plupload.each(files, function(file) { //遍历文件
                    li += "<div class='img'><img src='images/loading.gif' /></div>";
                });
                
                $("#goods_figure").append(li);
                uploader.start();
            },
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                var data = eval("(" + info.response + ")");
                $("#goods_figure").html("<div class='img'><img src='" + data.pic + "'/><div class='edit_images'>更换图片</div></div>");
                //处理商品图片 by wu start
                $("input[name=original_img]").val(data.data['original_img']);
                $("input[name=goods_img]").val(data.data['goods_img']);
                $("input[name=goods_thumb]").val(data.data['goods_thumb']);
                //处理商品图片 by wu end
                
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
    uploader.init();

    //上传视频
    $("#goods_video").on("click",function(){
        $.jqueryAjax("dialog.php", "is_ajax=1&act=video_box", function(data){
            var content = data.content;
            pb({
                id:"update_video_dialog",
                title:"上传视频",
                width:500,
                content:content,
                drag:true,
                foot:false
            });
        });
    });

    $(".video_default").on("click",function(){
        $('#goods_video_js').click();
        $(this).hide();
    });

    var video=document.getElementById("goods_video_js");

    if(video){
        video.onclick=function(){
            if(video.paused){
                video.play();
                $(".video_default").hide();
            }else{
                video.pause();
                $(".video_default").show();
            }
        }

        video.addEventListener("ended",function(){
            video.currentTime = 0;
            $(".video_default").show();
        })
    }

    //删除视频
    $("*[ectype='video_remove']").on("click",function(){
        pbDialog("是否要删除视频","",0,"","","",true,function(){
            $.jqueryAjax("gallery_album.php", "is_ajax=1&act=del_video&goods_id=" + goods_id, function(data){
                $(".goods_video_div").addClass("hide");
                $(".goods_video_js").attr("src", '');
            });
        })
    });

    //日期选择插件调用
    var opts1 = {
        'targetId':'promote_start_date',//时间写入对象的id
        'triggerId':['promote_start_date'],//触发事件的对象id
        'alignId':'text_time1',//日历对齐对象
        'format':'-'//时间格式 默认'YYYY-MM-DD HH:MM:SS'
    },opts2 = {
        'targetId':'promote_end_date',
        'triggerId':['promote_end_date'],
        'alignId':'text_time2',
        'format':'-'
    },opts3 = {
        'targetId':'xiangou_start_date',
        'triggerId':['xiangou_start_date'],
        'alignId':'text_time3',
        'format':'-',
        'min':'2019-03-28 16:46:42'
    },opts4 = {
        'targetId':'xiangou_end_date',
        'triggerId':['xiangou_end_date'],
        'alignId':'text_time4',
        'format':'-',
        'min':'2019-03-28 16:46:42'
    }

    xvDate(opts1);
    xvDate(opts2);
    xvDate(opts3);
    xvDate(opts4);
    
    //商品名称颜色设置
    $("#font_color input").spectrum({
        showInitial: true,
        showPalette: true,
        showSelectionPalette: true,
        showInput: true,
        showSelectionPalette: true,
        maxPaletteSize: 10,
        preferredFormat: "hex",
        palette: [
            ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
            "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
            ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
            "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
            ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
            "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
            "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
            "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
            "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
            "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
            "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
            "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
            "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
            "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
        ]
    });
    $('.sp-choose').click(function(){
        var sp_color = $('.sp-input').val();
        $('input[name="goods_name"]').css("color",sp_color);
        $('input[name="goods_name_color"]').val(sp_color);
    });

    //展开收起
    $.upDown("[ectype='outerInfo']",".step_title",".step",117);
    $.upDown("[ectype='scanCode']",".step_title",".step",117);
    
    //关联商品
    $.upDown("[ectype='Relationgoods']",".step_title",".step",117);
    
    //配件
    $.upDown("[ectype='parts_goods']",".step_title",".step",117);
    
    //关联文章
    $.upDown("[ectype='Related_articles']",".step_title",".step",117);
    
    //关联地区
    $.upDown("[ectype='Related_region']",".step_title",".step",117);
    
    /*
    ** 删除优惠阶梯价格
    */
    $(document).on("click","a[ectype='remove_volume']",function(){
        var index = $(this).parent("td").index();
        var parent = $(this).parents("table");
        var id = $(this).data('id');
        var goods_id = $("input[name='goods_id']").val();
        
        if(id > 0){
            if(confirm('您确定删除该优惠价格吗？')){
                $.jqueryAjax('dialog.php', 'act=del_volume' + '&id=' + id + '&goods_id=' + goods_id, function(data){
                    parent.find("tr").each(function(){
                        $(this).find("td").eq(index).remove();
                    }); 
                });
            }
            
        }else{
            parent.find("tr").each(function(){
                $(this).find("td").eq(index).remove();
            });
        }   
    });
    
    /*
    ** 删除满立减优惠价格
    */
    $(document).on("click","a[ectype='remove_cfull']",function(){
        var index = $(this).parent("td").index();
        var parent = $(this).parents("table");
        var id = $(this).data('id');
        var goods_id = $("input[name='goods_id']").val();
        
        if(id > 0){
            if(confirm('您确定删除该优惠价格吗？')){
                $.jqueryAjax('dialog.php', 'act=del_cfull' + '&id=' + id + '&goods_id=' + goods_id, function(data){
                    parent.find("tr").each(function(){
                        $(this).find("td").eq(index).remove();
                    }); 
                });
            }
        }else{
            parent.find("tr").each(function(){
                $(this).find("td").eq(index).remove();
            });
        }
    });
    
    /*
    ** 编辑商品相册图片外链地址
    */
    $(document).on("change","input[ectype='external_url']",function(){
        var img_id = $(this).data('imgid');
        var goods_id = $("input[name='goods_id']").val();
        var external_url = $(this).val();
        
        $.jqueryAjax('dialog.php', 'act=insert_gallery_url' + '&external_url=' + external_url + '&img_id=' + img_id + '&goods_id=' + goods_id, function(data){
            if(data.error){
                alert("图片链接地址已存在");
                $(".external_url_" + data.img_id).val('');
            }else{
                $("#external_img_url" + data.img_id).attr("src", data.external_url);
            }
        });
    });
    
    /*
    ** 添加商品相册图片外链地址
    */
    $("#addExternalUrl").click(function(){
        var goods_id = $("input[name='goods_id']").val();
        
        $.jqueryAjax('dialog.php', 'is_ajax=1&act=add_external_url' + '&goods_id=' + goods_id, function(data){
            var content = data.content;
            pb({
                id:"attr_input_type",
                title:"添加外链图片",
                width:820,
                content:content,
                ok_title:"确定",
                cl_title:"取消",
                drag:false,
                foot:true,
                cl_cBtn:true,
                onOk:function(){
                    insert_external_url();
                }
            });
        });
    });
    
    function insert_external_url(){
        var actionUrl = "dialog.php?act=insert_external_url";  
        $("#externalUrlList").ajaxSubmit({
            type: "POST",
            dataType: "JSON",
            url: actionUrl,
            data: {"action": "TemporaryImage"},
            success: function (data) {
                $("#gallery_img_list").html(data.content);
            },
            async: true  
         });
    }
    
    $("input[name='is_img_url']").click(function(){
        if($(this).is(":checked") == true){
            $("input[name='is_img_url']").val(1);
            $("input[name='goods_img_url']").attr("disabled",false);
            
        }else{
            $("input[name='is_img_url']").val(0);
            $("input[name='goods_img_url']").attr("disabled",true);
            $("input[name='goods_img_url']").val('');
        }
    });
       
    //商品运费 by wu
    $("input[name='freight']").click(function(){
        var value = $(this).val();
        if(value == 0){
            $('#shipping_fee').hide();
            $('#tid').hide();           
        }else if(value == 1){
            $('#shipping_fee').show();
            $('#tid').hide();
        }else if(value == 2){
            $('#shipping_fee').hide();
            $('#tid').show();       
        }
    });
    
    /**********************************{商品基本信息} end*****************************/
    
    /**********************************{商品属性信息} start*****************************/
    //自动加载商品属性
    getAttrList(goods_id);
    
    //设置商品属性
    function getAttrList(goodsId)
    {
        
        var selGoodsType = document.forms['theForm'].elements['goods_type'];
        var selModelAttr = document.forms['theForm'].elements['model_attr'];
        var modelAttr = selModelAttr.value;
        if (selGoodsType != undefined)
        {
            var goodsType = selGoodsType.value; 
            Ajax.call('goods.php?is_ajax=1&act=get_attribute', 'goods_id=' + goodsId + "&goods_type=" + goodsType + '&modelAttr=' + modelAttr, setAttrList, "GET", "JSON");
        }
    }
    
    function setAttrList(result, text_result)
    {
        document.getElementById('tbody-goodsAttr').innerHTML = result.goods_attribute;

        if(result.is_spec){
            $("#goods_attr_gallery").show();
            document.getElementById('goods_attr_gallery').innerHTML = result.goods_attr_gallery;
        }else{
            $("#goods_attr_gallery").hide();
        }
        
                set_attribute_table(goods_id);
            }
    
    //删除货品
    function dropProduct(product_id)
    {
        var group_attr = $("form[name='theForm'] :input[name='group_attr']").val();
        $.jqueryAjax('goods.php', 'act=drop_product&product_id=' + product_id + '&group_attr=' + group_attr, function(data){
            if(data.error == 0){
                $.jqueryAjax('goods.php', 'act=set_attribute_table&goods_id='+data.goods_id+'&attr_id='+data.attr_id+'&attr_value='+data.attr_value+'&goods_model='+data.goods_model+'&region_id='+data.region_id, function(data){
                    $("#attribute_table").html(data.content);
                })
            }
        });
    }   
    
    //删除相册图片
    function dropImg(imgId)
    {
        Ajax.call('goods.php?is_ajax=1&act=drop_image', "img_id="+imgId, dropImgResponse, "GET", "JSON");
    }
    
    function dropImgResponse(result)
    {
        if (result.error == 0)
        {
            $("*[data-imgid="+result.content+"]").parents("li").remove();
        }
    }
    
    $(document).on("click",".delete_img",function(){
        var id = $(this).data("imgid");
        if (confirm('您确实要删除该图片吗？')){
            dropImg(id);
        }
    });
    
    //删除商品勾选属性
    $(document).on("click","*[ectype='attrClose']",function(){
        var _this = $(this);
        var goods_id = _this.data("goodsid");
        var attr_id = _this.data("attrid");
        var goods_attr_id = _this.data("goodsattrid");
        var attr_value = _this.data("attrvalue");
        var model = $(":input[name='goods_model']").val();
                var warehouse_id = $("#attribute_model").find("input[type=radio][data-type=warehouse_id]:checked").val();
                var region_id = $("#attribute_model").find("input[type=radio][data-type=region_id]:checked").val();
                var extension = '';
                if(goods_model == 1){
                        extension = "&region_id="+warehouse_id;
                }else if(goods_model == 2){
                        extension = "&region_id="+region_id;
                }
                
        if(_this.siblings("input[type='checkbox']").is(":checked") == true){
            _this.siblings("input[type='checkbox']").prop("checked",false);
            $.jqueryAjax('dialog.php', 'act=del_goods_attr' + '&goods_id=' + goods_id + '&attr_id=' + attr_id + '&goods_attr_id=' + goods_attr_id + '&attr_value=' + attr_value + "&model=" + model + extension, function(data){
                getAttrList(goods_id);
            });
        };
        
    });
    
    //上传属性图片 start
    $(document).on("click","a[ectype='add_attr_img']",function(){
        
        var goods_id = $("#goods_id").val();
        var goods_name = $("input[name=goods_name]").val();
        var attr_id = $(this).data('attrid');
        var goods_attr_id = $(this).data('goodsattrid');
        var attr_value = $("#goodsAttrValue_" + goods_attr_id).val();
        
        if(attr_value == ''){
            alert("请选择商品规格");
            return false;
        }
        
        $.jqueryAjax('dialog.php', 'act=add_attr_img' + '&goods_id=' + goods_id + '&goods_name=' + goods_name + '&attr_id=' + attr_id + '&goods_attr_name=' + attr_value + '&goods_attr_id=' + goods_attr_id, function(data){
            var content = data.content;
            pb({
                id:"categroy_dialog",
                title:"上传属性图片",
                width:664,
                content:content,
                ok_title:"确定",
                cl_title:"取消",
                drag:true,
                foot:true,
                cl_cBtn:true,
                onOk:function(){
                    get_attr_gallery();
                }
            });
        });
    });
    
    function get_attr_gallery(){

        var actionUrl = "dialog.php?act=insert_attr_img";  
        $("#fileForm").ajaxSubmit({
                type: "POST",
                dataType: "JSON",
                url: actionUrl,
                data: {"action": "TemporaryImage"},
                success: function (data) {
                    if(data.is_checked){
                        $(".attr_gallerys").find(".img[data-type='img']").remove();
                        var _div_img = '<div class="img" data-type="img"><img src="images/yes.png" /></div>';
                        $(".attr_gallerys").find("a[data-goodsattrid='" + data.goods_attr_id + "']").after(_div_img);
                    }
                },
                async: true
         });
    }
    
    function delete_attr_gallery(goods_id, attr_id, goods_attr_name, goods_attr_id){
         $.jqueryAjax('dialog.php', 'act=drop_attr_img' + '&goods_id=' + goods_id + '&attr_id=' + attr_id + '&goods_attr_name=' + goods_attr_name + '&goods_attr_id=' + goods_attr_id, function(data){
            if(data.error == 0){
                $(".img_flie_" + data.goods_attr_id).remove();
            }
         });
    }
    
    function get_choose_attrImg(goods_id, goods_attr_id){
        if($("#feedbox").is(":hidden")){
         $.jqueryAjax('dialog.php', 'act=choose_attrImg' + "&goods_id="+goods_id +  "&goods_attr_id="+goods_attr_id, function(data){
            if(data.error == 0){
                $("#feedcontent").html(data.content);
                $("#feedbox").show();
                
                var pb = $("#feedbox").parents(".pb");
                pb.css("top",($(window).height() - pb.height())/2);
            }
         });
        }else{
            $("#feedbox").hide();
        }
    }
    
    function gallery_on(this_obj,gallery_id,goods_id,goods_attr_id)
    {
        var a = document.getElementById('feedcontent').getElementsByTagName("li");
    
        for(i = 0; i < a.length; i++)
        {
            a[i].className=" ";
        }
        
        $.jqueryAjax('dialog.php', 'act=insert_gallery_attr' + "&gallery_id="+gallery_id +  "&goods_id="+goods_id +  "&goods_attr_id="+goods_attr_id, function(data){
            $("#attr_gallery_flie_" + data.goods_attr_id).attr("href", data.img_url);
            $("input[name='img_url']").val(data.img_url);
         });
         
        this_obj.className="on";
    }

    //上传属性图片 end
    
    //商品相册--上传图片
    var uploader_gallery = new plupload.Uploader({//创建实例的构造方法
        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
        browse_button: 'addImages', // 上传按钮
        url: "get_ajax_content.php?is_ajax=1&act=upload_img&type=gallery_img&id="+goods_id, //远程上传地址
        filters: {
            max_file_size: '2mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
            mime_types: [//允许文件上传类型
                {title: "files", extensions: "jpg,png,gif,jpeg"}
            ]
        },
        multi_selection: true, //true:ctrl多文件上传, false 单文件上传
        init: {
            FilesAdded: function(up, files) { //文件上传前
                if ($("#ul_pics").children("li").length > 30) {
                    alert("您上传的图片太多了！");
                    uploader_gallery.destroy();
                } else {
                    var li = '';
                    plupload.each(files, function(file) { //遍历文件
                        li += "<li id='" + file['id'] + "'><div class='img'><img src='images/loading.gif' /></li>";
                    });
                    $("#ul_pics").append(li);
                    uploader_gallery.start();
                }
            },
            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                var data = eval("(" + info.response + ")");
                var html = "&nbsp;";
                if(data.img_id == data.min_img_id){
                    html = "主图";
                    $("#ul_pics").find(".zt").each(function(){
                        $(this).html("&nbsp;");
                    });
                }
                $("#gallery_"+data.min_img_id).find(".zt").html("主图");
                $("#" + file.id).html("<div class='img' onclick='img_default("+data.img_id+")'><img src='" + data.pic + "'/></div><div class='info'><span class='zt red'>"+html+"</span><div class='sort'><span>排序：</span><input type='text' name='sort' value='" + data.img_desc + "' class='stext' /></div><a href='javascript:void(0);' class='delete_img' data-imgid='"+data.img_id+"'><i class='icon icon-trash'></i></a></div><div class='info'><input name='external_url' type='text' class='text w130' ectype='external_url' value='" + data.external_url + "' title='" + data.external_url + "' data-imgid='" + data.img_id + "' placeholder='图片外部链接' onfocus='if (this.value == '图片外部链接'){this.value='http://';this.style.color='#000';}></div>");
            },
            Error: function(up, err) { //上传出错的时候触发
                alert(err.message);
            }
        }
    });
    uploader_gallery.init();
    
    function img_default(img_id){
        Ajax.call('goods.php?act=img_default', "img_id=" + img_id , img_defaultResult, "POST", "JSON");
    }
    function img_defaultResult(result){
        if(result.error == 1){
            $(".goods_album").html(result.content);
        }else{
            alert(result.massege);
        }
    }
    
    $(document).on("click","a[ectype='attr_input']",function(){
        var attr_id = $(this).data('attrid');
        var goods_id = $("input[name='goods_id']").val();
        
        $.jqueryAjax('dialog.php', 'is_ajax=1&act=attr_input_type' + '&attr_id=' + attr_id + '&goods_id=' + goods_id, function(data){
            var content = data.content;
            pb({
                id:"attr_input_type",
                title:"手工录入属性",
                width:820,
                content:content,
                ok_title:"确定",
                cl_title:"取消",
                drag:false,
                foot:true,
                cl_cBtn:true,
                onOk:function(){
                    insert_attr_input();
                }
            });
        });
    });
    
    function insert_attr_input(){
        var actionUrl = "dialog.php?act=insert_attr_input";  
        $("#insertAttrInput").ajaxSubmit({
            type: "POST",
            dataType: "JSON",
            url: actionUrl,
            data: {"action": "TemporaryImage"},
            success: function (data) {
                $(".attr_input_type_" + data.attr_id).html(data.content);
                
                //自动加载商品属性
                getAttrList(data.goods_id);
            },
            async: true  
         });
    }
    
    //唯一属性框进入焦点
    function insert_attr_input_val(obj){
        var _this = $(obj).parents('.value'),
            attr_id_val = [],
            value_list_val = [],
            attr_id = _this.find("input[name='attr_id_list[]']").val(),
            goods_id = $("input[name='goods_id']").val();
        
        attr_id_val.push(_this.find("input[name='goods_attr_id_list[]']").val());
        value_list_val.push(_this.find("input[name='attr_value_list[]']").val());
        
        $.jqueryAjax('dialog.php', 'is_ajax=1&act=insert_attr_input&attr_id_val=' + attr_id_val + '&attr_id=' + attr_id + '&goods_id=' + goods_id + "&value_list_val=" + value_list_val, function(data){});
    }
    
    //下拉属性选择
    $.divselect("#blur_attr_list","#blur_attr_list_val",function(obj){
        var val = obj.data("value"),
            _this = obj.parents('.value'),
            attr_id_val = [],
            value_list_val = [],
            attr_id = _this.find("input[name='attr_id_list[]']").val(),
            goods_id = $("input[name='goods_id']").val();
        
        attr_id_val.push(_this.find("input[name='goods_attr_id_list[]']").val());
        value_list_val.push(val);
        
        $.jqueryAjax('dialog.php', 'is_ajax=1&act=insert_attr_input&attr_id_val=' + attr_id_val + '&attr_id=' + attr_id + '&goods_id=' + goods_id + "&value_list_val=" + value_list_val, function(data){});
    });
    
    $(document).on("click",".xds_up",function(){
        var _div = $(this).parent().clone();
        _div.find("i").removeClass("xds_up").addClass("xds_down");
        $(this).parents(".input_type_items").append(_div);
    });
    
    $(document).on("click",".xds_down",function(){
        var parent = $(this).parents(".input_type_item");
        var goods_attr_id = parent.children("input[name='goods_attr_id[]']").val();
        var goods_id = $("input[name='goods_id']").val();
        
        if(goods_attr_id > 0){
            
            var attr_id = $("input[name='attr_id']").val();

            if(confirm('您确定删除该属性吗？')){
                $.jqueryAjax('dialog.php', 'is_ajax=1&act=del_input_type' + '&goods_attr_id=' + goods_attr_id + '&attr_id=' + attr_id + '&goods_id=' + goods_id, function(data){
                    $(".attr_input_type_" + data.attr_id).html(data.attr_content);
                    parent.remove();
                    
                    //自动加载商品属性
                    getAttrList(goods_id);
                });
            }
            
        }else{
            parent.remove();
        }
    });
    
    $(document).on("click","[ectype='search_attr']",function(){
        set_attribute_table(goods_id , 1); //重置表格
    });
    /**********************************{商品属性信息} end*****************************/
    
    /* 异步添加各类信息 begin */
    //添加运费模板
    $(document).on("click","[ectype='ajaxTransport']",function(){
        var name = "添加运费模板";
        var act = 'act=ajaxTransport';
        var _this = $(this);
        if(_this.data('attr') == 'edit'){
            var tid = $('#transport_div').find("input[name='tid']").val();
            name = "编辑运费模板";
            act = 'act=ajaxTransport&tid=' + tid;
        }
        
        $.jqueryAjax('dialog.php',act, function(data){
            goods_visual_desc(name,1000,data.content,function(){
                var form = $("#transport_dialog").find("form[name='theForm']");
                var title = form.find("input[name='title']");
                var act = form.find("input[name='act']").val();
                var fald = true;
                
                if(title.val() == ""){
                    error_div("#transport_dialog input[name='title']","运费模板标题不能为空");
                    fald = false;
                }else{
                    form.ajaxSubmit({
                        type: "POST",
                        dataType: "JSON",
                        url: "dialog.php?act=" + act,
                        data: {"action": "TemporaryImage"},
                        success: function (data) {
                            alert(data.message);
                            if(data.error == 0){
                                $("#transport_div").html(data.content); 
                            }
                        },
                        async: true  
                    });
                    
                    fald = true;
                }
                return fald;   
            },'transport_dialog');            
        });     
    });
    
    //添加品牌
    $(document).on("click","[ectype='ajaxBrand']",function(){
        $.jqueryAjax('dialog.php', 'act=ajaxBrand', function(data){
            goods_visual_desc("添加品牌",1000,data.content,function(){
                var form = $("#brand_dialog").find("form[name='theForm']");
                var brand_name = form.find("input[name='brand_name']");
                var brand_logo = form.find("input[name='brand_logo']");
                var fald = true;
                
                if(brand_name.val() == ""){
                    error_div("#brand_dialog input[name='brand_name']","品牌名称不能为空");
                    fald = false;
                }else if(brand_logo.val() == ""){
                    error_div("#brand_dialog input[name='brand_logo']","品牌LOGO不能为空");
                    fald = false;
                }else{
                    form.ajaxSubmit({
                        type: "POST",
                        dataType: "JSON",
                        url: "dialog.php?act=brand_insert",
                        data: {"action": "TemporaryImage"},
                        success: function (data) {
                            alert(data.message);
                        },
                        async: true  
                    });
                    
                    fald = true;
                }
                return fald;   
            },'brand_dialog');
        });     
    });
    
    //添加分类
    $(document).on("click","[ectype='ajaxCate']",function(){
        $.jqueryAjax('dialog.php', 'act=ajaxCate', function(data){
            goods_visual_desc("添加分类",1000,data.content,function(){
                var form = $("#cate_dialog").find("form[name='theForm']");
                var cat_name = form.find("input[name='cat_name']");
                var fald = true;
                
                if(cat_name.val() == ""){
                    error_div("#cate_dialog input[name='cat_name']","分类名称不能为空");
                    fald = false;
                }else{
                    form.ajaxSubmit({
                        type: "POST",
                        dataType: "JSON",
                        url: "dialog.php?act=cate_insert",
                        data: {"action": "TemporaryImage"},
                        success: function (data) {
                            alert(data.message);
                            if(data.error == 0){
                                $("#cate_add").html(data.content); 
                            }
                        },
                        async: true  
                    });
                    
                    fald = true;
                }
                return fald;   
            },'cate_dialog');
        });     
    });
    /* 异步添加各类信息 end */
