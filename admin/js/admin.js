// 表单验证
$(function(){
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
	sel_this.children('ul').show();// 点击分类展开
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
});




