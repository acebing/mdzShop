//地区三级联动调用
		// $.levelLink();

$(function(){
	/* jquery.ui tooltip.js title美化 */
	$("[data-toggle='tooltip']").tooltip({
		position: {
			my: "left top+5",
			at: "left bottom"
		}
	});
	
	/* jquery.ui tooltip.js 图片放大 */
	jQuery.tooltipimg = function(){
		$("[ectype='tooltip']").tooltip({
			content: function(){
				var element = $(this);
				var url = element.data("tooltipimg");
				if(element.is('[data-tooltipImg]')){
					return "<img src='" + url + "' />";
				}
			},
			position:{
				using:function(position,feedback){
					$(this).css(position).addClass("ui-tooltipImg");
				}
			}
		});
	}
	$.tooltipimg();
	//file移动上去的js
	$(".type-file-box").hover(function(){
		$(this).addClass("hover");
	},function(){
		$(this).removeClass("hover");
	});
	// 表单验证
	$("#submitBtn").click(function(){
		if($("#articlecat_form").valid()){
			$("#articlecat_form").submit();
		}
	});
	$('#articlecat_form').validate({
		errorPlacement:function(error, element){
			var error_div = element.parents('div.label_value').find('div.form_prompt');
			element.parents('div.label_value').find(".notic").hide();
			error_div.append(error);
		},
		rules : {
			name : {
				required : true
			},
			sort_order : {
				required : true
			}
			
		},
		messages : {
			name : {
				required : '<i class="icon icon-exclamation-sign"></i>'+"分类名称必填"
			},
			sort_order : {
				required : '<i class="icon icon-exclamation-sign"></i>'+"分类名称"
			}
		}
	});

// 点击获取文章分类内容及分类ID
$('.imitate_select').on('click', function(event) {
	var sel_this = $(this)
	sel_this.children('ul').show().perfectScrollbar();// 点击分类展开
	var _a =$('.imitate_select').find('a');
	_a.on('click', function(event) {
		 sel_this.children('div.cite').html($(this).html());// 点击获取分类列表获取内容
		 sel_this.children('input[type=hidden]').val($(this).attr('data-value'));// 点击获取分类列表获取分类id

		});
});	
// 点击空白处隐藏展开框
$(document).click(function(e){
	//会员搜索
	if(e.target.id !='user_name' && !$(e.target).parents("div").is(".select-container")){
		$('.selection_select .select-container').hide();
	}
	//卖场搜索
	if(e.target.id !='rs_name' && !$(e.target).parents("div").is(".select-container")){
		$('.rs_select .select-container').hide();
	}
	//品牌
	if(e.target.id !='brand_name' && !$(e.target).parents("div").is(".brand-select-container")){	
		$('.brand-select-container').hide();
		$('.brandSelect .brand-select-container').hide();
	}
	//分类
	if(e.target.id !='category_name' && !$(e.target).parents("div").is(".select-container")){
		$('.categorySelect .select-container').hide();
	}
	//仿select
	if(e.target.className !='cite' && !$(e.target).parents("div").is(".imitate_select")){
		$('.imitate_select ul').hide();
	}

});

//操作提示展开收起
$("#explanationZoom").on("click",function(){
	var explanation = $(this).parents(".explanation");
	var width = $(".layui-tab-content").width();
	if($(this).hasClass("shopUp")){
		$(this).removeClass("shopUp");
		$(this).attr("title","收起提示");
		explanation.find(".ex_tit").css("margin-bottom",10);
		explanation.animate({
			width:width-28
		},300,function(){
			$(".explanation").find("ul").show();
		});
	}else{
		$(this).addClass("shopUp");
		$(this).attr("title","提示相关设置操作时应注意的要点");
		explanation.find(".ex_tit").css("margin-bottom",0);
		explanation.animate({
			width:"100"
		},300);
		explanation.find("ul").hide();
	}
});



});




